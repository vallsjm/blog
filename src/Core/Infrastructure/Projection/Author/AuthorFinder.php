<?php

declare(strict_types=1);

namespace Core\Infrastructure\Projection\Author;

use Common\Infrastructure\Projection\BaseFinder;
use Core\Infrastructure\Projection\Table;

final class AuthorFinder extends BaseFinder
{
    public function findAll(): array
    {
        return $this->connection->fetchAll(\sprintf('SELECT * FROM %s', Table::AUTHOR));
    }

    public function findById(string $authorId): ?array
    {
        $stmt = $this->connection->prepare(\sprintf('SELECT * FROM %s WHERE id = :author_id', Table::AUTHOR));
        $stmt->bindValue('author_id', $authorId);
        $stmt->execute();

        $result = $stmt->fetch();

        if (false === $result) {
            return null;
        }

        return $result;
    }

    public function findAuthorOfPost(string $postId): ?array
    {
        $stmt = $this->connection->prepare(\sprintf(
            'SELECT u.* FROM %s as u JOIN %s as t ON u.id = t.author_id WHERE t.id = :post_id',
            Table::AUTHOR,
            Table::POST
        ));
        $stmt->bindValue('post_id', $postId);
        $stmt->execute();

        $result = $stmt->fetch();

        if (false === $result) {
            return null;
        }

        return $result;
    }
}
