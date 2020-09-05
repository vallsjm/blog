<?php

declare(strict_types=1);

namespace Core\Domain\Model\Author\Handler;

use Core\Domain\Model\Author\Author;
use Core\Domain\Model\Author\AuthorCollectionInterface;
use Core\Domain\Model\Author\Command\RegisterAuthor;

class RegisterAuthorHandler
{
    /**
     * @var AuthorCollectionInterface
     */
    private $authorCollection;

    public function __construct(
        AuthorCollectionInterface $authorCollection
    ) {
        $this->authorCollection = $authorCollection;
    }

    public function __invoke(RegisterAuthor $command): void
    {
        if ($author = $this->authorCollection->get($command->authorId())) {
            throw new \InvalidArgumentException(\sprintf('Author with id %s already exists.', (string) $command->authorId()));
        }

        $author = Author::registerWithData(
            $command->authorId(),
            $command->name(),
            $command->surname()
        );

        $this->authorCollection->save($author);
    }
}
