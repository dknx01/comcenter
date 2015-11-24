<?php

namespace AppBundle\Command;

use AppBundle\Document\TwitterEntry;
use AppBundle\Repository\TwitterRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchFromTwitterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:fetch_from_twitter_command')
            ->setDescription('Hello PhpStorm');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $twitter = $this->getContainer()->get('twitter.service.timeline');
        /** @var ObjectManager $dm */
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        /** @var TwitterRepository $repo */
        $repo = $dm->getRepository('AppBundle:TwitterEntry');

        $timeline = $twitter->getTimelineCollection($repo->getLastId());
        foreach ($timeline as $entry) {
            $twitterDocument = new TwitterEntry();
            $twitterDocument->setTwitterId($entry->getId());
            $twitterDocument->setText($entry->getText());
            $twitterDocument->setFrom($entry->getFrom());
            $twitterDocument->setFromImage($entry->getFromImage());
            $twitterDocument->setRetweetCount($entry->getRetweetCount());
            $twitterDocument->setFavoriteCount($entry->getFavoriteCount());
            $twitterDocument->setCreatedAt($entry->getCreatedAt());

            if (is_null($repo->findByTwitterId($twitterDocument->getTwitterId()))) {
                $dm->persist($twitterDocument);
                $dm->flush();
            }
        }
        $output->writeln('Fetched: ' . $timeline->count());
    }
}
