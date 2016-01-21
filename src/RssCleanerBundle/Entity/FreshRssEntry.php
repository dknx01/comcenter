<?php

namespace RssCleanerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FreshRssEntry
 *
 * @ORM\Table(schema="freshrss", name="freshrss_admin_entry")
 * @ORM\Entity(repositoryClass="RssCleanerBundle\Repository\FreshRssEntryRepository")
 */
class FreshRssEntry
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="integer")
     */
    private $createdAt;

    /**
     * @var boolean
     * @ORM\Column(name="is_read", type="boolean")
     */
    private $read;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return FreshRssEntry
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return FreshRssEntry
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isRead()
    {
        return $this->read;
    }

    /**
     * @param boolean $read
     *
     * @return FreshRssEntry
     */
    public function setRead($read)
    {
        $this->read = $read;
        return $this;
    }
}

