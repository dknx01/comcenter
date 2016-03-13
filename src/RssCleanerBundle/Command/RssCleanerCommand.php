<?php

namespace RssCleanerBundle\Command;

use DateTime;
use Documents\CustomRepository\Repository;
use RssCleanerBundle\Entity\Expression;
use RssCleanerBundle\Repository\FreshRssEntryRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RssCleanerCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('rss_cleaner:clean')
            ->setDescription('runs all regex to new fresh rss entries');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $date = new DateTime();
        $io->writeln('Running at: ' . $date->format(DATE_ISO8601));

        /** @var Expression[] $expressions */
        $expressions = $this->getContainer()->get('doctrine')->getRepository('RssCleanerBundle:Expression')
            ->findBy(array('active' => true));
//        $io->note(
//            'processing regex: ' . PHP_EOL .
//            implode(PHP_EOL, array_map(function ($value) {return $value->getExpression();}, $expressions))
//        );

        /** @var FreshRssEntryRepository $freshRssEntryRepo */
        $freshRssEntryRepo = $this->getContainer()->get('doctrine')->getRepository('RssCleanerBundle:FreshRssEntry');

        foreach ($expressions as $expression) {
            $entries = $freshRssEntryRepo->getUnreadEntriesByRegex($expression->getExpression());
            $io->note(
                'found entries for ' . $expression->getExpression() . PHP_EOL .
                implode(PHP_EOL, array_map(function ($value) {return $value->getTitle();}, $entries))
            );
            foreach ($entries as $entry) {
                $entry->setRead(true);
                $entry->getFeed()->setCacheNbUnreads($entry->getFeed()->getCacheNbUnreads() - 1);
                $freshRssEntryRepo->save($entry);
            }
        }
    }
}
