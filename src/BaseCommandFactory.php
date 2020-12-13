<?php

declare(strict_types=1);

namespace Fezfez\SymfonyDiConsole;

use Psr\Container\ContainerInterface;

use function class_exists;
use function is_subclass_of;
use function sprintf;

class BaseCommandFactory
{
    public static function build(string $diConsoleCommandClass, ContainerInterface $container): BaseCommand
    {
        if (class_exists($diConsoleCommandClass) === false) {
            throw new InvalidCommand(
                sprintf('Class "%s" does not exist', $diConsoleCommandClass)
            );
        }

        if (is_subclass_of($diConsoleCommandClass, CommandFactory::class) === false) {
            throw new InvalidCommand(
                sprintf(
                    'Class "%s" must be instance of %s',
                    $diConsoleCommandClass,
                    CommandFactory::class
                )
            );
        }

        return new BaseCommand(new $diConsoleCommandClass(), $container);
    }
}
