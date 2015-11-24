<?php

namespace AppBundle\Repository;

use AppBundle\Document\TwitterEntry;
use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentRepository;

class TwitterRepository extends DocumentRepository
{
    /**
     * @param string $twitterId
     * @return object|null|TwitterEntry
     */
    public function findByTwitterId($twitterId)
    {
        return $this->findOneBy(array('twitterId' => $twitterId));
    }

    /**
     * @param int $limit
     * @return Cursor
     */
    public function findWithLimit($limit = 50)
    {
        $qb = $this->createQueryBuilder();
        /** @var Cursor $result */
        $result = $qb->limit($limit)
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