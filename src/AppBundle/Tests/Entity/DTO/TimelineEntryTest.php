<?php

namespace AppBundle\Tests\Entity\DTO;

use AppBundle\Entity\DTO\TimelineEntry;
use PHPUnit_Framework_TestCase;
use stdClass;

class TimelineEntryTest extends PHPUnit_Framework_TestCase
{

    public function testTimelineEntryWithBasicData()
    {
        $entry = $this->createBasicEntry();

        $entry->user = $this->createUserObject();

        $actualEntry = new TimelineEntry($entry);
        $this->assertBasicProperties($actualEntry);
        $this->assertEquals(
            '@Bender Zoidberg was here @Fry https://example.com/mention2 https://example.com/mention1',
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
        $expectedText = '<span class="user_mention">@Bender</span> Zoidberg was here ' .
                    '<span class="user_mention">@Fry</span> https://example.com/mention2 https://example.com/mention1';
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
        $expectedText = '@Bender Zoidberg was here @Fry ' .
            '<a href="https://example.com/mention2Extended" alt="https://example.com/mention2Extended" ' .
            'class="url_mention" target="_blank">https://example.com/mention2</a> ' .
            '<a href="https://example.com/mention1Extended" alt="https://example.com/mention1Extended" ' .
            'class="url_mention" target="_blank">https://example.com/mention1</a>';
        $this->assertEquals($expectedText, $actualEntry->getText());
    }

    /**
     * @return stdClass
     */
    protected function createBasicEntry()
    {
        $entry = new stdClass();
        $entry->id_str = 'abc123';
        $entry->text = '@Bender Zoidberg was here @Fry https://example.com/mention2 https://example.com/mention1';
        $entry->retweet_count = 5;
        $entry->favorite_count = 10;
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
     * @param $actualEntry
     */
    protected function assertBasicProperties($actualEntry)
    {
        $this->assertEquals('abc123', $actualEntry->getId());
        $this->assertEquals(10, $actualEntry->getFavoriteCount());
        $this->assertEquals(5, $actualEntry->getRetweetCount());
        $this->assertEquals('http://exampl.com/profile.png', $actualEntry->getFromImage());
        $this->assertEquals('zoidberg', $actualEntry->getFrom());
    }
}
