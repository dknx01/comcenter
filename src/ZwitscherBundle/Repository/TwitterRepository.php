<?php

namespace ZwitscherBundle\Repository;

use ZwitscherBundle\Document\TwitterEntry;
use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentRepository;

class TwitterRepository extends DocumentRepository
{

    /**
     * @param TwitterEntry $twitterEntry
     */
    public function save(TwitterEntry $twitterEntry)
    {
        $this->dm->persist($twitterEntry);
        $this->dm->flush($twitterEntry);
    }
    /**
     * @param string $twitterId
     * @return null|TwitterEntry
     */
    public function findByTwitterId($twitterId)
    {
        return $this->findOneBy(array('twitterId' => $twitterId));
    }

    /**
     * @param int $limit
     * @param int $skip
     * @return Cursor
     */
    public function findWithLimit($limit = 50, $skip = 0)
    {
        $qb = $this->createQueryBuilder();
        /** @var Cursor $result */
        $result = $qb->field('deleted')->notEqual(true)
            ->skip($skip)
            ->limit($limit)
            ->sort('twitterId', -1)
            ->getQuery()
            ->execute();
        return $result->hydrate();
    }

    /**
     * @param string $field
     * @param int $limit
     * @param int $skip
     * @return Cursor
     */
    public function findByBooleanFieldWithLimit($field, $limit = 50, $skip = 0)
    {
        $qb = $this->createQueryBuilder();
        /** @var Cursor $result */
        $result = $qb->field($field)->equals(true)
            ->skip($skip)
            ->limit($limit)
            ->sort('twitterId', -1)
            ->getQuery()
            ->execute();
        return $result->hydrate();
    }

    /**
     * @return string
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function getLastId()
    {
        $qb = $this->createQueryBuilder();
        /** @var Cursor $result */
        $result = $qb->select('twitterId')
            ->limit(1)
            ->sort('twitterId', -1)
            ->getQuery()
            ->execute();
        return $result->getNext()->getTwitterId();
    }

}