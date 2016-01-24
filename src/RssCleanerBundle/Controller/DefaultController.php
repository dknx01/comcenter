<?php

namespace RssCleanerBundle\Controller;

use RssCleanerBundle\Entity\Expression;
use RssCleanerBundle\Form\ExpressionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $expressionRepo = $this->container->get('rss_cleaner.expression.repository');
        $expressions = $expressionRepo->findAll();
        return $this->render('RssCleanerBundle:Default:index.html.twig', array('expressions' => $expressions));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $expression = new Expression();
        $form = $this->createForm(
            ExpressionType::class,
            $expression,
            array('action' => $this->generateUrl('rss_cleaner_new'))
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $expressionRepo = $this->container->get('rss_cleaner.expression.repository');
            $expressionRepo->save($expression);
        }

        return $this->render('RssCleanerBundle:Default:new.html.twig', array('form' => $form->createView()));
    }
}
