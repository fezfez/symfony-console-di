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

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
    /**
     * @var string
     */
    private $diConsoleCommandClass;

    /**
     * @param string $command
     */
    public function __construct($diConsoleCommandClass)
    {
        $this->diConsoleCommandClass = $diConsoleCommandClass;

        parent::__construct();
    }

    /* (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::configure()
     */
    protected function configure()
    {
        $diConsoleCommandClass = $this->diConsoleCommandClass;
        $config                = $diConsoleCommandClass::configure();

        $this->setDefinition($config->getDefinition())
             ->setDescription($config->getDescription())
             ->setName($config->getName());
    }

    /* (non-PHPdoc)
     * @see \Symfony\Component\Console\Command\Command::execute()
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $diConsoleCommandClass = $this->diConsoleCommandClass;

        $diConsoleCommandClass::getInstance()->execute($input, $output);
    }
}
