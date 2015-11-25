<?php

namespace AppBundle\Command;

use AppBundle\Service\Twitter\Timeline;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchFromTwitterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:fetch_from_twitter_command')
            ->setDescription('Fetching new entry from twitter')
            ->addArgument('max', InputArgument::OPTIONAL, 'max results', 50);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start');

        /** @var Timeline $twitter */
        $twitter = $this->getContainer()->get('commcenter.service.twitter.timeline');

        /** @var LoggerInterface $logger */
        $logger = $this->getContainer()->get('logger');
        $logger->debug('Max results:' . $input->getArgument('max'));

        $timeline = $twitter->getTimelineCollection($input->getArgument('max'));

        $logger->debug('Results:', $timeline->getArrayCopy());

        $output->writeln('Fetched: ' . $timeline->count());
    }
}
