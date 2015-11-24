<?php

namespace AppBundle\Service\Twitter;

use AppBundle\Document\Subdocument\OriginalData;
use AppBundle\Document\TwitterEntry;
use AppBundle\Entity\DTO\TimelineEntry;
use AppBundle\Entity\TimelineCollection;
use AppBundle\Repository\TwitterRepository;
use stdClass;

class Timeline
{
    /**
     * @var Api
     */
    private $twitter;

    /**
     * @var array
     */
    private $timelineResult;

    /**
     * @var TwitterRepository
     */
    private $twitterRepo;

    /**
     * Timeline constructor.
     * @param Api $twitter
     * @param TwitterRepository $repository
     */
    public function __construct(Api $twitter, TwitterRepository $repository)
    {
        $this->twitter = $twitter;
        $this->twitterRepo = $repository;
    }

    /**
     * @param int $max
     * @return TimelineEntry[]|TimelineCollection
     */
    public function getTimelineCollection($max = 50)
    {
        $this->getTimelineFromApi($max, $this->twitterRepo->getLastId());

        $timeline = new TimelineCollection();
        foreach ($this->timelineResult as $entry) {
            $timelineEntry = new TimelineEntry($entry);

            $this->saveEntryInDatabase($timelineEntry, $entry);

            $timeline->append($timelineEntry);
        }
        return $timeline;
    }

    /**
     * @return array
     */
    public function getTimelineArray()
    {
        $this->getTimelineFromApi();
        return $this->timelineResult;
    }

    /**
     * @param int $max
     * @param null|int $sinceId
     */
    protected function getTimelineFromApi($max = 20, $sinceId = null)
    {
        if (empty($this->timelineResult)) {
            $this->timelineResult = json_decode($this->twitter->getTimeline($max, $sinceId));
        }
    }

    /**
     * @param TimelineEntry $timelineEntry
     * @param stdclass $entry
     */
    protected function saveEntryInDatabase(TimelineEntry $timelineEntry, $entry)
    {
        $twitterDocument = new TwitterEntry();
        $twitterDocument->setTwitterId($timelineEntry->getId());
        $twitterDocument->setText($timelineEntry->getText());
        $twitterDocument->setFrom($timelineEntry->getFrom());
        $twitterDocument->setFromImage($timelineEntry->getFromImage());
        $twitterDocument->setRetweetCount($timelineEntry->getRetweetCount());
        $twitterDocument->setFavoriteCount($timelineEntry->getFavoriteCount());
        $twitterDocument->setCreatedAt($timelineEntry->getCreatedAt());

        $twitterDocument = $this->addOriginalData($entry, $twitterDocument);

        if (is_null($this->twitterRepo->findByTwitterId($twitterDocument->getTwitterId()))) {
            $this->twitterRepo->save($twitterDocument);
        }
    }

    /**
     * @param stdClass $entry
     * @param TwitterEntry $twitterDocument
     * @return TwitterEntry
     */
    protected function addOriginalData($entry, TwitterEntry $twitterDocument)
    {
        $originalData = new OriginalData();
        $originalData->setText($entry->text);

        if (isset($entry->entities->user_mentions)) {
            foreach ($entry->entities->user_mentions as $mention) {
                $originalData->addMention($mention->screen_name);
            }
        }
        if (isset($entry->entities->media)) {
            foreach ($entry->entities->media as $media) {
                $originalData->addMedia($media->expanded_url);
            }
        }
        if (isset($entry->entities->hashtags)) {
            foreach ($entry->entities->hashtags as $hashtag) {
                $originalData->addHash($hashtag->text);
            }
        }
        $twitterDocument->setOriginalData($originalData);

        return $twitterDocument;
    }
}