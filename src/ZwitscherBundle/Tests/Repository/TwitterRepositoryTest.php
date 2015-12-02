<?php

namespace ZwitscherBundle\Repository;

use ZwitscherBundle\Document\TwitterEntry;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\ClassMetadata;
use PHPUnit_Framework_MockObject_MockObject;

class TwitterRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var DocumentManager|PHPUnit_Framework_MockObject_MockObject $dm */
    private $dm;

    /** @var TwitterRepository|PHPUnit_Framework_MockObject_MockObject $repo */
    private $repo;

    public function setup()
    {
        $this->dm = $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->setMethods(array('persist', 'flush', 'getUnitOfWork'))
            ->getMock();

        $uow = $this->getMockBuilder('Doctrine\ODM\MongoDB\UnitOfWork')
            ->disableOriginalConstructor()
            ->getMock();

        $this->dm->expects($this->atLeastOnce())
            ->method('getUnitOfWork')
            ->willReturn($uow);

        $metaClass = new ClassMetadata(new TwitterEntry());
        $this->repo = $this->getMockBuilder('ZwitscherBundle\Repository\TwitterRepository')
            ->setConstructorArgs(array($this->dm, $this->dm->getUnitOfWork(), $metaClass))
            ->setMethods(array('findOneBy', 'createQueryBuilder'))
            ->getMock();
    }

    public function testSave()
    {
        $document = new TwitterEntry();
        $document->setText('TEST');

        $this->dm->expects($this->once())
            ->method('persist')
            ->with($document);
        $this->dm->expects($this->once())
            ->method('flush')
            ->with($document);
        $this->repo->save($document);
    }

    public function testFindByTwitterId()
    {
        $document = new TwitterEntry();
        $document->setText('TEST')
            ->setFrom('fooo');

        $this->repo->expects($this->once())
            ->method('findOneBy')
            ->with(array('twitterId' => 123))
            ->willReturn($document);
        $this->assertEquals($document, $this->repo->findByTwitterId(123));
    }

    public function testGetLastId()
    {
        $document = new TwitterEntry();
        $document->setTwitterId(123);

        $cursor = $this->getMockBuilder('Doctrine\ODM\MongoDB\Cursor')
            ->disableOriginalConstructor()
            ->setMethods(array('getNext'))
            ->getMock();
        $cursor->expects($this->once())
            ->method('getNext')
            ->willReturn($document);

        $query = $this->getMockBuilder('Doctrine\MongoDB\Query\Query')
            ->disableOriginalConstructor()
            ->setMethods(array('execute'))
            ->getMock();
        $query->expects($this->once())
            ->method('execute')
            ->willReturn($cursor);

        $queryBuilder = $this->getMockBuilder('Doctrine\ODM\MongoDB\Query\Builder')
            ->disableOriginalConstructor()
            ->setMethods(array('getQuery'))
            ->getMock();
        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);

        $this->repo->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);

        $this->assertEquals(123, $this->repo->getLastId());
    }

    public function testFindWithLimit()
    {
        $document = new TwitterEntry();
        $document->setTwitterId(123);

        $cursor = $this->getMockBuilder('Doctrine\ODM\MongoDB\Cursor')
            ->disableOriginalConstructor()
            ->setMethods(array('getNext', 'hydrate'))
            ->getMock();
        $cursor->expects($this->once())
            ->method('getNext')
            ->willReturn($document);
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
            ->setMethods(array('getQuery', 'field', 'notEqual', 'skip', 'limit', 'sort'))
            ->getMock();
        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);
        $queryBuilder->expects($this->once())
            ->method('field')
            ->with('deleted')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('notEqual')
            ->with(true)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('skip')
            ->with(50)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('limit')
            ->with(50)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('sort')
            ->with('twitterId', -1)
            ->willReturnSelf();

        $this->repo->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);

        $this->assertEquals($document, $this->repo->findWithLimit(50, 50)->getNext());
    }

    public function testFindByBooleanFieldWithLimit()
    {
        $document = new TwitterEntry();
        $document->setTwitterId(123);

        $cursor = $this->getMockBuilder('Doctrine\ODM\MongoDB\Cursor')
            ->disableOriginalConstructor()
            ->setMethods(array('getNext', 'hydrate'))
            ->getMock();
        $cursor->expects($this->once())
            ->method('getNext')
            ->willReturn($document);
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
            ->setMethods(array('getQuery', 'field', 'equals', 'skip', 'limit', 'sort'))
            ->getMock();
        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);
        $queryBuilder->expects($this->once())
            ->method('field')
            ->with('pinned')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('equals')
            ->with(true)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('skip')
            ->with(50)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('limit')
            ->with(50)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('sort')
            ->with('twitterId', -1)
            ->willReturnSelf();

        $this->repo->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);

        $this->assertEquals($document, $this->repo->findByBooleanFieldWithLimit('pinned', 50, 50)->getNext());
    }

    public function testFindByUserName()
    {
        $document = new TwitterEntry();
        $document->setTwitterId(123);
        $document->setFromImage('Zoidberg');

        $cursor = $this->getMockBuilder('Doctrine\ODM\MongoDB\Cursor')
            ->disableOriginalConstructor()
            ->setMethods(array('getNext', 'hydrate'))
            ->getMock();
        $cursor->expects($this->once())
            ->method('getNext')
            ->willReturn($document);
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
            ->setMethods(array('getQuery', 'field', 'equals', 'skip', 'limit', 'sort'))
            ->getMock();
        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($query);
        $queryBuilder->expects($this->once())
            ->method('field')
            ->with('from')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('equals')
            ->with('Zoidberg')
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('skip')
            ->with(0)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('limit')
            ->with(50)
            ->willReturnSelf();
        $queryBuilder->expects($this->once())
            ->method('sort')
            ->with('twitterId', -1)
            ->willReturnSelf();

        $this->repo->expects($this->once())
            ->method('createQueryBuilder')
            ->willReturn($queryBuilder);

        $this->assertEquals($document, $this->repo->findByUserName('Zoidberg', 50, 0)->getNext());
    }
}
