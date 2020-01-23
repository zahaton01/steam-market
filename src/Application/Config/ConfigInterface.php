<?php

namespace App\Application\Config;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
interface ConfigInterface
{
    /**
     * Method must implement config resolving from any resource and initialize the class
     *
     * @param string $projectDir
     *
     * @return self
     */
    public function __invoke(string $projectDir): ConfigInterface;

    /**
     * Return config's class
     *
     * @return string
     */
    public function getClass(): string;
}