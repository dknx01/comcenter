<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 30.11.15 15:42
 * @package
 *
 */

namespace AppBundle\Document;


use AppBundle\Document\Subdocument\OriginalData;
use DateTime;

class TwitterEntryTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $createdAt = new DateTime();

        $document = new TwitterEntry();
        $document->setTwitterId(123);
        $document->setText('Example text');
        $document->setFrom('Zoidberg');
        $document->setFromImage('http://example.com/profile/image.png');
        $document->setRetweetCount(0);
        $document->setFavoriteCount(0);
        $document->setId('abc123xyz');
        $document->setCreatedAt($createdAt);
        $document->setPinned(true);
        $document->setDeleted(false);
        $document->setOriginalData(new OriginalData());

        $this->assertEquals(123, $document->getTwitterId());
        $this->assertEquals('Example text', $document->getText());
        $this->assertEquals('Zoidberg', $document->getFrom());
        $this->assertEquals('http://example.com/profile/image.png', $document->getFromImage());
        $this->assertEquals(0, $document->getRetweetCount());
        $this->assertEquals(0, $document->getFavoriteCount());
        $this->assertEquals('abc123xyz', $document->getId());
        $this->assertEquals($createdAt, $document->getCreatedAt());
        $this->assertTrue($document->isPinned());
        $this->assertFalse($document->isDeleted());
        $this->assertInstanceOf('AppBundle\Document\Subdocument\OriginalData', $document->getOriginalData());
    }
}
