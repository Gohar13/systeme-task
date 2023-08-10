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

        $this->addSql('INSERT INTO countries (name, tax_percentage, tax_number_pattern)
                            VALUES (\'Германии\', 19, \'DEXXXXXXXXX\'),
                                    (\'Италии\', 22, \'ITXXXXXXXXXXX\'),
                                    (\'Франции\', 20, \'GRXXXXXXXXX\'),
                                    (\'Греции\', 24, \'FRYYXXXXXXXXX\')');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
