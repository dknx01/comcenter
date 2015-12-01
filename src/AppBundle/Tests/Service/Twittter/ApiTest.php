<?php

namespace AppBundle\Service\Twittter    ;

use AppBundle\Service\Twitter\Api;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use TwitterAPIExchange;

class ApiTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var TwitterAPIExchange|PHPUnit_Framework_MockObject_MockObject
     */
    private $api;

    public function setUp()
    {
        $this->api = $this->getMockBuilder('TwitterAPIExchange')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testGetTimelineWithoutSinceId()
    {
        $this->api->expects($this->once())
            ->method('setGetfield')
            ->with('?count=20')
            ->willReturnSelf();
        $this->api->expects($this->once())
            ->method('buildOauth')
            ->with('https://api.twitter.com/1.1/statuses/home_timeline.json', Api::GET)
            ->willReturnSelf();
        $responseJson ='[{twitter:"api"}]';
        $this->api->expects($this->once())
            ->method('performRequest')
            ->willReturn($responseJson);

        $logger = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $api = new Api($this->api, $logger);
        $this->assertEquals($responseJson, $api->getTimeline());
    }

    public function testGetTimelineWithSinceId()
    {
        $this->api->expects($this->at(0))
            ->method('setGetfield')
            ->with('?count=20')
            ->willReturnSelf();
        $this->api->expects($this->at(1))
            ->method('setGetfield')
            ->with('&since_id=123')
            ->willReturnSelf();
        $this->api->expects($this->once())
            ->method('buildOauth')
            ->with('https://api.twitter.com/1.1/statuses/home_timeline.json', Api::GET)
            ->willReturnSelf();
        $responseJson ='[{twitter:"api"}]';
        $this->api->expects($this->once())
            ->method('performRequest')
            ->willReturn($responseJson);

        $logger = $this->getMockBuilder('Psr\Log\LoggerInterface')
            ->disableOriginalConstructor()
            ->getMock();
        $api = new Api($this->api, $logger);
        $this->assertEquals($responseJson, $api->getTimeline(20, 123));
    }
}
