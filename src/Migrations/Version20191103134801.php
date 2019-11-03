<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191103134801 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE e_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE e_post ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE e_post ADD CONSTRAINT FK_2876D4C112469DE2 FOREIGN KEY (category_id) REFERENCES e_category (id)');
        $this->addSql('CREATE INDEX IDX_2876D4C112469DE2 ON e_post (category_id)');
        $this->addSql('ALTER TABLE fos_user CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE e_post DROP FOREIGN KEY FK_2876D4C112469DE2');
        $this->addSql('DROP TABLE e_category');
        $this->addSql('DROP INDEX IDX_2876D4C112469DE2 ON e_post');
        $this->addSql('ALTER TABLE e_post DROP category_id');
        $this->addSql('ALTER TABLE fos_user CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
