<?php

declare(strict_types=1);

namespace Core\Domain\Model\Post\Query;

final class GetPostsByAuthorId
{
    /**
     * @var string
     */
    private $authorId;

    public function __construct(string $authorId)
    {
        $this->authorId = $authorId;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }
}
