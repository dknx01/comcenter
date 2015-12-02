<?php

namespace ZwitscherBundle\Command;

use ZwitscherBundle\Entity\TimelineCollection;
use ZwitscherBundle\Service\Twitter\Timeline;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Kernel;

class FetchFromTwitterCommandTest extends PHPUnit_Framework_TestCase
{
    public function testCommand()
    {
        /** @var Kernel|PHPUnit_Framework_MockObject_MockObject $kernel */
        $kernel = $this->getMock('Symfony\Component\HttpKernel\Kernel', array(), array(), '', false, false);

        $application = new Application($kernel);
        $application->add(new FetchFromTwitterCommand());

        $timelineCollection = new TimelineCollection();

        /** @var Timeline|PHPUnit_Framework_MockObject_MockObject $timeline*/
        $timeline = $this->getMockBuilder('ZwitscherBundle\Service\Twitter\Timeline')
            ->disableOriginalConstructor()
            ->getMock();
        $timeline->expects($this->once())
            ->method('getTimelineCollection')
            ->with(50)
            ->willReturn($timelineCollection);

        /** @var LoggerInterface|PHPUnit_Framework_MockObject_MockObject $logger */
        $logger = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $logger->expects($this->at(0))
            ->method('debug')
            ->with('Max results:50');
        $logger->expects($this->at(1))
            ->method('debug')
            ->with('Results:', $timelineCollection->getArrayCopy());

        $container = new Container();
        $container->set('commcenter.service.twitter.timeline', $timeline);
        $container->set('logger', $logger);

        /** @var FetchFromTwitterCommand $command */
        $command = $application->find('app:fetch_from_twitter_command');
        $command->setContainer($container);
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $display ='Start' . PHP_EOL . 'Fetched: ' . $timelineCollection->count() . PHP_EOL;
        $this->assertEquals($display, $commandTester->getDisplay());
    }

}
