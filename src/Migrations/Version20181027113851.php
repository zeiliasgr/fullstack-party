<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181027113851 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE issue (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, date DATETIME NOT NULL, started_by INT NOT NULL, open_status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE issue_label (issue_id INT NOT NULL, label_id INT NOT NULL, INDEX IDX_9C2D39BB5E7AA58C (issue_id), INDEX IDX_9C2D39BB33B92F39 (label_id), PRIMARY KEY(issue_id, label_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, body LONGTEXT NOT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE label (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE issue_label ADD CONSTRAINT FK_9C2D39BB5E7AA58C FOREIGN KEY (issue_id) REFERENCES issue (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE issue_label ADD CONSTRAINT FK_9C2D39BB33B92F39 FOREIGN KEY (label_id) REFERENCES label (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE issue_label DROP FOREIGN KEY FK_9C2D39BB5E7AA58C');
        $this->addSql('ALTER TABLE issue_label DROP FOREIGN KEY FK_9C2D39BB33B92F39');
        $this->addSql('DROP TABLE issue');
        $this->addSql('DROP TABLE issue_label');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE label');
    }
}
