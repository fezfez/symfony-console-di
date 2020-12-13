<?php

declare(strict_types=1);

namespace Fezfez\SymfonyDiConsole;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface Command
{
    public function execute(InputInterface $input, OutputInterface $ouput): int;
}
