<?php

namespace ShowNotesToZoidBundle\Repository;

use Doctrine\ODM\MongoDB\Cursor;
use ShowNotesToZoidBundle\Document\Notebook;
use Doctrine\ODM\MongoDB\DocumentRepository;

class NotebookRepository extends DocumentRepository
{

    /**
     * @param Notebook $notes
     */
    public function save(Notebook $notes)
    {
        $this->dm->persist($notes);
        $this->dm->flush($notes);
    }

    /**
     * @param string $parentNotebookId
     * @return Cursor
     */
    public function findAllNotebooksByParentId($parentNotebookId)
    {
        $qb = $this->dm->createQueryBuilder(get_class(new Notebook()));
        /** @var Cursor $rs */
        $rs = $qb->field('parentId')->equals($parentNotebookId)
            ->getQuery()
            ->execute();
        return $rs->hydrate();
    }
}