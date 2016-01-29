<?php

namespace ShowNotesToZoidBundle\Controller;

use Doctrine\MongoDB\Cursor;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
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
        return $this->render('ShowNotesToZoidBundle:Default:index.html.twig', array('notes' => $notes));
    }

    /**
     * @CoverageIgnore
     */
    public function testAction()
    {
        $text = '**Create DROP TABLE for all tables in a Database**\n\n<pre><code>SELECT concat(\"DROP TABLE IF EXISTS \", table_name, \";\") FROM information_schema.tables WHERE table_schema = \"$DATABASE\";\n\n**How to get the sizes of the tables of a mysql database?**\n\n    SELECT table_name AS \"Table\", round(((data_length + index_length) / 1024 / 1024), 2) \"Size in MB\" FROM information_schema.TABLES WHERE table_schema = \"$DB_NAME\" AND table_name = \"$TABLE_NAME\";\n\n**Disable ForeignKey check**\n\n    SET FOREIGN_KEY_CHECKS = 0;\n\n**Misc**\n[http://komlenic.com/244/8-reasons-why-mysqls-enum-data-type-is-evil/][1]\n\n    SELECT @resource:=id_acl_resource FROM pac_acl_resource WHERE NAME=\"catalog_product\";\n    INSERT IGNORE INTO pac_acl_privilege (fk_acl_resource, NAME, created_at, updated_at) VALUES (@resource, \"diet-tool-fallback\", now(), now());\n    SELECT @privilege:=id_acl_privilege FROM pac_acl_privilege WHERE fk_acl_resource=@resource AND NAME=\"diet-tool-fallback\";\n    INSERT IGNORE INTO pac_acl_role_privilege (fk_acl_role, fk_acl_resource, fk_acl_privilege) SELECT id_acl_role, @resource, @privilege FROM pac_acl_role WHERE NAME IN(\"developer\",\"admin\",\"system\",\"ProduktManager\",\"Senior Produkt Manager\");\n\n\n  [1]: http://komlenic.com/244/8-reasons-why-mysqls-enum-data-type-is-evil/</code></pre>';
        /** @var MarkdownParserInterface $mdParser */
        $mdParser = $this->container->get('markdown.parser');
        $search = array('\n', '\"');
        $replace = array(PHP_EOL, '"');
        $html = str_replace($search, $replace, $mdParser->transformMarkdown($text));
        $md = 'md';
        return $this->render('ShowNotesToZoidBundle:Default:test.html.twig', array('md' => $html));
    }
}
