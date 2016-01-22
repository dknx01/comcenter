<?php

namespace ZwitscherBundle\Entity\DTO;

use DateTime;
use PHPUnit_Framework_TestCase;
use stdClass;

class TimelineEntryNewTest extends PHPUnit_Framework_TestCase
{

    public function testTimelineEntryWithBasicData()
    {
        $entry = $this->createBasicEntry();

        $entry->user = $this->createUserObject();

        $actualEntry = new TimelineEntry($entry);
        $this->assertBasicProperties($actualEntry);
        $this->assertEquals(
            '@Bender Zoidberg https://example.com/media1 was here@Fry ' .
            'https://example.com/mention2 https://example.com/mention1 #ME',
            $actualEntry->getText()
        );
    }

    public function testTimelineEntryWithUsermentions()
    {
        $entry = $this->createBasicEntry();

        $entry->user = $this->createUserObject();

        $userMention1 = new stdClass();
        $userMention1->screen_name = 'Bender';
        $userMention2 = new stdClass();
        $userMention2->screen_name = 'Fry';

        $userMentions = array($userMention1, $userMention2);

        $entry->entities->user_mentions = $userMentions;

        $actualEntry = new TimelineEntry($entry);
        $this->assertBasicProperties($actualEntry);
        $expectedText = '<a href="https://twitter.com/search?q=%40Bender" target="_blank"  class="user_mention">' .
            '@Bender</a> Zoidberg https://example.com/media1 was here' .
            '<a href="https://twitter.com/search?q=%40Fry" target="_blank"  class="user_mention">@Fry</a> ' .
            'https://example.com/mention2 https://example.com/mention1 #ME';
        $this->assertEquals($expectedText, $actualEntry->getText());
    }

    public function testTimelineEntryWithUrls()
    {
        $entry = $this->createBasicEntry();

        $entry->user = $this->createUserObject();

        $firstUrl = new stdClass();
        $firstUrl->url = 'https://example.com/mention1';
        $firstUrl->expanded_url = 'https://example.com/mention1Extended';
        $secondUrl = new stdClass();
        $secondUrl->url = 'https://example.com/mention2';
        $secondUrl->expanded_url = 'https://example.com/mention2Extended';

        $urls = array($firstUrl, $secondUrl);

        $entry->entities->urls = $urls;

        $actualEntry = new TimelineEntry($entry);
        $this->assertBasicProperties($actualEntry);
        $expectedText = '@Bender Zoidberg https://example.com/media1 was here@Fry ' .
            '<a href="https://example.com/mention2Extended" alt="https://example.com/mention2Extended" ' .
            'class="url_mention" target="_blank">https://example.com/mention2</a> ' .
            '<a href="https://example.com/mention1Extended" alt="https://example.com/mention1Extended" ' .
            'class="url_mention" target="_blank">https://example.com/mention1</a> #ME';
        $this->assertEquals($expectedText, $actualEntry->getText());
    }

    public function testTimelineEntryWithMedia()
    {
        $entry = $this->createBasicEntry();

        $entry->user = $this->createUserObject();

        $firstMedia = new stdClass();
        $firstMedia->type = 'photo';
        $firstMedia->url = 'https://example.com/media1';
        $firstMedia->expanded_url = 'https://example.com/media1Extended';
        $firstMedia->media_url = 'http://example.com/media_url.jpg';

        $medias = array($firstMedia);

        $entry->entities->media = $medias;

        $actualEntry = new TimelineEntry($entry);
        $this->assertBasicProperties($actualEntry);
        $expectedText = '@Bender Zoidberg <a href="https://example.com/media1Extended" target="blank">' .
            '<img src="http://example.com/media_url.jpg:thumb" /></a> was here@Fry ' .
            'https://example.com/mention2 https://example.com/mention1 #ME';
        $this->assertEquals($expectedText, $actualEntry->getText());
    }

    public function testTimelineEntryWithHashtags()
    {
        $entry = $this->createBasicEntry();

        $entry->user = $this->createUserObject();

        $firstHashtag = new stdClass();
        $firstHashtag->text = 'ME';

        $medias = array($firstHashtag);

        $entry->entities->hashtags = $medias;

        $actualEntry = new TimelineEntry($entry);
        $this->assertBasicProperties($actualEntry);
        $expectedText = '@Bender Zoidberg https://example.com/media1 was here@Fry ' .
            'https://example.com/mention2 https://example.com/mention1 ' .
            '<a href="https://twitter.com/hashtag/ME" class="twitter_hashtag">#ME</a>';
        $this->assertEquals($expectedText, $actualEntry->getText());
    }

    /**
     * @return stdClass
     */
    protected function createBasicEntry()
    {
        $entry = new stdClass();
        $entry->id_str = 'abc123';
        $entry->text = '@Bender Zoidberg https://example.com/media1 was here' .
            '@Fry https://example.com/mention2 https://example.com/mention1 #ME';
        $entry->retweet_count = 5;
        $entry->favorite_count = 10;
        $entry->created_at = '2015-12-01 10:00:00';
        $entry->entities = new stdClass();

        return $entry;
    }

    /**
     * @return stdClass
     */
    protected function createUserObject()
    {
        $user = new stdClass();
        $user->screen_name = 'zoidberg';
        $user->profile_image_url = 'http://exampl.com/profile.png';
        return $user;
    }

    /**
     * @param TimelineEntry $actualEntry
     */
    protected function assertBasicProperties(TimelineEntry $actualEntry)
    {
        $this->assertEquals('abc123', $actualEntry->getId());
        $this->assertEquals(10, $actualEntry->getFavoriteCount());
        $this->assertEquals(5, $actualEntry->getRetweetCount());
        $this->assertEquals('http://exampl.com/profile.png', $actualEntry->getFromImage());
        $this->assertEquals('zoidberg', $actualEntry->getFrom());
        $this->assertEquals(new DateTime('2015-12-01 10:00:00'), $actualEntry->getCreatedAt());
    }
}
