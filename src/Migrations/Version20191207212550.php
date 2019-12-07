<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191207212550 extends AbstractMigration
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
        $this->addSql('ALTER TABLE user_answer CHANGE fk_choice_id fk_choice_id INT DEFAULT NULL, CHANGE comment comment VARCHAR(500) DEFAULT NULL');
        $this->addSql('CREATE INDEX answer_idx ON user_answer (fk_career_form_id, fk_criteria_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE manager_answer CHANGE is_valid_answer is_valid_answer TINYINT(1) DEFAULT \'NULL\', CHANGE comment comment VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('DROP INDEX answer_idx ON user_answer');
        $this->addSql('ALTER TABLE user_answer CHANGE fk_choice_id fk_choice_id INT DEFAULT NULL, CHANGE comment comment VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
