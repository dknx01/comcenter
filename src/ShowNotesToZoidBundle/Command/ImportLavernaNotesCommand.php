<?php

namespace ShowNotesToZoidBundle\Command;

use DateTime;
use FilesystemIterator;
use ShowNotesToZoidBundle\Service\Note\ImportNotesService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportLavernaNotesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('show_notes_to_zoid:import_laverna_notes_command')
            ->setDescription('Imports laverna notes into MongoDB');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Starting ...');
        $lavernaDir = $this->getContainer()->getParameter('shownotestozoid.paths.notes');
        $fi = new FilesystemIterator($lavernaDir, FilesystemIterator::SKIP_DOTS|FilesystemIterator::CURRENT_AS_SELF);
        $io->writeln(sprintf("There were %d Files", iterator_count($fi)));

        /** @var ImportNotesService $noteService */
        $noteService = $this->getContainer()->get('show_notes_to_zoid.service_note.import_notes_service');

        $rows = iterator_count($fi);
        $progressBar = $io->createProgressBar($rows);
        $progressBar->setBarCharacter('<fg=green>=</>');
        $progressBar->setProgressCharacter("\xF0\x9F\x8D\xBA");
        $io->progressStart();
        $updateCount = $noteService->importNotesFromFile($fi, $progressBar);
        $io->progressFinish();
        $io->note('Updated Documents:' . $updateCount );
        $io->writeln('<bg=blue;options=blink>Finished');
    }
}
