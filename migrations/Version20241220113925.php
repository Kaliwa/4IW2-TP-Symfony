<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20241220113925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE chapter (id SERIAL NOT NULL, subject_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F981B52E6ED75F8F ON chapter (subject_id_id)');
        $this->addSql('CREATE TABLE classroom (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE classroom_subject (classroom_id INT NOT NULL, subject_id INT NOT NULL, PRIMARY KEY(classroom_id, subject_id))');
        $this->addSql('CREATE INDEX IDX_713FFF526278D5A8 ON classroom_subject (classroom_id)');
        $this->addSql('CREATE INDEX IDX_713FFF5223EDC87 ON classroom_subject (subject_id)');
        $this->addSql('CREATE TABLE comment (id SERIAL NOT NULL, user_id_id INT NOT NULL, exercise_id_id INT NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526C9D86650F ON comment (user_id_id)');
        $this->addSql('CREATE INDEX IDX_9474526C5A726995 ON comment (exercise_id_id)');
        $this->addSql('CREATE TABLE exercise (id SERIAL NOT NULL, chapter_id_id INT NOT NULL, question TEXT NOT NULL, response TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AEDAD51CFF0D08E8 ON exercise (chapter_id_id)');
        $this->addSql('CREATE TABLE subject (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, classe_id_id INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D6493633CA6F ON "user" (classe_id_id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E6ED75F8F FOREIGN KEY (subject_id_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classroom_subject ADD CONSTRAINT FK_713FFF526278D5A8 FOREIGN KEY (classroom_id) REFERENCES classroom (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE classroom_subject ADD CONSTRAINT FK_713FFF5223EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C9D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5A726995 FOREIGN KEY (exercise_id_id) REFERENCES exercise (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE exercise ADD CONSTRAINT FK_AEDAD51CFF0D08E8 FOREIGN KEY (chapter_id_id) REFERENCES chapter (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6493633CA6F FOREIGN KEY (classe_id_id) REFERENCES classroom (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chapter DROP CONSTRAINT FK_F981B52E6ED75F8F');
        $this->addSql('ALTER TABLE classroom_subject DROP CONSTRAINT FK_713FFF526278D5A8');
        $this->addSql('ALTER TABLE classroom_subject DROP CONSTRAINT FK_713FFF5223EDC87');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C9D86650F');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C5A726995');
        $this->addSql('ALTER TABLE exercise DROP CONSTRAINT FK_AEDAD51CFF0D08E8');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6493633CA6F');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE classroom_subject');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE exercise');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE "user"');
    }
}
