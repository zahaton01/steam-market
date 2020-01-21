<?php

namespace App\Command\Config\Buying\CS;

use App\Command\AbstractCommand;
use App\Entity\CS\CSItem;

abstract class AbstractBuyingCommand extends AbstractCommand
{
    /**
     * @param string $hashName
     *
     * @return bool
     */
    protected function censor(string $hashName)
    {
        $censors = explode(',', $_ENV['CENSOR_CS_NAMES']);

        foreach ($censors as $censor) {
            if (!empty($censor)) {
                if (strpos($hashName, $censor) !== false) {
                    return false;
                }
            }
        }

        return true;
    }


    /**
     * @param CSItem $item
     *
     * @return CSItem
     */
    protected function enableForBuying(CSItem $item): CSItem
    {
        $item->setIsAllowedForBuying(true);
        return $this->manager->save($item);
    }


    /**
     * @param CSItem $item
     *
     * @return CSItem
     */
    protected function disableForBuying(CSItem $item): CSItem
    {
        $item->setIsAllowedForBuying(false);
        return $this->manager->save($item);
    }
}
