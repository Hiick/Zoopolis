<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191129114114 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE token (idtoken VARCHAR(80) NOT NULL, user_iduser INT DEFAULT NULL, type VARCHAR(255) DEFAULT \'Bearer\' NOT NULL, decive VARCHAR(255) DEFAULT \'Destop\' NOT NULL, lat VARCHAR(45) NOT NULL, lon VARCHAR(45) NOT NULL, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX fk_token_user_idx (user_iduser), UNIQUE INDEX idtoken_UNIQUE (idtoken), PRIMARY KEY(idtoken)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (iduser INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(45) NOT NULL, lastname VARCHAR(45) NOT NULL, email VARCHAR(155) NOT NULL, password VARCHAR(80) NOT NULL, street VARCHAR(155) NOT NULL, zip VARCHAR(20) NOT NULL, city VARCHAR(50) NOT NULL, country VARCHAR(45) DEFAULT \'France\' NOT NULL, birthday DATE NOT NULL, sexe VARCHAR(255) DEFAULT \'Femme\' NOT NULL, active TINYINT(1) DEFAULT \'1\' NOT NULL, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updetedAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX email_UNIQUE (email), PRIMARY KEY(iduser)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location (idlocation INT NOT NULL, pet_idpet INT NOT NULL, lat VARCHAR(45) NOT NULL, lon VARCHAR(45) NOT NULL, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX fk_location_pet1_idx (pet_idpet), PRIMARY KEY(idlocation, pet_idpet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pet (idpet INT AUTO_INCREMENT NOT NULL, user_iduser INT DEFAULT NULL, name VARCHAR(45) DEFAULT \'Rex\' NOT NULL, type VARCHAR(60) DEFAULT \'Chien\' NOT NULL, race VARCHAR(50) NOT NULL, birthday DATE NOT NULL, sexe VARCHAR(255) DEFAULT \'Homme\' NOT NULL, dateAcquisition DATE NOT NULL, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX fk_pet_user1_idx (user_iduser), PRIMARY KEY(idpet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE billing (idbilling INT AUTO_INCREMENT NOT NULL, user_iduser INT DEFAULT NULL, dateBilling DATE NOT NULL, amount NUMERIC(16, 3) NOT NULL, createdAt DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX fk_billing_user1_idx (user_iduser), PRIMARY KEY(idbilling)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13B3B0E3CD4 FOREIGN KEY (user_iduser) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB502B0041 FOREIGN KEY (pet_idpet) REFERENCES pet (idpet)');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B853B0E3CD4 FOREIGN KEY (user_iduser) REFERENCES user (iduser)');
        $this->addSql('ALTER TABLE billing ADD CONSTRAINT FK_EC224CAA3B0E3CD4 FOREIGN KEY (user_iduser) REFERENCES user (iduser)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13B3B0E3CD4');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B853B0E3CD4');
        $this->addSql('ALTER TABLE billing DROP FOREIGN KEY FK_EC224CAA3B0E3CD4');
        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB502B0041');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE pet');
        $this->addSql('DROP TABLE billing');
    }
}
