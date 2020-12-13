<?php

declare(strict_types=1);

namespace Fezfez\SymfonyDiConsole;

use Psr\Container\ContainerInterface;

interface CommandFactory
{
    public function createCommand(ContainerInterface $container): Command;

    public function configure(): CommandDefinition;
}
