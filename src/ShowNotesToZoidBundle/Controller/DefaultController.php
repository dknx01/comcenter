<?php

namespace ShowNotesToZoidBundle\Controller;

use Doctrine\MongoDB\Cursor;
use ShowNotesToZoidBundle\Document\Notes;
use ShowNotesToZoidBundle\Repository\NotesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @return Response
     */
    public function indexAction()
    {
        /** @var NotesRepository $repo */
        $repo = $this->get('show_notes_to_zoid.repository.notes');
        /** @var Cursor $notes */
        $notes = $repo->findAllByNotebookId('d10eae39-ac01-5e5c-e2da-2fa1bb97f1fc');
        return $this->render('ShowNotesToZoidBundle:Default:index.html.twig', array('notes' => $notes));
    }
}
