<?php

namespace ZwitscherBundle\Service;

use ZwitscherBundle\Repository\NotesRepository;
use ZwitscherBundle\Service\Twitter\Api;
use ZwitscherBundle\Service\Twitter\Timeline;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class TimelineTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var Timeline|PHPUnit_Framework_MockObject_MockObject
     */
    protected $timelineService;

    /**
     * @var Api|PHPUnit_Framework_MockObject_MockObject
     */
    private $twitterApi;

    /**
     * @var TwitterRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $twitterRepo;

    public function setUp()
    {
        $this->twitterApi = $this->getMockBuilder('ZwitscherBundle\Service\Twitter\Api')
            ->disableOriginalConstructor()
            ->getMock();
        $this->twitterRepo = $this->getMockBuilder('ZwitscherBundle\Repository\TwitterRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $this->timelineService = new Timeline($this->twitterApi, $this->twitterRepo);
    }

    public function testGetTimelineCollection()
    {
        $this->expectationApiTimeline();
        $this->expectationRepoLastId();
        $this->twitterRepo->expects($this->exactly(2))
            ->method('findByTwitterId')
            ->willReturn(null);
        $this->twitterRepo->expects($this->exactly(2))
            ->method('save')
            ->with($this->isInstanceOf('ZwitscherBundle\Document\TwitterEntry'));

        $result = $this->timelineService->getTimelineCollection();
        $this->assertInstanceOf('\ZwitscherBundle\Entity\TimelineCollection', $result);
        $this->assertEquals(2, $result->count());
    }

    public function testGetTimelineArray()
    {
        $this->expectationApiTimeline(20, null);
        $this->twitterRepo->expects($this->never())
            ->method('findByTwitterId');
        $this->twitterRepo->expects($this->never())
            ->method('save');

        $result = $this->timelineService->getTimelineArray();
        $this->assertInternalType('array', $result);
        $this->assertEquals(2, count($result));
    }

    /**
     * @param int $max
     * @param int $sinceId
     */
    protected function expectationApiTimeline($max = 50, $sinceId = 123)
    {
        $twitterJson = file_get_contents(realpath(__DIR__) . '/twitterTimelineResponse.json');
        $this->twitterApi->expects($this->once())
            ->method('getTimeline')
            ->with($max, $sinceId)
            ->willReturn($twitterJson);
    }

    protected function expectationRepoLastId()
    {
        $this->twitterRepo->expects($this->once())
            ->method('getLastId')
            ->willReturn(123);
    }
}
