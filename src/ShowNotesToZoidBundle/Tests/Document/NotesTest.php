<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 24.01.16 16:53
 * @package
 *
 */

namespace ShowNotesToZoidBundle\Tests\Document;

use DateTime;
use ShowNotesToZoidBundle\Document\Notes;

class NotesTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $createdAt = new DateTime();
        $updatedAt = new DateTime();

        $notes = new Notes();
        $notes->setId(123)
            ->setNoteId('abc123')
            ->setNotebookId('xyz9')
            ->setContent('FOOO')
            ->setCreatedAt($createdAt)
            ->setTitle('Title')
            ->setTrash(0)
            ->setType('not me')
            ->setUpdatedAt($updatedAt);

        $this->assertEquals('123', $notes->getId());
        $this->assertEquals('abc123', $notes->getNoteId());
        $this->assertEquals('xyz9', $notes->getNotebookId());
        $this->assertEquals('FOOO', $notes->getContent());
        $this->assertEquals($createdAt, $notes->getCreatedAt());
        $this->assertEquals('Title', $notes->getTitle());
        $this->assertEquals(0, $notes->getTrash());
        $this->assertEquals('not me', $notes->getType());
        $this->assertEquals($updatedAt, $notes->getUpdatedAt());
    }
}
