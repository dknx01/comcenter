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
     * @return TimelineCollection
     */
    public function getTimelineCollection()
    {
        $this->getTimelineFromApi(50);

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
     */
    protected function getTimelineFromApi($max = 20)
    {
        if (empty($this->timelineResult)) {
            $this->timelineResult = json_decode($this->twitter->getTimeline($max));
        }
    }
}