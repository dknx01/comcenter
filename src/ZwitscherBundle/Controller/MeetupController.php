<?php

namespace ZwitscherBundle\Controller;

use DMS\Service\Meetup\MeetupKeyAuthClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MeetupController extends Controller
{
    /**
     * @Route("/meetup", name="meetupDashboard")
     * @return Response
     */
    public function indexAction()
    {
        $apiKey = '3c1767346a3d3b30132a55514d59614c';
        /** @var MeetupKeyAuthClient $client */
        $client = MeetupKeyAuthClient::factory(array('key' => $apiKey));
        $dashboard = $client->getDashboard()->getBody(true);
        return $this->render(
            'ZwitscherBundle:Meetup:dashboard.html.twig',
            array('dashboard' => json_decode($dashboard))
        );
    }
}
