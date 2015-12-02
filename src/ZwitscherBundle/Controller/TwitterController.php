<?php

namespace ZwitscherBundle\Controller;

use ZwitscherBundle\Document\TwitterEntry;
use ZwitscherBundle\Repository\TwitterRepository;
use \ZwitscherBundle\Service\Twitter;
use ZwitscherBundle\Service\Twitter\Api;
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
        $this->redirectToRoute('home');
        /** @var Api $service3 */
        $service3 = $this->get('commcenter.service.twitter.api');

        $timeline = $service3->getTimeline();
        return $this->render('ZwitscherBundle:Twitter:overview.html.twig', array('timeline' => $timeline));
    }

    /**
     * @Route("/newest")
     */
    public function getNewestAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TwitterRepository $repo */
        $repo = $dm->getRepository('ZwitscherBundle:TwitterEntry');
        return new Response($repo->getLastId());
    }

    /**
     * @Route("/twitter/timeline/{page}", requirements={"page"="\d+"}, name="home")
     * @param int $page
     * @return Response
     */
    public function timelineAction($page = 0)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TwitterRepository $repo */
        $repo = $dm->getRepository('ZwitscherBundle:TwitterEntry');

        $limit = 50;
        $timeline = $repo->findWithLimit($limit, ($page * $limit));
        $timelineArray = $timeline->toArray();

        return $this->render(
            'ZwitscherBundle:Twitter:timeline.html.twig',
            array(
                'timeline' => $timeline,
                'timelineArray' => $timelineArray,
                'page' => $page,
                'perPage' => $limit,
                'navigation' => 'home',
                'url' => $this->generateUrl('home')
            )
        );
    }

    /**
     * @Route("/twitter/delete/{twitterId}", methods={"GET"}, requirements={"twitterId" = "^[a-z0-9]{1,}$"})
     * @return Response
     */
    public function deleteAction($twitterId)
    {
        $return = false;
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TwitterRepository $repo */
        $repo = $dm->getRepository('ZwitscherBundle:TwitterEntry');
        /** @var TwitterEntry $entry */
        $entry = $repo->findByTwitterId($twitterId);
        if (!is_null($entry)) {
            $entry->setDeleted(true);
            $repo->save($entry);
            $return = true;
        }
        return new Response((string)$return);
    }

    /**
     * @Route("/twitter/pin/{twitterId}", methods={"GET"}, requirements={"twitterId" = "^[a-z0-9]{1,}$"})
     * @return Response
     */
    public function pinAction($twitterId)
    {
        $return = '';
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TwitterRepository $repo */
        $repo = $dm->getRepository('ZwitscherBundle:TwitterEntry');
        /** @var TwitterEntry $entry */
        $entry = $repo->findByTwitterId($twitterId);
        if (!is_null($entry)) {
            if ($entry->isPinned() === true) {
                $entry->setPinned(false);
                $return = 'unpinned';
            } else {
                $entry->setPinned(true);
                $return = 'pinned';
            }
            $repo->save($entry);
        }
        return new Response($return);
    }

    /**
     * @Route("/twitter/pinned/{page}", requirements={"page"="\d+"}, name="pinned")
     * @param int $page
     * @return Response
     */
    public function allPinnedAction($page = 0)
    {
        return $this->getEntriesByBooleanField('pinned', 'pinned', $page);
    }

    /**
     * @Route("/twitter/deleted/{page}", requirements={"page"="\d+"}, name="deleted")
     * @param int $page
     * @return Response
     */
    public function allDeletedAction($page = 0)
    {
        return $this->getEntriesByBooleanField('deleted', 'deleted', $page);
    }

    /**
     * @param string $fieldName
     * @param string $naviName
     * @param int $page
     * @param int $limit
     * @return Response
     */
    protected function getEntriesByBooleanField($fieldName, $naviName, $page = 0, $limit = 50)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        /** @var TwitterRepository $repo */
        $repo = $dm->getRepository('ZwitscherBundle:TwitterEntry');

        $timeline = $repo->findByBooleanFieldWithLimit($fieldName, $limit, ($page * $limit));
        $timelineArray = $timeline->toArray();

        return $this->render(
            'ZwitscherBundle:Twitter:timeline.html.twig',
            array(
                'timeline' => $timeline,
                'timelineArray' => $timelineArray,
                'page' => $page,
                'perPage' => $limit,
                'navigation' => $naviName,
                'url' => $this->generateUrl($naviName)
            )
        );
    }
}
