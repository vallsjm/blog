<?php

declare(strict_types=1);

namespace Core\Domain\Model\Post\Query;

use Common\Domain\Query\BaseQuery;

final class GetPostById extends BaseQuery
{
    public function __construct(string $postId)
    {
        $this->init();
        $this->setPayload([
            'post_id' => $postId,
        ]);
    }

    public static function withData(string $postId): GetPostById
    {
        return new self($postId);
    }

    public function postId(): string
    {
        return $this->payload['post_id'];
    }
}
