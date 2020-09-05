<?php

declare(strict_types=1);

namespace Core\Domain\Model\Author\Query;

use Common\Domain\Query\BaseQuery;

final class GetAuthorById extends BaseQuery
{
    public function __construct(string $authorId)
    {
        $this->init();
        $this->setPayload([
            'author_id' => $authorId,
        ]);
    }

    public static function withData(string $authorId): GetAuthorById
    {
        return new self($authorId);
    }

    public function authorId(): string
    {
        return $this->payload['author_id'];
    }
}
