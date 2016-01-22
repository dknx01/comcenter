<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 22.01.16 20:46
 * @package
 *
 */

namespace ZwitscherBundle\Tests\Entity\DTO;


use PHPUnit_Framework_TestCase;
use ReflectionClass;
use ZwitscherBundle\Entity\DTO\TimelineEntity;

class TimelineEntityTest extends PHPUnit_Framework_TestCase
{
    public function testEntity()
    {
        $timelineEntity = new TimelineEntity('foo');
        $timelineEntity->setReplace('barBar');
        $timelineEntity->setSearch('bar');

        $this->assertEquals('barBar', $timelineEntity->getReplace());
        $this->assertEquals('bar', $timelineEntity->getSearch());

        $reflectionClass = new ReflectionClass('ZwitscherBundle\Entity\DTO\TimelineEntity');
        $reflectionProperty = $reflectionClass->getProperty('type');
        $reflectionProperty->setAccessible(true);
        $this->assertEquals('foo', $reflectionProperty->getValue($timelineEntity));
    }
}
