<?php

namespace AppBundle\Service\Twitter;

use Exception;
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
     * Twitter constructor.
     * @param TwitterAPIExchange $api
     */
    public function __construct(TwitterAPIExchange $api)
    {
        $this->api = $api;
    }

    /**
     * @param int $max
     * @return string
     * @throws Exception
     */
    public function getTimeline($max = 20)
    {
        $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
        return $this->api->setGetfield('?count=' . $max)
            ->buildOauth($url, self::GET)
            ->performRequest();
    }
}