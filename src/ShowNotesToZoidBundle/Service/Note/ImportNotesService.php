<?php

namespace ShowNotesToZoidBundle\Service\Note;

use DateTime;
use FilesystemIterator;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use ShowNotesToZoidBundle\Document\Notebook;
use ShowNotesToZoidBundle\Document\Notes;
use ShowNotesToZoidBundle\Repository\NotebookRepository;
use ShowNotesToZoidBundle\Repository\NotesRepository;
use stdClass;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportNotesService
{

    /**
     * @var NotesRepository
     */
    private $notesRepo;

    /**
     * @var MarkdownParserInterface $mdParser
     */
    private $markDownParser;

    /**
     * @var array
     */
    private  $search = array('\n', '\"');

    /**
     * @var array
     */
    private  $replace = array(PHP_EOL, '"');

    /**
     * @var NotebookRepository
     */
    private $notebookRepo;

    public function __construct(
        NotesRepository $notesRepository,
        MarkdownParserInterface $markdownParserInterface,
        NotebookRepository $notebookRepository
    ) {
        $this->notesRepo = $notesRepository;
        $this->notebookRepo = $notebookRepository;
        $this->markDownParser = $markdownParserInterface;
    }

    /**
     * @param FilesystemIterator $iterator
     * @param ProgressBar $progressBar
     * @param int $sleep
     * @return int
     */
    public function importNotesFromFile(FilesystemIterator $iterator, ProgressBar $progressBar, $sleep = 100000)
    {
        $updateCount = 0;

        /** @var FilesystemIterator $entry */
        foreach ($iterator as $entry) {
            $content = file_get_contents($entry->getPath() . '/' . $entry->getFilename());
            /** @var stdClass $data */
            $data = json_decode($content);

            if ($this->notesRepo->findByNoteIdCount($data->id) == 0) {
                $created = $this->createdDateTimeObject($data->created);

                $note = new Notes();
                $note->setNoteId($data->id)
                    ->setCreatedAt($created);
            } else {
                $document = $this->notesRepo->findByNoteId($data->id);
                $note = $document->getSingleResult();
                $updateCount++;
            }

            $updated = $this->createdDateTimeObject($data->updated);

            $note->setTitle($data->title)
                ->setContent($this->convertString($data))
                ->setUpdatedAt($updated)
                ->setNotebookId($data->notebookId)
                ->setTrash($data->trash)
                ->setType($data->type);

            $this->notesRepo->save($note);
            usleep($sleep);

            $progressBar->advance();
        }

        return $updateCount;
    }

    /**
     * @param int $data
     * @return DateTime
     */
    private function createdDateTimeObject($data)
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp(substr($data, 0, -3));
        return $dateTime;
    }

    /**
     * @param $data
     * @return string
     */
    private function convertString($data)
    {
        return html_entity_decode(
            str_replace(
                $this->search,
                $this->replace,
                $this->markDownParser->transformMarkdown($data->content)
            )
        );
    }

    /**
     * @param string $path
     * @param SymfonyStyle $io
     */
    public function importNotebooks($path, SymfonyStyle $io)
    {
        $fi = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS|FilesystemIterator::CURRENT_AS_SELF);
        $io->note('Notebooks: ' . iterator_count($fi));
        $progressBar = $io->createProgressBar(iterator_count($fi));
        $progressBar->setBarCharacter('<fg=green>=</>');
        $progressBar->setProgressCharacter("\xF0\x9F\x8D\xBA");
        $io->progressStart();

        /** @var FilesystemIterator $entry */
        foreach ($fi as $entry) {
            $content = file_get_contents($entry->getPath() . '/' . $entry->getFilename());
            /** @var stdClass $data */
            $data = json_decode($content);
            /** @var Notebook $notebook */
            $notebook = $this->notebookRepo->findOneBy(array('id' => $data->id));
            if (is_null($notebook)) {
                $notebook = new Notebook();
            }
            $notebook->setId($data->id)
                ->setName($data->name)
                ->setCreatedAt($this->createdDateTimeObject($data->created))
                ->setUpdatedAt($this->createdDateTimeObject($data->updated))
                ->setTrash($data->trash)
                ->setType($data->type)
                ->setParentId($data->parentId);
            $this->notebookRepo->save($notebook);
            $progressBar->advance();
        }
        $io->progressFinish();
    }
}