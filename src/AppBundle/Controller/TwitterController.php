<?php

namespace AppBundle\Controller;

use AppBundle\Document\TwitterEntry;
use AppBundle\Repository\TwitterRepository;
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
        $service3 = $this->get('commcenter.service.twitter.api');

        $timeline = $service3->getTimeline();
        return $this->render('AppBundle:Twitter:overview.html.twig', array('timeline' => $timeline));
    }

    /**
     * @Route("/newest")
     */
    public function getNewestAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TwitterRepository $repo */
        $repo = $dm->getRepository('AppBundle:TwitterEntry');
        return new Response($repo->getLastId());
    }

    /**
     * @Route("/twitter/timeline")
     * @return Response
     */
    public function timelineAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TwitterRepository $repo */
        $repo = $dm->getRepository('AppBundle:TwitterEntry');

        $timeline = $repo->findWithLimit();
        $timelineArray = $timeline->toArray();
        return $this->render(
            'AppBundle:Twitter:overview2.html.twig',
            array(
                'timeline' => $timeline,
                'timelineArray' => $timelineArray
            )
        );
    }


}
