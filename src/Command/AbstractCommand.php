<?php

namespace App\Command;

use App\Entity\CommandOutput;
use App\Factory\CommandOutputFactory;
use App\Logs\CommandLogService;
use App\Manager\BaseManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    /** @var CommandLogService  */
    protected $logger;
    /** @var OutputInterface */
    protected $output;
    /** @var CommandOutputFactory */
    protected $commandOutputFactory;
    /** @var BaseManager */
    protected $manager;

    public function __construct(
        CommandLogService $logger,
        CommandOutputFactory $commandOutputFactory,
        BaseManager $manager
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->output = null;
        $this->commandOutputFactory = $commandOutputFactory;
        $this->manager = $manager;
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
        $this->message($message, CommandOutput::LEVEL_COMMENT, $extras);
    }

    /**
     * @param string $message
     * @param array $extras
     */
    protected function spacedComment(string $message, array $extras = []): void
    {
        $this->space();
        $this->message($message, CommandOutput::LEVEL_COMMENT, $extras);
        $this->space();
    }

    /**
     * @param string $message
     * @param array $extras
     */
    protected function error(string $message, array $extras = []): void
    {
        $this->message($message, CommandOutput::LEVEL_ERROR, $extras);

        $this->logger->error($message);
    }

    /**
     * @param string $message
     * @param array $extras
     */
    protected function spacedError(string $message, array $extras = []): void
    {
        $this->space();
        $this->message($message, CommandOutput::LEVEL_ERROR, $extras);
        $this->space();

        $this->logger->error($message);
    }

    /**
     * @param string $message
     * @param array $extras
     */
    protected function info(string $message, array $extras = []):void
    {
        $this->message($message, CommandOutput::LEVEL_INFO, $extras);
    }

    /**
     * @param string $message
     * @param array $extras
     */
    protected function spacedInfo(string $message, array $extras = []):void
    {
        $this->space();
        $this->message($message, CommandOutput::LEVEL_INFO, $extras);
        $this->space();
    }

    protected function space(): void
    {
        $this->output->writeln('');
    }

    /**
     * @param string $message
     * @param string $level
     * @param array $extras
     */
    private function message(string $message, string $level, array $extras = []): void
    {
        $commandOutput = $this->commandOutputFactory->create($this->getName(), $message, $level, $extras);
        $this->manager->save($commandOutput);

        switch ($level) {
            case CommandOutput::LEVEL_ERROR:
                $this->output->writeln("<error>$message</error>");
                break;
            case CommandOutput::LEVEL_COMMENT:
                $this->output->writeln("<comment>$message</comment>");
                break;
            default:
                $this->output->writeln("<info>$message</info>");
                break;
        }
    }
}
