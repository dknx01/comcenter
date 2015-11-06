<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 03.11.15 14:46
 * @package
 *
 */

namespace AppBundle\Entity\DTO;


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

        if (isset($entry->entities->user_mentions)) {
            $this->addUsermentions($entry->entities->user_mentions);
        }
        if (isset($entry->entities->urls)) {
            $this->addUrls($entry->entities->urls);
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
            $replace = '<span class="user_mention">' . $find . '</span>';
            $this->text = str_replace($find, $replace, $this->text);
        }
    }

    /**
     * @param array $urls
     */
    private function addUrls($urls)
    {
        foreach ($urls as $mention) {
            $find = $mention->url;
            $replace = '<a href="' . $mention->expanded_url . '" alt="' . $mention->expanded_url . '" class="url_mention" target="_blank">' . $find . '</a>';
            $this->text = str_replace($find, $replace, $this->text);
        }
    }

}