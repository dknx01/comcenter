<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 30.11.15 16:10
 * @package
 *
 */

namespace AppBundle\Document\Subdocument;


class OriginalDataTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $document = new OriginalData();
        $document->setText('Example Text');
        $document->addMedia('http://example.com/images/image.png');
        $document->addMention('Zoidberg');
        $document->addHash('Flashback');

        $this->assertEquals('Example Text', $document->getText());
        $this->assertEquals(array('http://example.com/images/image.png'), $document->getMedia());
        $this->assertEquals(array('Zoidberg'), $document->getMentions());
        $this->assertEquals(array('Flashback'), $document->getHashes());
    }

}
