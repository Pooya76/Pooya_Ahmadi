<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220621094412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9B03A8386');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9896DBBDE');
        $this->addSql('DROP INDEX fk_3535ed9b03a8386 ON hotel');
        $this->addSql('CREATE INDEX IDX_3535ED9B03A8386 ON hotel (created_by_id)');
        $this->addSql('DROP INDEX fk_3535ed9896dbbde ON hotel');
        $this->addSql('CREATE INDEX IDX_3535ED9896DBBDE ON hotel (updated_by_id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE room ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519BB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_729F519B896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_729F519BB03A8386 ON room (created_by_id)');
        $this->addSql('CREATE INDEX IDX_729F519B896DBBDE ON room (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9B03A8386');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED9896DBBDE');
        $this->addSql('DROP INDEX idx_3535ed9b03a8386 ON hotel');
        $this->addSql('CREATE INDEX FK_3535ED9B03A8386 ON hotel (created_by_id)');
        $this->addSql('DROP INDEX idx_3535ed9896dbbde ON hotel');
        $this->addSql('CREATE INDEX FK_3535ED9896DBBDE ON hotel (updated_by_id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED9896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519BB03A8386');
        $this->addSql('ALTER TABLE room DROP FOREIGN KEY FK_729F519B896DBBDE');
        $this->addSql('DROP INDEX IDX_729F519BB03A8386 ON room');
        $this->addSql('DROP INDEX IDX_729F519B896DBBDE ON room');
        $this->addSql('ALTER TABLE room DROP created_by_id, DROP updated_by_id');
    }
}
