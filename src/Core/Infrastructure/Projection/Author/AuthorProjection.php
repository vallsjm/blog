<?php

declare(strict_types=1);

namespace Core\Infrastructure\Projection\Author;

use Common\Infrastructure\Projection\BaseReadProjection;
use Core\Domain\Model\Author\Event\AuthorWasRegistered;

final class AuthorProjection extends BaseReadProjection
{
    public function listenerList(): array
    {
        return [
            AuthorWasRegistered::class => function ($state, AuthorWasRegistered $event) {
                /** @var AuthorReadModel $readModel */
                // @phpstan-ignore-next-line
                $readModel = $this->readModel();
                $readModel->stack('insert', [
                    'id' => (string) $event->authorId(),
                    'name' => (string) $event->name(),
                    'surname' => (string) $event->surname(),
                ]);
            },
        ];
    }
}
