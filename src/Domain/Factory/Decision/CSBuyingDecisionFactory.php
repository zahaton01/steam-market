<?php

namespace App\Domain\Factory\Decision;

use App\Application\Resources\API\TM\Util\CSItemUtil;
use App\Application\Tools\DecisionMaker\Decision\Decision;
use App\Domain\Entity\Decision\CSBuyingDecision;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSBuyingDecisionFactory
{
    /**
     * @param Decision $decision
     *
     * @return CSBuyingDecision
     */
    public function createFromDecision(Decision $decision): CSBuyingDecision
    {
        $decisionEntity = new CSBuyingDecision();
        $decisionEntity
            ->setInstance($decision->getResult()->getInstance())
            ->setHashName($decision->getResult()->getHashName())
            ->setStatus($decision->isApproved())
            ->setMinSellPrice($decision->getResult()->getMinSellPrice())
            ->setBuyPrice($decision->getResult()->getBuyPrice())
            ->setLink(CSItemUtil::instanceLink($decision->getResult()->getInstance()));

        if ($decision->isDeclined()) {
            $decisionEntity->setDeclineReason($decision->getResult()->getReason());
        }

        return $decisionEntity;
    }
}
