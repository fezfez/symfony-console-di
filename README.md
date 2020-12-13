# symfony-console-di

[![Build Status](https://travis-ci.org/fezfez/symfony-console-di.svg?branch=master)](https://travis-ci.org/fezfez/symfony-console-di)
[![Code Coverage](https://scrutinizer-ci.com/g/fezfez/symfony-console-di/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/fezfez/symfony-console-di/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fezfez/symfony-console-di/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fezfez/symfony-console-di/?branch=master)


Symfony console with dependency injection capability and lazy loading

## Sample 

```php

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
```

```php

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
        echo 'Not call !';
        return new ACommand('hola');
    }

    public function configure(): CommandDefinition
    {
        echo 'call !';
        $dto = new CommandDefinition('test', 'this is a sample');
        $dto->addArgument(new InputArgument('hi'));
        $dto->addOption(new InputOption('anoption'));

        return $dto;
    }
}

```

```php
$application = new Application('My app');
$application->add(CommandBuilder::build(TestCommandFactory::class, $container));
$application->run();
// output : call !
```
