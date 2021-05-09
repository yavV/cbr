<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20120507115234  extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $sql = <<<SQL
CREATE TABLE currency (
    id bigint NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    eng_name varchar(255) NOT NULL,
    nominal int NOT NULL,
    iso_num_code int NOT NULL,
    iso_char_code varchar(3) NOT NULL,
    PRIMARY KEY (id)
)
SQL;
        $this->addSql($sql);

    }

    public function down(Schema $schema): void
    {
        $sql = <<<SQL
DROP TABLE currency
SQL;
        $this->addSql($sql);
    }
}
