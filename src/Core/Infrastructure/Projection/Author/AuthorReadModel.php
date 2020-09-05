<?php

declare(strict_types=1);

namespace Core\Infrastructure\Projection\Author;

use Common\Infrastructure\Projection\BaseReadModel;
use Core\Infrastructure\Projection\Table;

final class AuthorReadModel extends BaseReadModel
{
    public function getTableName(): string
    {
        return Table::AUTHOR;
    }

    public function init(): void
    {
        $sql = <<<EOT
CREATE TABLE `$this->tableName` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
EOT;

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }
}
