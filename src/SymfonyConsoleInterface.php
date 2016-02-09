<?php
/**
 * This file is part of the Symfony Console DI package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SymfonyDiConsole;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface SymfonyConsoleInterface
{
    /**
     * @param InputInterface $input
     * @param OutputInterface $ouput
     */
    public function execute(InputInterface $input, OutputInterface $ouput);
}
