<?php

namespace AppBundle\Controller;

use AppBundle\Document\TwitterEntry;
use \AppBundle\Service\Twitter;
use AppBundle\Service\Twitter\Api;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TwitterController extends Controller
{

    /**
     * @Route("/twitter")
     * @return Response
     */
    public function twitterTimelineAction()
    {
        /** @var Api $service3 */
        $service3 = $this->get('twitter.service.api');

        $timeline = $service3->getTimeline();
        return $this->render('AppBundle:Twitter:overview.html.twig', array('timeline' => $timeline));
    }

    /**
     * @Route("/twitter/timeline")
     * @return Response
     */
    public function timelineAction()
    {
        /** @var Twitter\Timeline $service3 */
        $timelineService = $this->get('twitter.service.timeline');

        $timeline = $timelineService->getTimelineCollection();
        $timelineArray = $timelineService->getTimelineArray();

        $dm = $this->get('doctrine_mongodb')->getManager();

        foreach ($timeline as $entry) {
            $twitterDocument = new TwitterEntry();
            $twitterDocument->setTwitterId($entry->getId());
            $twitterDocument->setText($entry->getText());
            $twitterDocument->setFrom($entry->getFrom());
            $twitterDocument->setFromImage($entry->getFromImage());
            $twitterDocument->setRetweetCount($entry->getRetweetCount());
            $twitterDocument->setFavoriteCount($entry->getFavoriteCount());

            if (is_null($dm->getRepository('AppBundle:TwitterEntry')
                ->findOneBy(array('twitterId' => $twitterDocument->getTwitterId())))
            ) {
                $dm->persist($twitterDocument);
                $dm->flush();
            }
        }

        return $this->render(
            'AppBundle:Twitter:overview2.html.twig',
            array(
                'timeline' => $timeline,
                'timelineArray' => $timelineArray
            )
        );
    }


}
