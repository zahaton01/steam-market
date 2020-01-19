<?php

namespace App\Factory;

use App\Entity\CommandOutput;

class CommandOutputFactory
{
    public function create(string $command, string $message, string $level, array $extras = []): CommandOutput
    {
        $output = new CommandOutput();
        $output
            ->setCreationDate(new \DateTime())
            ->setMessage($message)
            ->setLevel($level)
            ->setCommand($command)
            ->setExtras($extras);

        return $output;
    }
}