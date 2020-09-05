<?php

declare(strict_types=1);

namespace Core\Infrastructure\Repository;

use Core\Domain\Model\Author\Author;
use Core\Domain\Model\Author\AuthorCollectionInterface;
use Core\Domain\Model\Author\AuthorId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

final class EventStoreAuthorCollection extends AggregateRepository implements AuthorCollectionInterface
{
    public function save(Author $author): void
    {
        $this->saveAggregateRoot($author);
    }

    public function get(AuthorId $authorId): ?Author
    {
        return $this->getAggregateRoot((string) $authorId);
    }
}
