<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230810111134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Inserting dump products and countries to DB';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO products (name, price) VALUES (\'Iphone\', 100.0),(\'Наушники\', 20.0),(\'Чехол\', 10.0)');

        $this->addSql('INSERT INTO coupons (code, sale_value, sale_type) VALUES (\'D15\', 10, \'fixed\'), (\'G15\', 5, \'in_percentage\')');

        $this->addSql('INSERT INTO countries (name, tax_percentage, tax_number_pattern)
                            VALUES (\'Германии\', 19, \'/^DE\\\\d{9}$/\'),
                                    (\'Италии\', 22, \'/^IT\\\\d{11}$/\'),
                                    (\'Франции\', 20, \'/^FR[a-zA-Z]{2}\\\\d{9}$/\'),
                                    (\'Греции\', 24, \'/^GR\\\\d{9}$/\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
