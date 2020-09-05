<?php

declare(strict_types=1);

namespace Core\Application\Service;

use Common\Application\Service\BaseService;
use Core\Domain\Model\Author\AuthorId;

final class AuthorService extends BaseService
{
    public function createFromPayload(array $payload): ?array
    {
        $payload['author_id'] = $payload['id'] ?? (string) AuthorId::generate();

        $command = $this->messageFactory->createMessageFromArray(
            'Core\Domain\Model\Author\Command\RegisterAuthor', ['payload' => $payload]
        );

        $this->commandBus->dispatch($command);

        $payload['id'] = $payload['author_id'];
        unset($payload['author_id']);

        return $payload;
    }

    public function findOneById(?string $id = null): ?array
    {
        $payload = [
            'author_id' => $id,
        ];

        $query = $this->messageFactory->createMessageFromArray(
            'Core\Domain\Model\Author\Query\GetAuthorById', ['payload' => $payload]
        );

        $author = [];
        $this->queryBus->dispatch($query)->then(function ($result) use (&$author) {
            $author = $result;
        });

        return $author;
    }
}
