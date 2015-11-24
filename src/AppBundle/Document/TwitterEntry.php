<?php

namespace AppBundle\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="AppBundle\Repository\TwitterRepository")
 */
class TwitterEntry
{
    const DATEFORMAT = 'D M d H:i:s O Y';

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
     * @var DateTime
     * @MongoDB\Date
     */
    protected $createdAt;

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
     * @return TwitterEntry
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
     * @return TwitterEntry
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
     * @return TwitterEntry
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
     * @return TwitterEntry
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
     * @return TwitterEntry
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
     * @return TwitterEntry
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
     * @return TwitterEntry
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime  $createdAt
     *
     * @return TwitterEntry
     */
    public function setCreatedAt(DateTime $createdAt)
    {

        $this->createdAt = $createdAt;
        return $this;
    }
}