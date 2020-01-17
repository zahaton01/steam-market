<?php

namespace App\Service;

use App\Model\Decision;
use App\Model\Steam\CSGO\SteamCSGOItem;
use App\Model\TMMarketplace\CSGO\TMCSGOItemCurrentInstance;
use App\Service\TMMarketplace\TMCSGOMarketplace;
use Symfony\Component\Console\Output\OutputInterface;

class DecisionMaker
{
    private const APPROVE_DECISION_POINTS = 3;

    /** @var TMCSGOMarketplace  */
    private $TMCSGOMarketplace;
    /** @var CalculationService  */
    private $calculation;

    /**
     * DecisionMaker constructor.
     *
     * @param TMCSGOMarketplace $TMCSGOMarketplace
     * @param CalculationService $calculation
     */
    public function __construct(TMCSGOMarketplace $TMCSGOMarketplace, CalculationService $calculation)
    {
        $this->TMCSGOMarketplace = $TMCSGOMarketplace;
        $this->calculation = $calculation;
    }

    /**
     * @param SteamCSGOItem $item
     * @param TMCSGOItemCurrentInstance $instance
     *
     * @return Decision
     */
    public function shallWeBuyThisCSGOItem(SteamCSGOItem $item, TMCSGOItemCurrentInstance $instance)
    {
        $minSellPrice = $this->calculation->getCSGOItemMinSellPrice($item);
        $decision = new Decision();
        $decision
            ->setMinSellPrice($minSellPrice)
            ->setStatus(false);


        if ($minSellPrice < (int) $_ENV['CS_GO_MIN_BUY'] || $minSellPrice > $_ENV['CS_GO_MAX_BUY']) {
            $decision
                ->setMessage('Item is more expensive than MIN_BUY price and lower than MAX_BUY price');

            return $decision;
        }

        try {
            $details = $this->TMCSGOMarketplace->retrieveDetails($instance->getHashName());

            if ($minSellPrice < $details['average']) {
                $decision
                    ->setMessage('Item is lower than average price')
                    ->setStatus(true);

                return $decision;
            }

            $points = 0;
            foreach ($details['history'] as $historyItem) {
                if ($historyItem[1] > $minSellPrice) {
                    $points++;
                }
            }

            if ($points >= self::APPROVE_DECISION_POINTS) {
                $decision
                    ->setMessage('Item is lower than average price')
                    ->setStatus(true);
            }


        } catch (\Exception $e) {
            $decision->setMessage('TMMarketplace request error: ' . $e->getMessage());

            return $decision;
        }

        return $decision;
    }
}
