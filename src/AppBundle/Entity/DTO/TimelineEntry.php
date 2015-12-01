<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 03.11.15 14:46
 * @package
 *
 */

namespace AppBundle\Entity\DTO;


use DateTime;
use stdClass;

class TimelineEntry
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
            $find = '@' . $mention->screen_name;
            $replace = '<a href="https://twitter.com/search?q=%40' .$mention->screen_name .
                '" target="_blank"  class="user_mention">' . $find . '</a>';
            $this->text = str_replace($find, $replace, $this->text);
        }
    }

    /**
     * @param array $urls
     */
    private function addUrls($urls)
    {
        foreach ($urls as $url) {
            $find = $url->url;
            $replace = '<a href="' . $url->expanded_url . '" alt="' . $url->expanded_url .
                '" class="url_mention" target="_blank">' . $find . '</a>';
            $this->text = str_replace($find, $replace, $this->text);
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
                $search = $media->url;
                $replace = '<a href="' . $media->expanded_url .'" target="blank"><img src="' . $media->media_url .':thumb" /></a>';
                $this->text = str_replace($search, $replace, $this->text);
            }
        }
    }

    /**
     * @param array $hashtags
     */
    private function addHashtags($hashtags)
    {
        foreach ($hashtags as $hashtag) {
            $search = '#' . $hashtag->text;
            $replace = '<a href="https://twitter.com/hashtag/' . $hashtag->text . '" class="twitter_hashtag">' .
                '#' . $hashtag->text . '</a>';
            $this->text = str_replace($search, $replace, $this->text);
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