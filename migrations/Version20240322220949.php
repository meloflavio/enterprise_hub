<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240322220949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO user (id, username, username_canonical, password, email, email_canonical, roles, enabled, created_at, updated_at) VALUES (1, \'admin\', \'admin\', \'$2y$13\$iYm4Z7kXvvMGMIQ52RBDJumTlZPPhoIsBLUubwJAlEBF6v/p5xuWC\', \'admin@enterprisehub.com\', \'admin@enterprisehub.com\', \'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}\', 1, \'2024-03-22 22:04:44\', \'2024-03-22 22:04:44\')');
        $this->addSql('INSERT INTO user (id, username, username_canonical, password, email, email_canonical, roles, enabled, created_at, updated_at) VALUES (2, \'user\', \'user\', \'$2y$13$MxcihW/TSZ59QL5FzNJPseD/mp2cQ8s4VIV6WqZKEMO2Nsx1rvbIC\', \'user@enterprisehub.com\', \'user@enterprisehub.com\', \'a:0:{}\', 1, \'2024-03-22 22:31:06\', \'2024-03-22 22:31:06\')');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM user WHERE id = 1');
        $this->addSql('DELETE FROM user WHERE id = 2');


    }
}
