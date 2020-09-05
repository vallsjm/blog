<?php

declare(strict_types=1);

namespace Core\Infrastructure\Projection\Post;

use Common\Infrastructure\Projection\BaseReadProjection;
use Core\Domain\Model\Post\Event\PostWasCreated;

final class PostProjection extends BaseReadProjection
{
    public function listenerList(): array
    {
        return [
            PostWasCreated::class => function ($state, PostWasCreated $event) {
                /** @var PostReadModel $readModel */
                // @phpstan-ignore-next-line
                $readModel = $this->readModel();
                $readModel->stack('insert', [
                    'id' => (string) $event->postId(),
                    'author_id' => (string) $event->authorId(),
                    'title' => (string) $event->title(),
                    'description' => (string) $event->description(),
                    'content' => (string) $event->content(),
                ]);
            },
        ];
    }
}
