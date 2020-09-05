<?php

declare(strict_types=1);

namespace Core\Domain\Model\Post;

interface PostCollectionInterface
{
    public function save(Post $post): void;

    public function get(PostId $postId): ?Post;
}
