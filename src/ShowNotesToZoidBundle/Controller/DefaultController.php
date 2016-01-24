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
        $notes = $repo->findAllByNotebookId($this->getParameter('shownotestozoid.notebookId'));
//        dump($repo->findByNoteId("cd70091b-841f-41d3-1f03-3766ba5c4ac5")->getNext());
        return $this->render('ShowNotesToZoidBundle:Default:index.html.twig', array('notes' => $notes));
    }
}
