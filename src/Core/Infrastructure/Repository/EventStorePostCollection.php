<?php

declare(strict_types=1);

namespace Core\Infrastructure\Repository;

use Core\Domain\Model\Post\Post;
use Core\Domain\Model\Post\PostCollectionInterface;
use Core\Domain\Model\Post\PostId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

final class EventStorePostCollection extends AggregateRepository implements PostCollectionInterface
{
    public function save(Post $post): void
    {
        $this->saveAggregateRoot($post);
    }

    public function get(PostId $postId): ?Post
    {
        return $this->getAggregateRoot((string) $postId);
    }
}
