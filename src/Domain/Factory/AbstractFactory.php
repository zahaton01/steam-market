<?php

namespace App\Domain\Factory;

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
