<?php

namespace AppBundle\Service\Twitter;

class Twitter
{
    private $oauthAccessToken;
    private $oauthAccessTokenSecret;
    private $consumerKey;
    private $consumerSecret;

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
    }
}