<?php

namespace RssCleanerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Expression
 *
 * @ORM\Table(name="rssCleaner__expressions", schema="comcenter")
 * @ORM\Entity(repositoryClass="RssCleanerBundle\Repository\ExpressionRepository")
 */
class Expression
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
     *
     * @ORM\Column(type="string", length=255, name="expression")
     * @Assert\NotBlank()
     */
    private $expression;


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
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @param string $expression
     *
     * @return Expression
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;
        return $this;
    }
}

