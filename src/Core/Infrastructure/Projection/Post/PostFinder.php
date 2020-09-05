<?php

declare(strict_types=1);

namespace Core\Infrastructure\Projection\Post;

use Common\Infrastructure\Projection\BaseFinder;
use Core\Infrastructure\Projection\Table;

final class PostFinder extends BaseFinder
{
    public function findAll(): array
    {
        return $this->connection->fetchAll(\sprintf('SELECT * FROM %s', Table::POST));
    }

    public function findByAuthorId(string $authorId): array
    {
        return $this->connection->fetchAll(
            \sprintf('SELECT * FROM %s WHERE author_id = :author_id', Table::POST),
            ['author_id' => $authorId]
        );
    }

    public function findById(string $postId): ?array
    {
        $stmt = $this->connection->prepare(\sprintf('SELECT * FROM %s where id = :post_id', Table::POST));
        $stmt->bindValue('post_id', $postId);
        $stmt->execute();

        $result = $stmt->fetch();

        if (false === $result) {
            return null;
        }

        return $result;
    }
}
