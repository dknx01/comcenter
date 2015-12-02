<?php

namespace ZwitscherBundle\Document\Subdocument;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\EmbeddedDocument
 */
class OriginalData
{
    /**
     * @var string
     * @MongoDB\String
     */
    protected $text;

    /**
     * @var array
     * @MongoDB\Collection
     */
    protected $hashes = array();

    /**
     * @var array
     * @MongoDB\Collection
     */
    protected $mentions = array();

    /**
     * @var array
     * @MongoDB\Collection
     */
    protected $media = array();

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return OriginalData
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return array
     */
    public function getHashes()
    {
        return $this->hashes;
    }

    /**
     * @param mixed $hashValue
     * @return OriginalData
     */
    public function addHash($hashValue)
    {
        $this->hashes[] = $hashValue;
        return $this;
    }

    /**
     * @return array
     */
    public function getMentions()
    {
        return $this->mentions;
    }

    /**
     * @param mixed $mentionValue
     * @return OriginalData
     */
    public function addMention($mentionValue)
    {
        $this->mentions[] = $mentionValue;
        return $this;
    }

    /**
     * @return array
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param mixed $media
     * @return OriginalData
     */
    public function addMedia($media)
    {
        $this->media[] = $media;
        return $this;
    }
}