<?php

namespace ShowNotesToZoidBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use ShowNotesToZoidBundle\Document\Notes;
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
    public function findByNoteIdCount($noteId)
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
    public function findByNoteId($noteId)
    {
        $qb = $this->dm->createQueryBuilder(get_class(new Notes()));
        /** @var Cursor $rs */
        $rs = $qb->field('noteId')->equals($noteId)
            ->limit(1)
            ->getQuery()
            ->execute();
        return $rs->hydrate();
    }

    /**
     * @param string $notebookId
     * @return Cursor
     */
    public function findAllByNotebookId($notebookId)
    {
        $qb = $this->dm->createQueryBuilder(get_class(new Notes()));
        /** @var Cursor $rs */
        $rs = $qb->field('notebookId')->equals($notebookId)
            ->getQuery()
            ->execute();
        return $rs->hydrate();
    }
}