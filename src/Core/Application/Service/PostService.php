<?php

declare(strict_types=1);

namespace Core\Application\Service;

use Common\Application\Service\BaseService;
use Core\Domain\Model\Post\PostId;

final class PostService extends BaseService
{
    public function createFromPayload(array $payload): ?array
    {
        $payload['post_id'] = $payload['id'] ?? (string) PostId::generate();

        $command = $this->messageFactory->createMessageFromArray(
            'Core\Domain\Model\Post\Command\CreatePost', ['payload' => $payload]
        );

        $this->commandBus->dispatch($command);

        $payload['id'] = $payload['post_id'];
        unset($payload['post_id']);

        return $payload;
    }

    public function findOneById(?string $id = null): ?array
    {
        $payload = [
            'post_id' => $id,
        ];

        $query = $this->messageFactory->createMessageFromArray(
            'Core\Domain\Model\Post\Query\GetPostById', ['payload' => $payload]
        );

        $post = [];
        $this->queryBus->dispatch($query)->then(function ($result) use (&$post) {
            $post = $result;
        });

        return $post;
    }
}
