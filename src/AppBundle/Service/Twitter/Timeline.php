<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 03.11.15 14:38
 * @package
 *
 */

namespace AppBundle\Service\Twitter;


use AppBundle\Entity\DTO\TimelineEntry;
use AppBundle\Entity\TimelineCollection;

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
     * Timeline constructor.
     */
    public function __construct(Api $twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @param null|int $sinceId
     * @return \AppBundle\Entity\DTO\TimelineEntry[]|TimelineCollection
     */
    public function getTimelineCollection($sinceId = null)
    {
        $this->getTimelineFromApi(50, $sinceId);

        $timeline = new TimelineCollection();
        foreach ($this->timelineResult as $entry) {
            $timelineEntry = new TimelineEntry($entry);
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
}