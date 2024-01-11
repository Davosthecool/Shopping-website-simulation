<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240111073755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, tailles LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', couleurs LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', tags LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', marque VARCHAR(255) DEFAULT NULL, stock INT NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nb_articles INT NOT NULL, prix_total DOUBLE PRECISION NOT NULL, date_commande DATE DEFAULT NULL, date_envoi DATE DEFAULT NULL, date_arrivee DATE DEFAULT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exemplaire (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, taille INT NOT NULL, couleur VARCHAR(255) NOT NULL, INDEX IDX_5EF83C92C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, nb_articles INT NOT NULL, prix_total DOUBLE PRECISION NOT NULL, INDEX IDX_24CC0DF2FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier_exemplaire (panier_id INT NOT NULL, exemplaire_id INT NOT NULL, INDEX IDX_3A2D0507F77D927C (panier_id), INDEX IDX_3A2D05075843AA21 (exemplaire_id), PRIMARY KEY(panier_id, exemplaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pay_card (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, card_numbers INT NOT NULL, date_expiration DATE NOT NULL, cvc INT NOT NULL, INDEX IDX_458D4A74A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone_number INT DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_pay_card (profil_id INT NOT NULL, pay_card_id INT NOT NULL, INDEX IDX_59643FD9275ED078 (profil_id), INDEX IDX_59643FD9AC265DEB (pay_card_id), PRIMARY KEY(profil_id, pay_card_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, panier_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, sexe VARCHAR(1) NOT NULL, nom VARCHAR(64) NOT NULL, prenom VARCHAR(64) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_article (user_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_5A37106CA76ED395 (user_id), INDEX IDX_5A37106C7294869C (article_id), PRIMARY KEY(user_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C92C54C8C93 FOREIGN KEY (type_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE panier_exemplaire ADD CONSTRAINT FK_3A2D0507F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_exemplaire ADD CONSTRAINT FK_3A2D05075843AA21 FOREIGN KEY (exemplaire_id) REFERENCES exemplaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pay_card ADD CONSTRAINT FK_458D4A74A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE profil_pay_card ADD CONSTRAINT FK_59643FD9275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_pay_card ADD CONSTRAINT FK_59643FD9AC265DEB FOREIGN KEY (pay_card_id) REFERENCES pay_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE user_article ADD CONSTRAINT FK_5A37106CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_article ADD CONSTRAINT FK_5A37106C7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C92C54C8C93');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2FB88E14F');
        $this->addSql('ALTER TABLE panier_exemplaire DROP FOREIGN KEY FK_3A2D0507F77D927C');
        $this->addSql('ALTER TABLE panier_exemplaire DROP FOREIGN KEY FK_3A2D05075843AA21');
        $this->addSql('ALTER TABLE pay_card DROP FOREIGN KEY FK_458D4A74A76ED395');
        $this->addSql('ALTER TABLE profil_pay_card DROP FOREIGN KEY FK_59643FD9275ED078');
        $this->addSql('ALTER TABLE profil_pay_card DROP FOREIGN KEY FK_59643FD9AC265DEB');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F77D927C');
        $this->addSql('ALTER TABLE user_article DROP FOREIGN KEY FK_5A37106CA76ED395');
        $this->addSql('ALTER TABLE user_article DROP FOREIGN KEY FK_5A37106C7294869C');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE exemplaire');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_exemplaire');
        $this->addSql('DROP TABLE pay_card');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE profil_pay_card');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_article');
    }
}
