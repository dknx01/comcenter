<?php

namespace AppBundle\Service\Twitter;

use Exception;
use Psr\Log\LoggerInterface;
use TwitterAPIExchange;

class Api
{
    const GET = 'GET';
    const POST = 'POST';

    /**
     * @var TwitterAPIExchange
     */
    private $api;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Twitter constructor.
     * @param TwitterAPIExchange $api
     */
    public function __construct(TwitterAPIExchange $api, LoggerInterface $logger)
    {
        $this->api = $api;
        $this->logger = $logger;
    }

    /**
     * @param int $max
     * @return string
     * @throws Exception
     */
    public function getTimeline($max = 20)
    {
        $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        $response =  $this->api->setGetfield('?count=' . $max)
            ->buildOauth($url, self::GET)
            ->performRequest();
        return $response;
    }
}