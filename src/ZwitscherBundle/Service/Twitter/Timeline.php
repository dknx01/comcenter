<?php

namespace ZwitscherBundle\Service\Twitter;

use ZwitscherBundle\Document\Subdocument\OriginalData;
use ZwitscherBundle\Document\Notes;
use ZwitscherBundle\Entity\DTO\TimelineEntry;
use ZwitscherBundle\Entity\TimelineCollection;
use ZwitscherBundle\Repository\NotesRepository;
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
    public function __construct(Api $twitter, NotesRepository $repository)
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
        $twitterDocument = new Notes();
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
    protected function addOriginalData($entry, Notes $twitterDocument)
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