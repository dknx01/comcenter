<?php
/**
 *
 * @author dknx01 <e.witthauer@gmail.com>
 * @since 29.01.16 20:59
 * @package
 *
 */

namespace ShowNotesToZoidBundle\Tests\Service\Note;


use DateTime;
use Doctrine\ODM\MongoDB\Cursor;
use FilesystemIterator;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ShowNotesToZoidBundle\Document\Notes;
use ShowNotesToZoidBundle\Repository\NotesRepository;
use ShowNotesToZoidBundle\Service\Note\ImportNotesService;
use Symfony\Component\Console\Helper\ProgressBar;

class ImportNotesServiceTest extends PHPUnit_Framework_TestCase
{
    public function testimportNotesFromFile()
    {
        /** @var NotesRepository|PHPUnit_Framework_MockObject_MockObject $notesRepo */
        $notesRepo = $this->getMockBuilder('ShowNotesToZoidBundle\Repository\NotesRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $notesRepo->expects($this->once())
            ->method('findByNoteIdCount')
            ->with('123abc')
            ->willReturn(0);
        $note = new Notes();
        $createdAt = new DateTime();
        $createdAt->setTimestamp(1454098701);
        $note->setNoteId('123abc')
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($createdAt)
            ->setTitle('Test title')
            ->setNotebookId('789yxz')
            ->setContent('<p><strong>Create DROP TABLE for all tables in a Database</strong>' . PHP_EOL . PHP_EOL .
'<pre><code>SELECT "$DATABASE"</code></pre>')
            ->setTrash('0')
            ->setType('foo');
        $notesRepo->expects($this->once())
            ->method('save')
            ->with($note);
        /** @var MarkdownParserInterface|PHPUnit_Framework_MockObject_MockObject $markdown */
        $markdown = $this->getMockBuilder('Knp\Bundle\MarkdownBundle\MarkdownParserInterface')
            ->disableOriginalConstructor()
            ->setMethods(array('transformMarkdown'))
            ->getMock();
        $markdown->expects($this->once())
            ->method('transformMarkdown')
            ->with('**Create DROP TABLE for all tables in a Database**

<pre><code>SELECT "$DATABASE"</code></pre>')
            ->willReturn(
                '<p><strong>Create DROP TABLE for all tables in a Database</strong>' .
                '\n\n<pre><code>SELECT \"$DATABASE\"</code></pre>'
            );

        $service = new ImportNotesService($notesRepo, $markdown);

        $iterator = new FilesystemIterator(realpath(__DIR__ . '/../../Examples'));

        /** @var ProgressBar|PHPUnit_Framework_MockObject_MockObject $progressbar */
        $progressbar = $this->getMockBuilder('Symfony\Component\Console\Helper\ProgressBar')
            ->disableOriginalConstructor()
            ->getMock();
        $this->assertEquals(0, $service->importNotesFromFile($iterator, $progressbar));
    }

    public function testimportNotesFromFileWithUpdate()
    {
        /** @var NotesRepository|PHPUnit_Framework_MockObject_MockObject $notesRepo */
        $notesRepo = $this->getMockBuilder('ShowNotesToZoidBundle\Repository\NotesRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $notesRepo->expects($this->once())
            ->method('findByNoteIdCount')
            ->with('123abc')
            ->willReturn(1);

        $note = new Notes();
        $createdAt = new DateTime();
        $createdAt->setTimestamp(1454098701);
        $note->setNoteId('123abc')
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($createdAt)
            ->setTitle('Test title')
            ->setNotebookId('789yxz')
            ->setContent('<p><strong>Create DROP TABLE for all tables in a Database</strong>' . PHP_EOL . PHP_EOL .
                '<pre><code>SELECT "$DATABASE"</code></pre>')
            ->setTrash('0')
            ->setType('foo');

        /** @var Cursor|PHPUnit_Framework_MockObject_MockObject $cursor */
        $cursor = $this->getMockBuilder('Doctrine\ODM\MongoDB\Cursor')
            ->disableOriginalConstructor()
            ->getMock();
        $cursor->expects($this->once())
            ->method('getSingleResult')
            ->willReturn($note);
        $notesRepo->expects($this->once())
            ->method('findByNoteId')
            ->with('123abc')
            ->willReturn($cursor);

        $notesRepo->expects($this->once())
            ->method('save')
            ->with($note);
        /** @var MarkdownParserInterface|PHPUnit_Framework_MockObject_MockObject $markdown */
        $markdown = $this->getMockBuilder('Knp\Bundle\MarkdownBundle\MarkdownParserInterface')
            ->disableOriginalConstructor()
            ->setMethods(array('transformMarkdown'))
            ->getMock();
        $markdown->expects($this->once())
            ->method('transformMarkdown')
            ->with('**Create DROP TABLE for all tables in a Database**

<pre><code>SELECT "$DATABASE"</code></pre>')
            ->willReturn(
                '<p><strong>Create DROP TABLE for all tables in a Database</strong>' .
                '\n\n<pre><code>SELECT \"$DATABASE\"</code></pre>'
            );

        $service = new ImportNotesService($notesRepo, $markdown);

        $iterator = new FilesystemIterator(realpath(__DIR__ . '/../../Examples'));

        /** @var ProgressBar|PHPUnit_Framework_MockObject_MockObject $progressbar */
        $progressbar = $this->getMockBuilder('Symfony\Component\Console\Helper\ProgressBar')
            ->disableOriginalConstructor()
            ->getMock();
        $this->assertEquals(1, $service->importNotesFromFile($iterator, $progressbar));
    }
}
