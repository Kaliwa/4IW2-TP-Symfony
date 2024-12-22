<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221223316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapter DROP CONSTRAINT fk_f981b52e6ed75f8f');
        $this->addSql('DROP INDEX idx_f981b52e6ed75f8f');
        $this->addSql('ALTER TABLE chapter RENAME COLUMN subject_id_id TO subject_id');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F981B52E23EDC87 ON chapter (subject_id)');
        $this->addSql('ALTER TABLE exercise DROP CONSTRAINT FK_AEDAD51CFF0D08E8');
        $this->addSql('ALTER TABLE exercise ALTER chapter_id_id SET NOT NULL');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51CFF0D08E8 FOREIGN KEY (chapter_id_id) REFERENCES chapter (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6493633CA6F');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6493633CA6F FOREIGN KEY (classe_id_id) REFERENCES classroom (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE exercise DROP CONSTRAINT fk_aedad51cff0d08e8');
        $this->addSql('ALTER TABLE exercise ALTER chapter_id_id DROP NOT NULL');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT fk_aedad51cff0d08e8 FOREIGN KEY (chapter_id_id) REFERENCES chapter (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chapter DROP CONSTRAINT FK_F981B52E23EDC87');
        $this->addSql('DROP INDEX IDX_F981B52E23EDC87');
        $this->addSql('ALTER TABLE chapter RENAME COLUMN subject_id TO subject_id_id');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT fk_f981b52e6ed75f8f FOREIGN KEY (subject_id_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f981b52e6ed75f8f ON chapter (subject_id_id)');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d6493633ca6f');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d6493633ca6f FOREIGN KEY (classe_id_id) REFERENCES classroom (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
