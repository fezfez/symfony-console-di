<?php

declare(strict_types=1);

namespace Fezfez\SymfonyDiConsole\Tests;

use Fezfez\SymfonyDiConsole\Command;
use Fezfez\SymfonyDiConsole\CommandDefinition;
use Fezfez\SymfonyDiConsole\CommandFactory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TestCommandFactory implements CommandFactory
{
    public function createCommand(ContainerInterface $container): Command
    {
        return new ACommand('hola');
    }

    public function configure(): CommandDefinition
    {
        $dto = new CommandDefinition('test', 'this is a sample');
        $dto->addArgument(new InputArgument('hi'));
        $dto->addOption(new InputOption('anoption'));

        return $dto;
    }
}
