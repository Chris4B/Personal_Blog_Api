<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240716123908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_category (post_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(post_id, category_id))');
        $this->addSql('CREATE INDEX IDX_B9A190604B89032C ON post_category (post_id)');
        $this->addSql('CREATE INDEX IDX_B9A1906012469DE2 ON post_category (category_id)');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A190604B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A1906012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD posts_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD userid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD5E258C5 FOREIGN KEY (posts_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C58E0A285 FOREIGN KEY (userid_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9474526CD5E258C5 ON comment (posts_id)');
        $this->addSql('CREATE INDEX IDX_9474526C58E0A285 ON comment (userid_id)');
        $this->addSql('ALTER TABLE post ADD userid_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D58E0A285 FOREIGN KEY (userid_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D58E0A285 ON post (userid_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE post_category DROP CONSTRAINT FK_B9A190604B89032C');
        $this->addSql('ALTER TABLE post_category DROP CONSTRAINT FK_B9A1906012469DE2');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8D58E0A285');
        $this->addSql('DROP INDEX IDX_5A8A6C8D58E0A285');
        $this->addSql('ALTER TABLE post DROP userid_id');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CD5E258C5');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C58E0A285');
        $this->addSql('DROP INDEX IDX_9474526CD5E258C5');
        $this->addSql('DROP INDEX IDX_9474526C58E0A285');
        $this->addSql('ALTER TABLE comment DROP posts_id');
        $this->addSql('ALTER TABLE comment DROP userid_id');
    }
}
