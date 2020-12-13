<?php

declare(strict_types=1);

namespace Fezfez\SymfonyDiConsole\Tests;

use Fezfez\SymfonyDiConsole\BaseCommandFactory;
use Fezfez\SymfonyDiConsole\InvalidCommand;
use Interop\Container\ContainerInterface as LaminasContainerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

class CommandBuilderTest extends TestCase
{
    public function testWithoutOption(): void
    {
        $sUT = BaseCommandFactory::build(TestCommandFactory::class, self::createMock(ContainerInterface::class));

        self::assertInstanceOf(Command::class, $sUT);
        self::assertSame('this is a sample', $sUT->getDescription());

        $output = self::createMock(NullOutput::class);
        $output->expects(self::once())->method('write')->with('holaholanot');

        self::assertSame(1, $sUT->run(new ArrayInput(['hi' => 'not'], $sUT->getDefinition()), $output));
    }

    public function testWithOption(): void
    {
        $sUT = BaseCommandFactory::build(TestCommandFactory::class, self::createMock(ContainerInterface::class));

        self::assertInstanceOf(Command::class, $sUT);
        self::assertSame('this is a sample', $sUT->getDescription());

        $output = self::createMock(NullOutput::class);
        $output->expects(self::once())->method('write')->with('holaholanotnot');

        self::assertSame(1, $sUT->run(new ArrayInput(['hi' => 'not', '--anoption' => 'not'], $sUT->getDefinition()), $output));
    }

    public function testLaminasStyle(): void
    {
        $sUT = (new TestCommandLaminasStyleFactory())->__invoke(self::createMock(LaminasContainerInterface::class), '');

        self::assertInstanceOf(Command::class, $sUT);
        self::assertSame('this is a sample', $sUT->getDescription());

        $output = self::createMock(NullOutput::class);
        $output->expects(self::once())->method('write')->with('holaholanotnot');

        self::assertSame(1, $sUT->run(new ArrayInput(['hi' => 'not', '--anoption' => 'not'], $sUT->getDefinition()), $output));
    }

    /** @return array<int, array<int, mixed>> */
    public function failClassProvider(): array
    {
        return [
            [ACommand::class, 'Class "Fezfez\SymfonyDiConsole\Tests\ACommand" must be instance of Fezfez\SymfonyDiConsole\CommandFactory'],
            ['fezfez', 'Class "fezfez" does not exist'],
        ];
    }

    /**
     * @dataProvider failClassProvider
     */
    public function testFail(string $className, string $expectedExceptionMessahe): void
    {
        self::expectException(InvalidCommand::class);
        self::expectExceptionMessage($expectedExceptionMessahe);

        BaseCommandFactory::build($className, self::createMock(ContainerInterface::class));
    }
}
