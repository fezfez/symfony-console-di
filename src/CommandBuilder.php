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

class CommandBuilder
{
    /**
     * @param string $diConsoleCommand
     * @return BaseCommand
     */
    public static function build($diConsoleCommandClass)
    {
        if (is_string($diConsoleCommandClass) === false) {
            throw new InvalidCommandException(
                sprintf('Arg must be a string "%s" given', gettype($diConsoleCommandClass))
            );
        } elseif (class_exists($diConsoleCommandClass) === false) {
            throw new InvalidCommandException(
                sprintf('Class "%s" does not exist', $diConsoleCommandClass)
            );
        } elseif (is_subclass_of($diConsoleCommandClass, '\SymfonyDiConsole\SymfonyDiConsoleInterface') === false) {
            throw new InvalidCommandException(
                sprintf(
                    'Class "%s" must be instance of \SymfonyDiConsole\SymfonyDiConsoleInterface',
                    $diConsoleCommandClass
                )
            );
        }

        return new BaseCommand($diConsoleCommandClass);
    }
}
