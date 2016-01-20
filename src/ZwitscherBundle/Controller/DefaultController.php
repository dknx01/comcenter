<?php

namespace ZwitscherBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $this->redirectToRoute('show_notes_to_zoid_homepage');
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => str_replace('/var/www/erikwitthauer', 'DOCROOT', realpath($this->container->getParameter('kernel.root_dir').'/..')),
        ));
    }

    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }
}
