<?php

namespace App\Application\Console\Command;

use App\Application\Logs\DB\Console\ConsoleDBLogger;
use App\Domain\Manager\BaseManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author  Anton Zakharuk <zahaton01@gmail.com>
 */
abstract class AbstractCommand extends Command
{
    /** @var ConsoleDBLogger  */
    protected $logger;
    /** @var OutputInterface */
    protected $output;
    /** @var BaseManager */
    protected $manager;
    /** @var \DateTime */
    protected $executionStart;

    /**
     * AbstractCommand constructor.
     * @param ConsoleDBLogger $logger
     * @param BaseManager $manager
     *
     * @throws \Exception
     */
    public function __construct(
        ConsoleDBLogger $logger,
        BaseManager $manager
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->manager = $manager;

        $this->output = null;
        $this->executionStart = new \DateTime('now');
    }

    /**
     * @param OutputInterface $output
     */
    protected function setOutput(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param string $message
     * @param array $extras
     */
    protected function comment(string $message, array $extras = []): void
    {
        $this->output->writeln("<comment>$message</comment>");
    }

    /**
     * @param string $message
     * @param array $extras
     */
    protected function error(string $message, array $extras = []): void
    {
        $this->output->writeln("<error>$message</error>");
        $this->logger->error($message);
    }

    /**
     * @param string $message
     * @param array $extras
     */
    protected function info(string $message, array $extras = []):void
    {
        $this->output->writeln("<info>$message</info>");
    }

    protected function space(): void
    {
        $this->output->writeln('');
    }

    /**
     * @return int
     *
     * @throws \Exception
     */
    protected function getExecutionTime()
    {
        return ((new \DateTime('now'))->getTimestamp()) - ($this->executionStart->getTimestamp());
    }
}
