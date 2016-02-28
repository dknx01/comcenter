<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 27.02.16 16:03
 * @package
 *
 */

namespace ShowNotesToZoidBundle\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="ShowNotesToZoidBundle\Repository\NotebookRepository")
 */
class Notebook
{
    /**
     * @var string
     * @MongoDB\String
     * @MongoDB\ObjectId
     * @MongoDB\Id(name="_id", strategy="Auto")
     */
    private $mongoId;

    /**
     * @var string
     * @MongoDB\String
     */
    protected $id;

    /**
     * @var string
     * @MongoDB\String
     */
    protected $type;

    /**
     * @var string
     * @MongoDB\String
     */
    protected $parentId;

    /**
     * @var string
     * @MongoDB\String
     */
    protected $name;

    /**
     * @var boolean
     * @MongoDB\Int()
     */
    protected $trash;

    /**
     * @var DateTime
     * @MongoDB\Date()
     */
    protected $createdAt;

    /**
     * @var DateTime
     * @MongoDB\Date()
     */
    protected $updatedAt;

    /**
     * @return string
     */
    public function getMongoId()
    {
        return $this->mongoId;
    }

    /**
     * @param string $mongoId
     *
     * @return Notebook
     */
    public function setMongoId($mongoId)
    {
        $this->mongoId = $mongoId;
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
     * @return Notebook
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return Notebook
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param string $parentId
     *
     * @return Notebook
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Notebook
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isTrash()
    {
        return $this->trash;
    }

    /**
     * @param boolean $trash
     *
     * @return Notebook
     */
    public function setTrash($trash)
    {
        $this->trash = $trash;
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
     * @return Notebook
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
     * @return Notebook
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
