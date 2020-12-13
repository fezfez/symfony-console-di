<?php

declare(strict_types=1);

namespace Fezfez\SymfonyDiConsole\Tests;

use Fezfez\SymfonyDiConsole\Command;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function is_string;

class ACommand implements Command
{
    private string $dependency;

    public function __construct(string $dependency)
    {
        $this->dependency = $dependency;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write($this->dependency . 'hola' . $this->getArgumentAsString($input, 'hi') . $this->getOptiontAsString($input, 'anoption'));

        return 1;
    }

    private function getArgumentAsString(InputInterface $input, string $name): string
    {
        $arg = $input->getArgument($name);

        if (! is_string($arg)) {
            throw new RuntimeException();
        }

        return $arg;
    }

    private function getOptiontAsString(InputInterface $input, string $name): string
    {
        $arg = $input->getOption($name);

        if (! is_string($arg)) {
            throw new RuntimeException();
        }

        return $arg;
    }
}
