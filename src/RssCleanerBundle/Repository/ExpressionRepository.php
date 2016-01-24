<?php

namespace RssCleanerBundle\Repository;
use RssCleanerBundle\Entity\Expression;

/**
 * ExpressionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ExpressionRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param Expression $expression
     */
    public function save(Expression $expression)
    {
        $this->_em->persist($expression);
        $this->_em->flush($expression);
    }
}
