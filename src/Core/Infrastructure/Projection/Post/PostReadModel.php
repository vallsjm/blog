<?php

declare(strict_types=1);

namespace Core\Infrastructure\Projection\Post;

use Common\Infrastructure\Projection\BaseReadModel;
use Core\Infrastructure\Projection\Table;

final class PostReadModel extends BaseReadModel
{
    public function getTableName(): string
    {
        return Table::POST;
    }

    public function init(): void
    {
        $sql = <<<EOT
CREATE TABLE `$this->tableName` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `author_id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(120) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_author` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
EOT;

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }
}
