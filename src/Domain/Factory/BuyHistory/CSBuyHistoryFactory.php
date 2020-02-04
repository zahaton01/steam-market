<?php

namespace App\Domain\Factory\BuyHistory;

use App\Application\Resources\API\TM\Proto\Buy\CS\BoughtProto;
use App\Domain\Entity\BuyHistory\CSBuyHistory;
use App\Domain\Entity\Decision\CSBuyingDecision;

/**
 * @author Anton Zakharuk <zahaton01@gmail.com>
 */
class CSBuyHistoryFactory
{
    /**
     * @param BoughtProto $proto
     * @param CSBuyingDecision $decision
     *
     * @return CSBuyHistory
     */
    public function create(?BoughtProto $proto, CSBuyingDecision $decision)
    {
        $history = new CSBuyHistory();
        $history
            ->setDecision($decision);
            //->setCustomId($proto->getCustomId())
            //->setItemId($proto->getItemId());

        return $history;
    }
}
