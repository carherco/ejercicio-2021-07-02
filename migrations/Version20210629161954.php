<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629161954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fondo_autor (fondo_id INT NOT NULL, autor_id INT NOT NULL, INDEX IDX_44096994AA510E89 (fondo_id), INDEX IDX_4409699414D45BBE (autor_id), PRIMARY KEY(fondo_id, autor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fondo_autor ADD CONSTRAINT FK_44096994AA510E89 FOREIGN KEY (fondo_id) REFERENCES fondo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fondo_autor ADD CONSTRAINT FK_4409699414D45BBE FOREIGN KEY (autor_id) REFERENCES autor (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fondo_autor');
    }
}
