<?php

namespace ZwitscherBundle\Service\Twitter;

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
     * @param null|int $sinceId
     * @return string
     * @throws Exception
     */
    public function getTimeline($max = 20, $sinceId = null)
    {
        $url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';

        /** @var TwitterAPIExchange $api */
        $api = $this->api->setGetfield('?count=' . $max);
        if (!is_null($sinceId)) {
            $api->setGetfield('&since_id=' . $sinceId);
        }
        $response = $api->buildOauth($url, self::GET)->performRequest();
        return $response;
    }
}