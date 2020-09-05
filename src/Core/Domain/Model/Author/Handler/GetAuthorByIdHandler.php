<?php

declare(strict_types=1);

namespace Core\Domain\Model\Author\Handler;

use Core\Domain\Model\Author\Query\GetAuthorById;
use Core\Infrastructure\Projection\Author\AuthorFinder;
use React\Promise\Deferred;

class GetAuthorByIdHandler
{
    private $authorFinder;

    public function __construct(AuthorFinder $authorFinder)
    {
        $this->authorFinder = $authorFinder;
    }

    public function __invoke(GetAuthorById $query, Deferred $deferred = null)
    {
        $author = $this->authorFinder->findById($query->authorId());
        if (null === $deferred) {
            return $author;
        }

        $deferred->resolve($author);
    }
}
