<?php

declare(strict_types=1);

/**
 * This file is part of the Symfony Console DI package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fezfez\SymfonyDiConsole;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
    private CommandFactory $diConsoleCommandClass;
    private ContainerInterface $container;

    public function __construct(CommandFactory $diConsoleCommandClass, ContainerInterface $container)
    {
        $this->diConsoleCommandClass = $diConsoleCommandClass;
        $this->container             = $container;

        parent::__construct();
    }

    protected function configure(): void
    {
        $config = $this->diConsoleCommandClass->configure();

        $this->setDefinition($config->getDefinition())
             ->setDescription($config->getDescription())
             ->setName($config->getName());
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        return $this->diConsoleCommandClass->createCommand($this->container)->execute($input, $output);
    }
}
