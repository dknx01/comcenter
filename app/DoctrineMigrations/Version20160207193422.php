<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160207193422 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE `rssCleaner__expressions` ADD  `active` TINYINT NOT NULL DEFAULT  \'1\'');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
       $this->addSql('ALTER TABLE `rssCleaner__expressions` DROP  `active`');
    }
}
