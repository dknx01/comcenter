<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class TwitterEntry
{
    /**
     * @var string
     * @MongoDB\String
     * @MongoDB\ObjectId
     * @MongoDB\Id(name="_id", strategy="Auto")
     */
    protected $id;

    /**
     * @var string
     * @MongoDB\String
     * @MongoDB\UniqueIndex
     */
    protected $twitterId;

    /**
     * @var string
     * @MongoDB\String
     */
    protected $text;

    /**
     * @var string
     * @MongoDB\String
     */
    protected $from;

    /**
     * @var string
     * @MongoDB\String
     */
    protected $fromImage;

    /**
     * @var int
     * @MongoDB\Int
     */
    protected $retweetCount;

    /**
     * @var int
     * @MongoDB\Int
     */
    protected $favoriteCount;

    /**
     * @return string
     * @MongoDB\String
     */
    public function getTwitterId()
    {
        return $this->twitterId;
    }

    /**
     * @param string $twitterId
     *
     * @return AppBundle\Document\TwitterEntry
     */
    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return AppBundle\Document\TwitterEntry
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     *
     * @return AppBundle\Document\TwitterEntry
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    /**
     * @return string
     */
    public function getFromImage()
    {
        return $this->fromImage;
    }

    /**
     * @param string $fromImage
     *
     * @return AppBundle\Document\TwitterEntry
     */
    public function setFromImage($fromImage)
    {
        $this->fromImage = $fromImage;
        return $this;
    }

    /**
     * @return int
     */
    public function getRetweetCount()
    {
        return $this->retweetCount;
    }

    /**
     * @param int $retweetCount
     *
     * @return AppBundle\Document\TwitterEntry
     */
    public function setRetweetCount($retweetCount)
    {
        $this->retweetCount = $retweetCount;
        return $this;
    }

    /**
     * @return int
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * @param int $favoriteCount
     *
     * @return AppBundle\Document\TwitterEntry
     */
    public function setFavoriteCount($favoriteCount)
    {
        $this->favoriteCount = $favoriteCount;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return AppBundle\Document\TwitterEntry
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}