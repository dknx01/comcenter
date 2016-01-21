<?php

namespace RssCleanerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $repo = $this->container->get('rss_cleaner.entry.repository');
        $rs = $repo->findBy(array('read' => 0));
        dump($rs);
        $name = 'Zoidberg';
        return $this->render('RssCleanerBundle:Default:index.html.twig', array('name' => $name));
    }
}
