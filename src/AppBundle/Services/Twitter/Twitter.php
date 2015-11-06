<?php

namespace AppBundle\Services\Twitter;

class Twitter
{

    /**
     * Twitter constructor.
     */
    public function __construct($oAuthAccessToken, $oAuthAccessTokenSecret, $consumerKey, $consumerSecret)
    {
        $this->oauthAccessToken =$oAuthAccessToken;
        $this->oauthAccessTokenSecret = $oAuthAccessTokenSecret;
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }
}