<?php

namespace ZwitscherBundle\Command;

use DateTime;
use FilesystemIterator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZwitscherBundle\Document\Notes;
use ZwitscherBundle\Repository\NotesRepository;

class ImportLavernaNotesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('zwitscher:import_laverna_notes_command')
            ->setDescription('Imports laverna notes into MongoDB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Starting ...');
        $lavernaDir = '/var/www/erikwitthauer/remoteStorage/php-remote-storage-0.9.9/data/storage/me/laverna/notes-db/notes/';
        $fi = new FilesystemIterator($lavernaDir, FilesystemIterator::SKIP_DOTS|FilesystemIterator::CURRENT_AS_SELF);
        $output->writeln(sprintf("There were %d Files", iterator_count($fi)));

        /** @var NotesRepository $repo */
        $repo = $this->getContainer()->get('commcenter.repository.notes');

        $rows = iterator_count($fi);
        $progressBar = new ProgressBar($output, $rows);
        $progressBar->setBarCharacter('<fg=green>=</>');
        $progressBar->setProgressCharacter("\xF0\x9F\x8D\xBA");

        $updatCount = 0;
        /** @var FilesystemIterator $entry */
        foreach ($fi as $entry) {
            $content = file_get_contents($entry->getPath() . '/' . $entry->getFilename());
            $data = json_decode($content);

            if ($repo->findByNoteId($data->id) == 0) {
                $created = new DateTime();
                $created->setTimestamp(substr($data->created, 0, -3));

                $note = new Notes();
                $note->setNoteId($data->id)
                    ->setCreatedAt($created);
            } else {
                $document = $repo->findByNoteIdWithDocument($data->id);
                $note = $document->getSingleResult();
                $updatCount++;
            }

            $updated = new DateTime();
            $updated->setTimestamp(substr($data->updated, 0, -3));

            $note->setTitle($data->title)
                ->setContent($data->content)
                ->setUpdatedAt($updated)
                ->setNotebookId($data->notebookId)
                ->setTrash($data->trash)
                ->setType($data->type);

            $repo->save($note);
            usleep(100000);

            $progressBar->advance();
        }

        $progressBar->finish();
        $output->writeln('');
        $output->writeln('<info>Updated Documents:' . $updatCount . '</info>');
        $output->writeln('Finished');
    }
}
