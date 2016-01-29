<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 03.11.15 14:46
 * @package
 *
 */

namespace ZwitscherBundle\Entity\DTO;

use DateTime;
use stdClass;

/**
 * Class TimelineEntryNew
 * @package ZwitscherBundle\Entity\DTO
 * @codeCoverageIgnore
 */
class TimelineEntryNew
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $textOriginal;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $fromImage;

    /**
     * @var int
     */
    private $retweetCount;

    /**
     * @var int
     */
    private $favoriteCount;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var array|TimelineEntity[]
     */
    private $replacements = array();

    /**
     * TimelineEntry constructor.
     * @param stdClass $entry
     */
    public function __construct(stdClass $entry)
    {
        $this->id = $entry->id_str;
        $this->text = $entry->text;
        $this->from = $entry->user->screen_name;
        $this->fromImage = $entry->user->profile_image_url;
        $this->retweetCount = $entry->retweet_count;
        $this->favoriteCount = $entry->favorite_count;
        $this->createdAt = new DateTime($entry->created_at);

        if (isset($entry->entities->user_mentions)) {
            $this->addUsermentions($entry->entities->user_mentions);
        }
        if (isset($entry->entities->urls)) {
            $this->addUrls($entry->entities->urls);
        }
        if (isset($entry->entities->media)) {
            $this->addMedia($entry->entities->media);
        }
        if (isset($entry->entities->hashtags)) {
            $this->addHashtags($entry->entities->hashtags);
        }

        $this->textOriginal = $this->text;
        foreach ($this->replacements as $replacement) {
            $this->text = str_replace($replacement->getSearch(), $replacement->getReplace(), $this->text);
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getFromImage()
    {
        return $this->fromImage;
    }

    /**
     * @return int
     */
    public function getRetweetCount()
    {
        return $this->retweetCount;
    }

    /**
     * @return int
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * @param array $user_mentions
     */
    private function addUsermentions($user_mentions)
    {
        foreach ($user_mentions as $mention) {
            $text = substr($this->getText(), $mention->indices[0], $mention->indices [1] - $mention->indices [0]);
            $entity = new TimelineEntity('usermention');
            $entity->setSearch($text);
            $entity->setReplace(
                '<a href="https://twitter.com/search?q=%40' . $mention->screen_name .
                '" target="_blank"  class="user_mention">' . $text . '</a>'
            );
            $this->replacements[] = $entity;
        }
    }

    /**
     * @param array $urls
     */
    private function addUrls($urls)
    {
        foreach ($urls as $url) {
            $text = substr($this->getText(), $url->indices[0], $url->indices [1] - $url->indices [0]);
            $entity = new TimelineEntity('url');
            $entity->setSearch($text);
            $entity->setReplace(
                '<a href="' . $url->expanded_url . '" alt="' . $url->expanded_url .
                '" class="url_mention" target="_blank">' . $text . '</a>'
            );
            $this->replacements[] = $entity;
        }
    }

    /**
     * @param array $medias
     */
    private function addMedia($medias)
    {
        /** @var stdClass $media */
        foreach ($medias as $media) {
            if ($media->type == 'photo') {
                $text = substr($this->getText(), $media->indices[0], $media->indices [1] - $media->indices [0]);
                $entity = new TimelineEntity('media');
                $entity->setSearch($text);
                $entity->setReplace(
                    '<a href="' . $media->expanded_url . '" target="blank"><img src="' . $media->media_url . ':thumb" /></a>'
                );
            }
//            if ($media->type == 'photo') {
//                $search = $media->url;
//                $replace = '<a href="' . $media->expanded_url .'" target="blank"><img src="' . $media->media_url .':thumb" /></a>';
//                $this->text = str_replace($search, $replace, $this->text);
//            }
        }
    }

    /**
     * @param array $hashtags
     */
    private function addHashtags($hashtags)
    {
        foreach ($hashtags as $hashtag) {
            $text = substr($this->getText(), $hashtag->indices[0], $hashtag->indices [1] - $hashtag->indices [0]);
            $entity = new TimelineEntity('hashtag');
            $entity->setSearch($text);
            $entity->setReplace(
              '<a href="https://twitter.com/hashtag/' . $hashtag->text . '" class="twitter_hashtag">' . $text . '</a>'
            );
            $this->replacements[] = $entity;
            $text = '';
        }
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}