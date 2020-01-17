<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand extends Command
{
    /**
     * @param OutputInterface $output
     * @param string $message
     */
    protected function comment(OutputInterface $output, string $message): void
    {
        $output->writeln('');
        $output->writeln("<comment>$message</comment>");
        $output->writeln('');
    }

    /**
     * @param OutputInterface $output
     * @param string $message
     */
    protected function error(OutputInterface $output, string $message): void
    {
        $output->writeln('');
        $output->writeln("<error>$message</error>");
        $output->writeln('');
    }

    /**
     * @param OutputInterface $output
     */
    protected function space(OutputInterface $output): void
    {
        $output->writeln('');
    }
}
