<?php

declare(strict_types=1);

namespace Core\Domain\Model\Author;

interface AuthorCollectionInterface
{
    public function save(Author $author): void;

    public function get(AuthorId $authorId): ?Author;
}
