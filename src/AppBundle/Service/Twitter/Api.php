<?php

namespace AppBundle\Service\Twitter;

use Exception;
use TwitterAPIExchange;

class Api
{
    const GET = 'GET';
    const POST = 'POST';

    /**
     * @var string
     */
    private $oauthAccessToken;

    /**
     * @var string
     */
    private $oauthAccessTokenSecret;

    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @var string
     */
    private $consumerSecret;

    /**
     * @var TwitterAPIExchange
     */
    private $api;

    /**
     * Twitter constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->oauthAccessToken = $params['oauth_access_token'];
        $this->oauthAccessTokenSecret = $params['oauth_access_token_secret'];
        $this->consumerKey = $params['consumer_key'];
        $this->consumerSecret = $params['consumer_secret'];

        $this->initApi();
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

    protected function initApi()
    {
        $settings = array(
            'oauth_access_token' => $this->oauthAccessToken,
            'oauth_access_token_secret' => $this->oauthAccessTokenSecret,
            'consumer_key' => $this->consumerKey,
            'consumer_secret' => $this->consumerSecret
        );
        $this->api = new TwitterAPIExchange($settings);
    }
}