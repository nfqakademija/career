<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191106201836 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE criteria (id INT AUTO_INCREMENT NOT NULL, fk_competence_id INT NOT NULL, title VARCHAR(255) NOT NULL, is_applicable TINYINT(1) NOT NULL, INDEX IDX_B61F9B81713C6869 (fk_competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE criteria ADD CONSTRAINT FK_B61F9B81713C6869 FOREIGN KEY (fk_competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competence ADD is_applicable TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE criteria');
        $this->addSql('ALTER TABLE competence DROP is_applicable');
    }
}
