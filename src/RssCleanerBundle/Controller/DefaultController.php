<?php

namespace RssCleanerBundle\Controller;

use RssCleanerBundle\Entity\Expression;
use RssCleanerBundle\Form\ExpressionType;
use RssCleanerBundle\Form\TestExpressionssType;
use RssCleanerBundle\Repository\ExpressionRepository;
use RssCleanerBundle\Repository\FreshRssEntryRepository;
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
        /** @var Expression[] $expressions */
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
            return $this->redirectToRoute('rss_cleaner_homepage');
        }

        return $this->render('RssCleanerBundle:Default:new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function newWithSearchAction(Request $request)
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
            return $this->redirectToRoute('rss_cleaner_homepage');
        }

        return $this->render('RssCleanerBundle:Default:newWithSearch.html.twig', array('form' => $form->createView()));
    }

    /**
     * @return Response
     */
    public function runAction()
    {
        /** @var Expression[] $expressions */
        $expressions = $this->get('doctrine')->getRepository('RssCleanerBundle:Expression')
            ->findBy(array('active' => true));

        /** @var FreshRssEntryRepository $freshRssEntryRepo */
        $freshRssEntryRepo = $this->get('doctrine')->getRepository('RssCleanerBundle:FreshRssEntry');

        $unreadEntries = array();

        foreach ($expressions as $expression) {
            $entries = $freshRssEntryRepo->getUnreadEntriesByRegex($expression->getExpression());
            $foundEntries = array_map(function ($value) {return $value->getTitle();}, $entries);
            $unreadEntries[$expression->getExpression()] = $foundEntries;
            foreach ($entries as $entry) {
                $entry->setRead(true);
                $entry->getFeed()->setCacheNbUnreads($entry->getFeed()->getCacheNbUnreads() - 1);
                $freshRssEntryRepo->save($entry);
            }
        }
        return $this->render('@RssCleaner/Default/runCommand.html.twig', array('found' => $unreadEntries));
    }

    /**
     * @param Request $request
     * @param Expression $expression
     * @return Response
     */
    public function editAction(Request $request, Expression $expression)
    {
        $form = $this->createForm(
            ExpressionType::class,
            $expression,
            array('action' => $this->generateUrl('rss_cleaner_edit', array('id' => $expression->getId())))
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $expression->setActive($request->get('rss_cleaner_bundle_expression_type[active]', false, true));
            $expressionRepo = $this->container->get('rss_cleaner.expression.repository');
            $expressionRepo->save($expression);
            return $this->redirectToRoute('rss_cleaner_homepage');
        }
        return $this->render('@RssCleaner/Default/edit.html.twig', array('form' => $form->createView()));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function testAction(Request $request)
    {

        $form = $this->createForm(TestExpressionssType::class);
        $form->handleRequest($request);
        $result = array();
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FreshRssEntryRepository $repo */
            $repo = $this->container->get('rss_cleaner.entry.repository');
            $result = $repo->getEntriesByRegex($form->getData());
        }

        return $this->render('@RssCleaner/Default/test.html.twig', array('results' => $result, 'form' => $form->createView()));
    }

    public function searchAction()
    {
        return $this->render('@RssCleaner/Default/search.html.twig');
    }
}
