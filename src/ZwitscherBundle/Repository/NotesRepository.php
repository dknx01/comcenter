<?php

namespace ZwitscherBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use ZwitscherBundle\Document\Notes;
use Doctrine\ODM\MongoDB\DocumentRepository;

class NotesRepository extends DocumentRepository
{

    /**
     * @param Notes $notes
     */
    public function save(Notes $notes)
    {
        $this->dm->persist($notes);
        $this->dm->flush($notes);
    }

    /**
     * @param string $noteId
     * @return int
     */
    public function findByNoteId($noteId)
    {
        $qb = $this->dm->createQueryBuilder(get_class(new Notes()));
        /** @var Cursor $rs */
        $rs = $qb->field('noteId')->equals($noteId)
            ->limit(1)
            ->getQuery()
            ->execute();
        return $rs->hydrate()->count();
    }

    /**
     * @param string $noteId
     * @return null|Cursor
     */
    public function findByNoteIdWithDocument($noteId)
    {
        $qb = $this->dm->createQueryBuilder(get_class(new Notes()));
        /** @var Cursor $rs */
        $rs = $qb->field('noteId')->equals($noteId)
            ->limit(1)
            ->getQuery()
            ->execute();
        return $rs->hydrate();
    }
}