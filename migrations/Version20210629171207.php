<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629171207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fondo ADD editorial_id INT NOT NULL');
        $this->addSql('ALTER TABLE fondo ADD CONSTRAINT FK_2DC0A6E5BAF1A24D FOREIGN KEY (editorial_id) REFERENCES editorial (id)');
        $this->addSql('CREATE INDEX IDX_2DC0A6E5BAF1A24D ON fondo (editorial_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fondo DROP FOREIGN KEY FK_2DC0A6E5BAF1A24D');
        $this->addSql('DROP INDEX IDX_2DC0A6E5BAF1A24D ON fondo');
        $this->addSql('ALTER TABLE fondo DROP editorial_id');
    }
}
