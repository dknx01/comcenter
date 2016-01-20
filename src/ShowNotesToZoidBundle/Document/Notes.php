<?php

namespace ShowNotesToZoidBundle\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="ShowNotesToZoidBundle\Repository\NotesRepository")
 */
class Notes
{
    /**
     * @var string
     * @MongoDB\String
     * @MongoDB\ObjectId
     * @MongoDB\Id(name="_id", strategy="Auto")
     */
    private $id;

    /**
     * @var string
     * @MongoDB\String(name="noteId")
     */
    private $noteId;

    /**
     * @var string
     * @MongoDB\String
     */
    private $type;

    /**
     * @var string
     * @MongoDB\String
     */
    private $title;

    /**
     * @var string
     * @MongoDB\String
     */
    private $content;

    /**
     * @var DateTime
     * @MongoDB\Date()
     */
    private $createdAt;

    /**
     * @var DateTime
     * @MongoDB\Date()
     */
    private $updatedAt;

    /**
     * @var string
     * @MongoDB\String
     */
    private $notebookId;

    /**
     * @var int
     * @MongoDB\Int()
     */
    private $trash;

    /**
     * @return string
     */
    public function getNoteId()
    {
        return $this->noteId;
    }

    /**
     * @param string $noteId
     *
     * @return Notes
     */
    public function setNoteId($noteId)
    {
        $this->noteId = $noteId;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return Notes
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
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
     * @return Notes
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return Notes
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return Notes
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     *
     * @return Notes
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotebookId()
    {
        return $this->notebookId;
    }

    /**
     * @param string $notebookId
     *
     * @return Notes
     */
    public function setNotebookId($notebookId)
    {
        $this->notebookId = $notebookId;
        return $this;
    }

    /**
     * @return int
     */
    public function getTrash()
    {
        return $this->trash;
    }

    /**
     * @param int $trash
     *
     * @return Notes
     */
    public function setTrash($trash)
    {
        $this->trash = $trash;
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Notes
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

}