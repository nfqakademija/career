<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191116124904 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE manager_answer (id INT AUTO_INCREMENT NOT NULL, fk_user_answer_id INT NOT NULL, is_valid_answer TINYINT(1) DEFAULT NULL, comment VARCHAR(500) DEFAULT NULL, INDEX IDX_1CF84C57DFDD2C0A (fk_user_answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE career_profile (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE career_profile_criteria (career_profile_id INT NOT NULL, criteria_id INT NOT NULL, INDEX IDX_28F510DBC7864E52 (career_profile_id), INDEX IDX_28F510DB990BEA15 (criteria_id), PRIMARY KEY(career_profile_id, criteria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_answer (id INT AUTO_INCREMENT NOT NULL, fk_criteria_id INT NOT NULL, fk_choice_id INT DEFAULT NULL, fk_career_form_id INT NOT NULL, UNIQUE INDEX UNIQ_BF8F5118F0FD4621 (fk_criteria_id), UNIQUE INDEX UNIQ_BF8F5118F8DFB141 (fk_choice_id), INDEX IDX_BF8F5118C9999D18 (fk_career_form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE career_form (id INT AUTO_INCREMENT NOT NULL, fk_career_profile_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8C21DED69B1C0AA (fk_career_profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE manager_answer ADD CONSTRAINT FK_1CF84C57DFDD2C0A FOREIGN KEY (fk_user_answer_id) REFERENCES user_answer (id)');
        $this->addSql('ALTER TABLE career_profile_criteria ADD CONSTRAINT FK_28F510DBC7864E52 FOREIGN KEY (career_profile_id) REFERENCES career_profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE career_profile_criteria ADD CONSTRAINT FK_28F510DB990BEA15 FOREIGN KEY (criteria_id) REFERENCES criteria (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F5118F0FD4621 FOREIGN KEY (fk_criteria_id) REFERENCES criteria (id)');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F5118F8DFB141 FOREIGN KEY (fk_choice_id) REFERENCES criteria_choice (id)');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F5118C9999D18 FOREIGN KEY (fk_career_form_id) REFERENCES career_form (id)');
        $this->addSql('ALTER TABLE career_form ADD CONSTRAINT FK_8C21DED69B1C0AA FOREIGN KEY (fk_career_profile_id) REFERENCES career_profile (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE career_profile_criteria DROP FOREIGN KEY FK_28F510DBC7864E52');
        $this->addSql('ALTER TABLE career_form DROP FOREIGN KEY FK_8C21DED69B1C0AA');
        $this->addSql('ALTER TABLE manager_answer DROP FOREIGN KEY FK_1CF84C57DFDD2C0A');
        $this->addSql('ALTER TABLE user_answer DROP FOREIGN KEY FK_BF8F5118C9999D18');
        $this->addSql('DROP TABLE manager_answer');
        $this->addSql('DROP TABLE career_profile');
        $this->addSql('DROP TABLE career_profile_criteria');
        $this->addSql('DROP TABLE user_answer');
        $this->addSql('DROP TABLE career_form');
    }
}
