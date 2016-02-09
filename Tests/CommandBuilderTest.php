<?php
/**
 * This file is part of the Symfony Console DI package.
 *
 * (c) Stéphane Demonchaux <demonchaux.stephane@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace SymfonyDiConsole\Tests;

use SymfonyDiConsole\SymfonyDiConsoleInterface;
use SymfonyDiConsole\SymfonyConsoleInterface;
use SymfonyDiConsole\SymfonyConsoleDiDto;
use SymfonyDiConsole\CommandBuilder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\NullOutput;

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
        return new ACommand('hola');
    }

    /**
     * @return SymfonyConsoleDiDto
    */
    public static function configure()
    {
        $dto = new SymfonyConsoleDiDto('test', 'this is a sample');
        $dto->addArgument('hi');
        $dto->addOption('anoption');

        return $dto;
    }
}

class TestCommandTwo implements SymfonyDiConsoleInterface
{
    /**
     * @return SymfonyDiConsoleInterface
     */
    public static function getInstance()
    {
        return new ACommand('hola');
    }

    /**
     * @return SymfonyConsoleDiDto
     */
    public static function configure()
    {
        $dto = new SymfonyConsoleDiDto();
        $dto->setName('test');
        $dto->setDescription('this is a sample');
        $dto->addArgument('hi');
        $dto->addOption('anoption');

        return $dto;
    }
}


class CommandBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testOk()
    {
        $sUT = CommandBuilder::build('\SymfonyDiConsole\Tests\TestCommand');

        $this->assertInstanceOf('Symfony\Component\Console\Command\Command', $sUT);

        $this->assertEquals('this is a sample', $sUT->getDescription());

        $output = $this->getMock('\Symfony\Component\Console\Output\NullOutput');
        $output->expects($this->once())
        ->method('write')
        ->with('holaholanot');

        $sUT->execute(new ArrayInput(array('hi' => 'not'), $sUT->getDefinition()), $output);
    }

    public function testOkWithDefinitionSetter()
    {
        $sUT = CommandBuilder::build('\SymfonyDiConsole\Tests\TestCommandTwo');

        $this->assertInstanceOf('Symfony\Component\Console\Command\Command', $sUT);

        $this->assertEquals('this is a sample', $sUT->getDescription());

        $output = $this->getMock('\Symfony\Component\Console\Output\NullOutput');
        $output->expects($this->once())
        ->method('write')
        ->with('holaholanot');

        $sUT->execute(new ArrayInput(array('hi' => 'not'), $sUT->getDefinition()), $output);
    }

    public function testOkWithOption()
    {
        $sUT = CommandBuilder::build('\SymfonyDiConsole\Tests\TestCommand');

        $this->assertInstanceOf('Symfony\Component\Console\Command\Command', $sUT);

        $this->assertEquals('this is a sample', $sUT->getDescription());

        $output = $this->getMock('\Symfony\Component\Console\Output\NullOutput');
        $output->expects($this->once())
        ->method('write')
        ->with('holaholanotnot');

        $sUT->execute(new ArrayInput(array('hi' => 'not', '--anoption' => 'not'), $sUT->getDefinition()), $output);
    }

    public function failClassProvider()
    {
        return array(
            array('\SymfonyDiConsole\Tests\ACommand'),
            array('fezfez'),
            array(true),
            array(new \stdClass())
        );
    }

    /**
     * @dataProvider failClassProvider
     */
    public function testFail($className)
    {
        $this->setExpectedException('\SymfonyDiConsole\InvalidCommandException');

        CommandBuilder::build($className);
    }
}
