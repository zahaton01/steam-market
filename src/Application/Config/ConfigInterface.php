<?php

namespace App\Application\Config;

use App\Application\Exception\Config\ConfigInvokeFailed;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
interface ConfigInterface
{
    /**
     * Method must implement config resolving from any resource and initialize the class
     *
     * @return self
     *
     * @throws ConfigInvokeFailed
     */
    public function __invoke(): ConfigInterface;
}