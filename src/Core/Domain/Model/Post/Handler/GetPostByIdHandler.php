<?php

declare(strict_types=1);

namespace Core\Domain\Model\Post\Handler;

use Core\Domain\Model\Post\Query\GetPostById;
use Core\Infrastructure\Projection\Post\PostFinder;
use React\Promise\Deferred;

class GetPostByIdHandler
{
    private $postFinder;

    public function __construct(PostFinder $postFinder)
    {
        $this->postFinder = $postFinder;
    }

    public function __invoke(GetPostById $query, Deferred $deferred = null)
    {
        $post = $this->postFinder->findById($query->postId());
        if (null === $deferred) {
            return $post;
        }

        $deferred->resolve($post);
    }
}
