<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181126141436 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS company (id INT AUTO_INCREMENT NOT NULL, api_key VARCHAR(255) NOT NULL, api_password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, roles TEXT DEFAULT NULL, UNIQUE INDEX UNIQ_4FBF094FC912ED9D (api_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;'
        );
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS company_customer (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_99AE9B64E7927C74 (email), INDEX IDX_99AE9B64979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;'
        );
        $this->addSql(
            'CREATE TABLE IF NOT EXISTS mobile_phone (id INT AUTO_INCREMENT NOT NULL, brand VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, os VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, screen_size VARCHAR(255) DEFAULT NULL, storage VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_AA926915E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;'
        );
        $this->addSql(
            'ALTER TABLE company_customer ADD CONSTRAINT FK_99AE9B64979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id);'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS company_customer');
        $this->addSql('DROP TABLE IF EXISTS mobile_phone');
        $this->addSql('DROP TABLE IF EXISTS company');
    }
}
