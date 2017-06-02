<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Command\ParserCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ParserCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new ParserCommand());
        $command = $application->find('parser');
        $commandTester = new CommandTester($command);
        $commandTester->execute(
            [
            'command'  => $command->getName(),
            '--test' => '--test'
            ]
        );

        $output = $commandTester->getDisplay();
        $this->assertContains('произведено 4 записей', $output);
        $this->assertEquals(4, substr_count($output, 'html'));
    }
}
