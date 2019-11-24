<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191124170814 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE manager_answer CHANGE is_valid_answer is_valid_answer TINYINT(1) DEFAULT NULL, CHANGE comment comment VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE career_profile ADD profession_id INT NOT NULL, ADD is_archived TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE career_profile ADD CONSTRAINT FK_62364583FDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_62364583FDEF8996 ON career_profile (profession_id)');
        $this->addSql('ALTER TABLE user_answer CHANGE fk_choice_id fk_choice_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE career_form ADD is_archived TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE career_form DROP is_archived');
        $this->addSql('ALTER TABLE career_profile DROP FOREIGN KEY FK_62364583FDEF8996');
        $this->addSql('DROP INDEX UNIQ_62364583FDEF8996 ON career_profile');
        $this->addSql('ALTER TABLE career_profile DROP profession_id, DROP is_archived');
        $this->addSql('ALTER TABLE manager_answer CHANGE is_valid_answer is_valid_answer TINYINT(1) DEFAULT \'NULL\', CHANGE comment comment VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE user_answer CHANGE fk_choice_id fk_choice_id INT DEFAULT NULL');
    }
}
