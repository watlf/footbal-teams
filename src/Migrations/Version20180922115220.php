<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180922115220 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT IGNORE INTO league (`name`) VALUES ('UK Premier League')");

        $this->addSql("INSERT IGNORE INTO team (`name`, `strip`, `league_id`) VALUES ('Arsenal', 'test', 1), ('Aston Villa', 'test', 1)");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
