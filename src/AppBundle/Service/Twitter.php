<?php

namespace AppBundle\Service;

use TwitterAPIExchange;

class Twitter
{
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
     * @param $oAuthAccessToken
     * @param $oAuthAccessTokenSecret
     * @param $consumerKey
     * @param $consumerSecret
     */
    public function __construct($oAuthAccessToken, $oAuthAccessTokenSecret, $consumerKey, $consumerSecret)
    {
        $this->oauthAccessToken =$oAuthAccessToken;
        $this->oauthAccessTokenSecret = $oAuthAccessTokenSecret;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;

        $this->initApi();
    }

    public function getTimeline()
    {
        return $this->api->buildOauth('https://api.twitter.com/1.1/statuses/home_timeline.json', 'GET')
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