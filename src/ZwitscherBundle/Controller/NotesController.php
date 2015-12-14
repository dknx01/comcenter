<?php

namespace ZwitscherBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotesController extends Controller
{
    /**
     * @Route("/notes")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render(
            'ZwitscherBundle:Notes:dashboard.html.twig',
            array(
                'dashboard' => 'FOO'
            )
        );
    }

    /**
     * @Route("/notes/editor")
     */
    public function notesAction()
    {
        return $this->render(
            'ZwitscherBundle:Notes:Note.html.twig'
        );
    }
}
