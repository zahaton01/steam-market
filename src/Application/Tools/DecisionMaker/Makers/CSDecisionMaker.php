<?php

namespace App\Application\Tools\DecisionMaker\Makers;

use App\Application\Config\ConfigResolver;
use App\Application\Config\Items\CS\CSItemsConfig;
use App\Application\Exception\ApiResource\ApiResourceNotFound;
use App\Application\Exception\Config\ConfigInvokeFailed;
use App\Application\Exception\Config\ConfigNotFound;
use App\Application\Resources\API\TM\Exception\TMItemNotFound;
use App\Application\Resources\API\TM\Exception\TMRequestFailed;
use App\Application\Resources\API\TM\Proto\ItemInstances\CS\ItemInstancesProto;
use App\Application\Resources\API\TM\Proto\ItemInstances\CS\Model\ItemInstance;
use App\Application\Resources\API\TM\TMMarketplace;
use App\Application\Resources\ApiResourceResolver;
use App\Application\Tools\DecisionMaker\Decision\CS\CSTMBuyingApproved;
use App\Application\Tools\DecisionMaker\Decision\CS\CSTMBuyingDeclined;
use App\Application\Tools\DecisionMaker\Decision\Decision;
use App\Application\Tools\DecisionMaker\DecisionMakerInterface;
use App\Domain\Entity\CS\Steam\Price\OneMonthSteamPrice;
use App\Domain\Entity\CS\Steam\Price\OneWeekSteamPrice;
use App\Domain\Entity\CS\TM\CSTMPricing;
use App\Domain\Manager\BaseManager;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSDecisionMaker extends AbstractMaker implements DecisionMakerInterface
{
    /** @var CSItemsConfig  */
    private $config;

    /**
     * CSDecisionMaker constructor.
     * @param ConfigResolver $configResolver
     * @param BaseManager $manager
     * @param ApiResourceResolver $resourceResolver
     *
     * @throws ConfigInvokeFailed
     * @throws ConfigNotFound
     */
    public function __construct(BaseManager $manager, ApiResourceResolver $resourceResolver, ConfigResolver $configResolver)
    {
        parent::__construct($manager, $resourceResolver);

        $this->config = $configResolver->resolve(CSItemsConfig::class);
    }

    /**
     * @param string $hashName
     *
     * @return Decision
     *
     * @throws ApiResourceNotFound
     * @throws TMItemNotFound
     * @throws TMRequestFailed
     */
    public function shallWeBuyFromTM(string $hashName)
    {
        /** @var OneWeekSteamPrice $steamMonthPrice */
        $steamWeekPrice = $this->manager->getEntityManager()->getRepository(OneWeekSteamPrice::class)->getLast($hashName);
        /** @var OneMonthSteamPrice $steamMonthPrice */
        $steamMonthPrice = $this->manager->getEntityManager()->getRepository(OneMonthSteamPrice::class)->getLast($hashName);
        /** @var CSTMPricing $tmPricing */
        $tmPricing = $this->manager->getEntityManager()->getRepository(CSTMPricing::class)->getLastByHashName($hashName);
        /** @var TMMarketplace $tmMarketplace */
        $tmMarketplace = $this->resources->resolve(TMMarketplace::class);
        /** @var ItemInstancesProto $tmItemInstances */
        $tmItemInstances = $tmMarketplace->getCsItemInstances($hashName);

        if ( (null === $steamMonthPrice && null === $steamWeekPrice) || null === $tmPricing) {
            return $this->declined($hashName, 'Not enough data to make decision', null, null, null);
        }

        $steamPrice = $steamWeekPrice ?: $steamMonthPrice;

        $minInstancePrice = 0;
        $instanceWithMinPrice = null;
        foreach ($tmItemInstances->getInstances() as $index => $instance) {
            if ($index === 0) {
                $minInstancePrice = $instance->getPrice();
                $instanceWithMinPrice = $instance;
                continue;
            }

            if ($instance->getPrice() < $minInstancePrice) {
                $minInstancePrice = $instance->getPrice();
                $instanceWithMinPrice = $instance;
            }
        }

        if ($instanceWithMinPrice === null) {
            return $this->declined($hashName, 'None instances on marketplace', null, null, null);
        }

        if ($steamPrice->getSold() < 500) {
            return $this->declined($hashName, 'Low selling item', $instanceWithMinPrice, null, null);
        }

        $tmConfig = $tmMarketplace->getConfig();
        $minSellPrice = $minInstancePrice * (1 + (float) $tmConfig['commission']['sell'] + (float) $tmConfig['commission']['withdraw'] + (float) $_ENV['EXPECTED_PROFIT'] );

        if ($minSellPrice <= ($steamPrice->getMedian() * 1.1) && $minSellPrice <= ($tmPricing->getAverage() * 1.1)) {

            $sellsCount = 0;
            foreach ($tmPricing->getSells() as $sell) {
                if ($sell->getPrice() >= $minSellPrice) {
                    $sellsCount++;
                }
            }

            if ($sellsCount > 5) { // at least five times this item was sold with minSellPrice
                return $this->approved($hashName, $instanceWithMinPrice, $minSellPrice, $minInstancePrice);
            }
        }

        return $this->declined($hashName, 'Bad price', $instanceWithMinPrice, $minSellPrice, $minInstancePrice);
    }

    /**
     * @param string $hashName
     * @param ItemInstance $instance
     * @param float $minSellPrice
     * @param float $buyPrice
     *
     * @return Decision
     */
    private function approved(string $hashName, ItemInstance $instance, ?float $minSellPrice, ?float $buyPrice)
    {
        $decision = new Decision();

        $approved = new CSTMBuyingApproved();
        $approved
            ->setInstance($instance->getInstance())
            ->setMinSellPrice($minSellPrice)
            ->setBuyPrice($buyPrice)
            ->setHashName($hashName);

        $decision
            ->setStatus(true)
            ->setResult($approved);

        return $decision;
    }

    /**
     * @param string $hashName
     * @param string $reason
     * @param ItemInstance|null $instance
     * @param float $minSellPrice
     * @param float $buyPrice
     *
     * @return Decision
     */
    private function declined(string $hashName, string $reason, ?ItemInstance $instance, ?float $minSellPrice, ?float $buyPrice)
    {
        $decision = new Decision();

        $declined = new CSTMBuyingDeclined();
        $declined
            ->setReason($reason)
            ->setBuyPrice($buyPrice)
            ->setMinSellPrice($minSellPrice)
            ->setInstance($instance ? $instance->getInstance() : '')
            ->setHashName($hashName);

        $decision
            ->setStatus(false)
            ->setResult($declined);

        return $decision;
    }
}
