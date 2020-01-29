<?php

namespace App\Application\Console\Command\Config;

use App\Application\Config\ConfigResolver;
use App\Application\Console\Command\AbstractCommand;
use App\Application\Exception\Config\ConfigInvokeFailed;
use App\Application\Exception\Config\ConfigNotFound;
use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Domain\Manager\BaseManager;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractConfigCommand extends AbstractCommand
{
    /** @var ConfigResolver  */
    protected $config;

    /**
     * AbstractConfigCommand constructor.
     * @param ConsoleDBLogger $logger
     * @param BaseManager $manager
     * @param ConfigResolver $config
     *
     * @throws \Exception
     */
    public function __construct(ConsoleDBLogger $logger, BaseManager $manager, ConfigResolver $config)
    {
        parent::__construct($logger, $manager);

        $this->config = $config;
    }
}
