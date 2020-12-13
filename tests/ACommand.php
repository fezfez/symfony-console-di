<?php

declare(strict_types=1);

namespace Fezfez\SymfonyDiConsole\Tests;

use Fezfez\SymfonyDiConsole\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ACommand implements Command
{
    private string $dependency;

    public function __construct(string $dependency)
    {
        $this->dependency = $dependency;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write($this->dependency . 'hola' . $input->getArgument('hi') . $input->getOption('anoption'));

        return 1;
    }
}
