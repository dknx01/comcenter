<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 24.01.16 17:49
 * @package
 *
 */

namespace ShowNotesToZoidBundle\Tests\Repository;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ShowNotesToZoidBundle\Document\Notes;
use ShowNotesToZoidBundle\Repository\NotesRepository;

class NotesRepositoryTest extends PHPUnit_Framework_TestCase
{
    /** @var DocumentManager|PHPUnit_Framework_MockObject_MockObject $dm */
    private $dm;

    /** @var NotesRepository|PHPUnit_Framework_MockObject_MockObject $repo */
    private $repo;

    public function setup()
    {
        $this->dm = $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->setMethods(array('persist', 'flush', 'getUnitOfWork', 'createQueryBuilder'))
            ->getMock();

        $uow = $this->getMockBuilder('Doctrine\ODM\MongoDB\UnitOfWork')
            ->disableOriginalConstructor()
            ->getMock();

        $this->dm->expects($this->atLeastOnce())
            ->method('getUnitOfWork')
            ->willReturn($uow);

        $metaClass = new ClassMetadata(new Notes());
        $this->repo = $this->getMockBuilder('ShowNotesToZoidBundle\Repository\NotesRepository')
            ->setConstructorArgs(array($this->dm, $this->dm->getUnitOfWork(), $metaClass))
            ->setMethods(array('findOneBy', 'createQueryBuilder'))
            ->getMock();
    }

    public function testSave()
    {
        $notes = new Notes();

        $this->dm->expects($this->once())
            ->method('persist')
            ->with($notes);
        $this->dm->expects($this->once())
            ->method('flush')
            ->with($notes);
        $this->repo->save($notes);
    }

    public function testFindByNoteIdCount()
    {
        $cursor = $this->getMockBuilder('Doctrine\ODM\MongoDB\Cursor')
            ->disableOriginalConstructor()
            ->setMethods(array('hydrate', 'count'))
            ->getMock();
        $cursor->expects($this->once())
            ->method('hydrate')
            ->willReturnSelf();
        $cursor->expects($this->once())
            ->method('count')
            ->willReturn(1);

        $query = $this->getMockBuilder('Doctrine\MongoDB\Query\Query')
            ->disableOriginalConstructor()
            ->setMethods(array('execute'))
            ->getMock();
        $query->expects($this->once())
            ->method('execute')
            ->willReturn($cursor);

        $queryBuilder = $this->getMockBuilder('Doctrine\ODM\MongoDB\Query\Builder')
            ->disableOriginalConstructor()
            ->getMock();
        $queryBuilder->expects($this->once())
            ->method('field')
            ->with('noteId')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('equals')
            ->with(123)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('limit')
            ->with(1)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);
        $this->dm->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);

        $this->assertEquals(1, $this->repo->findByNoteIdCount(123));
    }

    public function testFindByNoteId()
    {
        $cursor = $this->getMockBuilder('Doctrine\ODM\MongoDB\Cursor')
            ->disableOriginalConstructor()
            ->setMethods(array('hydrate', 'getSingleResult'))
            ->getMock();
        $cursor->expects($this->once())
            ->method('hydrate')
            ->willReturnSelf();
        $note = new Notes();
        $cursor->expects($this->once())
            ->method('getSingleResult')
            ->willReturn($note);

        $query = $this->getMockBuilder('Doctrine\MongoDB\Query\Query')
            ->disableOriginalConstructor()
            ->setMethods(array('execute'))
            ->getMock();
        $query->expects($this->once())
            ->method('execute')
            ->willReturn($cursor);

        $queryBuilder = $this->getMockBuilder('Doctrine\ODM\MongoDB\Query\Builder')
            ->disableOriginalConstructor()
            ->getMock();
        $queryBuilder->expects($this->once())
            ->method('field')
            ->with('noteId')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('equals')
            ->with(123)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('limit')
            ->with(1)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);
        $this->dm->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);

        $result = $this->repo->findByNoteId(123);
        $this->assertInstanceOf('Doctrine\ODM\MongoDB\Cursor', $result);
        $this->assertInstanceOf('ShowNotesToZoidBundle\Document\Notes', $result->getSingleResult());
    }

    public function testFindAllByNotebookId()
    {
        $cursor = $this->getMockBuilder('Doctrine\ODM\MongoDB\Cursor')
            ->disableOriginalConstructor()
            ->setMethods(array('hydrate'))
            ->getMock();
        $cursor->expects($this->once())
            ->method('hydrate')
            ->willReturnSelf();

        $query = $this->getMockBuilder('Doctrine\MongoDB\Query\Query')
            ->disableOriginalConstructor()
            ->setMethods(array('execute'))
            ->getMock();
        $query->expects($this->once())
            ->method('execute')
            ->willReturn($cursor);

        $queryBuilder = $this->getMockBuilder('Doctrine\ODM\MongoDB\Query\Builder')
            ->disableOriginalConstructor()
            ->getMock();
        $queryBuilder->expects($this->once())
            ->method('field')
            ->with('notebookId')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('equals')
            ->with('123abc')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);
        $this->dm->expects($this->once())
            ->method('createQueryBuilder')
            ->with(get_class(new Notes()))
            ->willReturn($queryBuilder);

        $result = $this->repo->findAllByNotebookId('123abc');
        $this->assertInstanceOf('Doctrine\ODM\MongoDB\Cursor', $result);
    }
}
