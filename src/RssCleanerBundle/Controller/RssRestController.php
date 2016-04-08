<?php

namespace RssCleanerBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use RssCleanerBundle\Entity\Expression;
use RssCleanerBundle\Repository\FreshRssEntryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RssRestController extends FOSRestController
{
    /**
     * @param Expression $expression
     * @return Response
     * @ParamConverter("expression", class="RssCleanerBundle:Expression")
     */
    public function getEntriesAction(Expression $expression)
    {
        /** @var FreshRssEntryRepository $repo */
        $repo = $this->container->get('rss_cleaner.entry.repository');
        $entries = $repo->getEntriesByExpression($expression);
        $view = $this->view($entries, 200)
            ->setTemplate("RssCleanerBundle:Rest:Entries.html.twig")
            ->setTemplateVar('entries');

        return $this->handleView($view);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getEntriesBySearchExpressionAction(Request $request)
    {
        /** @var FreshRssEntryRepository $repo */
        $repo = $this->container->get('rss_cleaner.entry.repository');
        $entries = $repo->getEntriesBySearchExpression($request->get('expression'));
        $view = $this->view($entries, 200)
            ->setTemplate("RssCleanerBundle:Rest:Entries.html.twig")
            ->setTemplateVar('entries');

        return $this->handleView($view);
    }
}
