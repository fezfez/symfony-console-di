<?php

declare(strict_types=1);

namespace Fezfez\SymfonyDiConsole;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class CommandDefinition
{
    private string $name;
    private string $description;
    private InputDefinition $definition;

    public function __construct(string $name, string $description)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->definition  = new InputDefinition();
    }

    public function addArgument(InputArgument ...$inputArgument): void
    {
        foreach ($inputArgument as $argument) {
            $this->definition->addArgument($argument);
        }
    }

    public function addOption(InputOption ...$inputOption): void
    {
        foreach ($inputOption as $option) {
            $this->definition->addOption($option);
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDefinition(): InputDefinition
    {
        return $this->definition;
    }
}
