# symfony-console-di

[![Build Status](https://travis-ci.org/fezfez/symfony-console-di.svg?branch=master)](https://travis-ci.org/fezfez/symfony-console-di)
[![Code Coverage](https://scrutinizer-ci.com/g/fezfez/symfony-console-di/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/fezfez/symfony-console-di/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fezfez/symfony-console-di/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fezfez/symfony-console-di/?branch=master)


Symfony console with dependency injection capability and lazy loading

## Sample 

```php

use SymfonyDiConsole\SymfonyDiConsoleInterface;
use SymfonyDiConsole\SymfonyConsoleInterface;
use SymfonyDiConsole\SymfonyConsoleDiDto;
use SymfonyDiConsole\CommandBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Application;

class ACommand implements SymfonyConsoleInterface
{
    private $adependency;
    public function __construct($adependency)
    {
        $this->adependency = $adependency;
    }
    /**
     * @param InputInterface $input
     * @param OutputInterface $ouput
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write($this->adependency . 'hola' . $input->getArgument('hi') . $input->getOption('anoption'));
    }
}

class TestCommand implements SymfonyDiConsoleInterface
{
    /**
     * @return SymfonyDiConsoleInterface
     */
    public static function getInstance()
    {
        echo 'Not call !';
        return new ACommand('hola');
    }
    /**
     * @return SymfonyConsoleDiDto
    */
    public static function configure()
    {
        echo 'call !';
        $dto = new SymfonyConsoleDiDto('test', 'this is a sample');
        $dto->addArgument('hi');
        $dto->addOption('anoption');
        return $dto;
    }
}

$application = new Application('My app');
$application->add(CommandBuilder::build('TestCommand'));

$output = new ConsoleOutput();
$input  = new ArgvInput();

$cli->run($input, $output);
// output : call !
```
