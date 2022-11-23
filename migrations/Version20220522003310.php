<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220522003310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse_livraison (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, lieu_livraison LONGTEXT DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, INDEX IDX_B0B09C919EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_produits (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_86AA9EE6727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie_produits_produits (categorie_produits_id INT NOT NULL, produits_id INT NOT NULL, INDEX IDX_C8F9BFAB12EF84C6 (categorie_produits_id), INDEX IDX_C8F9BFABCD11A2CF (produits_id), PRIMARY KEY(categorie_produits_id, produits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, date_commande DATETIME DEFAULT NULL, etat_paiement TINYINT(1) DEFAULT NULL, etat_livraison VARCHAR(255) DEFAULT NULL, terminal VARCHAR(255) DEFAULT NULL, reference_paiement VARCHAR(255) DEFAULT NULL, INDEX IDX_35D4282C19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images_produits (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, lien VARCHAR(255) DEFAULT NULL, INDEX IDX_1D0EA2E6F347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lignes_commandes (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, commande_id INT DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, quantite INT DEFAULT NULL, unite_mesure VARCHAR(255) DEFAULT NULL, INDEX IDX_17627A3CF347EFB (produit_id), INDEX IDX_17627A3C82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, libelle VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, disponibilite VARCHAR(255) DEFAULT NULL, unite_mesure VARCHAR(255) DEFAULT NULL, type_prix VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, stock DOUBLE PRECISION DEFAULT NULL, localite VARCHAR(255) DEFAULT NULL, valide TINYINT(1) DEFAULT NULL, feature TINYINT(1) DEFAULT NULL, terminal VARCHAR(255) DEFAULT NULL, INDEX IDX_BE2DDF8CFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, telephone VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenoms VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, sexe VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, secteur_activite VARCHAR(255) DEFAULT NULL, terminal VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649450FF010 (telephone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresse_livraison ADD CONSTRAINT FK_B0B09C919EB6921 FOREIGN KEY (client_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE categorie_produits ADD CONSTRAINT FK_86AA9EE6727ACA70 FOREIGN KEY (parent_id) REFERENCES categorie_produits (id)');
        $this->addSql('ALTER TABLE categorie_produits_produits ADD CONSTRAINT FK_C8F9BFAB12EF84C6 FOREIGN KEY (categorie_produits_id) REFERENCES categorie_produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie_produits_produits ADD CONSTRAINT FK_C8F9BFABCD11A2CF FOREIGN KEY (produits_id) REFERENCES produits (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C19EB6921 FOREIGN KEY (client_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE images_produits ADD CONSTRAINT FK_1D0EA2E6F347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE lignes_commandes ADD CONSTRAINT FK_17627A3CF347EFB FOREIGN KEY (produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE lignes_commandes ADD CONSTRAINT FK_17627A3C82EA2E54 FOREIGN KEY (commande_id) REFERENCES commandes (id)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_produits DROP FOREIGN KEY FK_86AA9EE6727ACA70');
        $this->addSql('ALTER TABLE categorie_produits_produits DROP FOREIGN KEY FK_C8F9BFAB12EF84C6');
        $this->addSql('ALTER TABLE lignes_commandes DROP FOREIGN KEY FK_17627A3C82EA2E54');
        $this->addSql('ALTER TABLE categorie_produits_produits DROP FOREIGN KEY FK_C8F9BFABCD11A2CF');
        $this->addSql('ALTER TABLE images_produits DROP FOREIGN KEY FK_1D0EA2E6F347EFB');
        $this->addSql('ALTER TABLE lignes_commandes DROP FOREIGN KEY FK_17627A3CF347EFB');
        $this->addSql('ALTER TABLE adresse_livraison DROP FOREIGN KEY FK_B0B09C919EB6921');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C19EB6921');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8CFB88E14F');
        $this->addSql('DROP TABLE adresse_livraison');
        $this->addSql('DROP TABLE categorie_produits');
        $this->addSql('DROP TABLE categorie_produits_produits');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE images_produits');
        $this->addSql('DROP TABLE lignes_commandes');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
