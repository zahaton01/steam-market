<?php

namespace App\Domain\Factory;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractFactory
{
    /**
     * @return \DateTime|null
     */
    protected function getCurrentDate()
    {
        try {
            return new \DateTime('now');
        } catch (\Exception $e) {
            return null;
        }
    }
}
