<?php

namespace ZwitscherBundle\Entity\DTO;

class TimelineEntity
{
    /**
     * @var
     */
    private $type;

    /**
     * @var string
     */
    private $search;

    /**
     * @var string
     */
    private $replace;

    /**
     * TimelineEntity constructor.
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param string $search
     *
     * @return TimelineEntity
     */
    public function setSearch($search)
    {
        $this->search = $search;
        return $this;
    }

    /**
     * @return string
     */
    public function getReplace()
    {
        return $this->replace;
    }

    /**
     * @param string $replace
     *
     * @return TimelineEntity
     */
    public function setReplace($replace)
    {
        $this->replace = $replace;
        return $this;
    }
}