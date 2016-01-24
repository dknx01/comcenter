<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 24.01.16 15:53
 * @package
 *
 */

namespace ShowNotesToZoidBundle\Tests\Command;


use PHPUnit_Framework_MockObject_MockObject;
use ShowNotesToZoidBundle\Command\ImportLavernaNotesCommand;
use ShowNotesToZoidBundle\Service\Note\ImportNotesService;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Kernel;

class ImportLavernaNotesCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCommand()
    {
        /** @var Kernel|PHPUnit_Framework_MockObject_MockObject $kernel */
        $kernel = $this->getMock('Symfony\Component\HttpKernel\Kernel', array(), array(), '', false, false);

        $application = new Application($kernel);
        $application->add(new ImportLavernaNotesCommand());


        /** @var ImportNotesService|PHPUnit_Framework_MockObject_MockObject $importService */
        $importService = $this->getMockBuilder('ShowNotesToZoidBundle\Service\Note\ImportNotesService')
            ->disableOriginalConstructor()
            ->getMock();
        $importService->expects($this->once())
            ->method('importNotesFromFile')
            ->willReturn(1);
        $container = new Container();
        $container->setParameter('shownotestozoid.paths.notes', realpath(__DIR__ . '/../Examples'));
        $container->set('show_notes_to_zoid.service_note.import_notes_service', $importService);

        /** @var ImportLavernaNotesCommand $command */
        $command = $application->find('show_notes_to_zoid:import_laverna_notes_command');
        $command->setContainer($container);

        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));
    }
}
