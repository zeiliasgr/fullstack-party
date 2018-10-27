<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181027192451 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE issue DROP FOREIGN KEY FK_12AD233E63379586');
        $this->addSql('DROP INDEX IDX_12AD233E63379586 ON issue');
        $this->addSql('ALTER TABLE issue DROP comments_id');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CEDCEF704');
        $this->addSql('DROP INDEX IDX_9474526CEDCEF704 ON comment');
        $this->addSql('ALTER TABLE comment CHANGE issue_id_id issue_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id)');
        $this->addSql('CREATE INDEX IDX_9474526C5E7AA58C ON comment (issue_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5E7AA58C');
        $this->addSql('DROP INDEX IDX_9474526C5E7AA58C ON comment');
        $this->addSql('ALTER TABLE comment CHANGE issue_id issue_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEDCEF704 FOREIGN KEY (issue_id_id) REFERENCES issue (id)');
        $this->addSql('CREATE INDEX IDX_9474526CEDCEF704 ON comment (issue_id_id)');
        $this->addSql('ALTER TABLE issue ADD comments_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE issue ADD CONSTRAINT FK_12AD233E63379586 FOREIGN KEY (comments_id) REFERENCES comment (id)');
        $this->addSql('CREATE INDEX IDX_12AD233E63379586 ON issue (comments_id)');
    }
}
