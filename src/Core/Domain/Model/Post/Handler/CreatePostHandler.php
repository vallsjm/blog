<?php

declare(strict_types=1);

namespace Core\Domain\Model\Post\Handler;

use Core\Domain\Model\Author\AuthorCollectionInterface;
use Core\Domain\Model\Post\Command\CreatePost;
use Core\Domain\Model\Post\Post;
use Core\Domain\Model\Post\PostCollectionInterface;

class CreatePostHandler
{
    /**
     * @var PostCollectionInterface
     */
    private $postCollection;

    /**
     * @var AuthorCollectionInterface
     */
    private $authorCollection;

    public function __construct(AuthorCollectionInterface $authorCollection, PostCollectionInterface $postCollection)
    {
        $this->authorCollection = $authorCollection;
        $this->postCollection = $postCollection;
    }

    /**
     * @throws AuthorNotFound
     */
    public function __invoke(CreatePost $command): void
    {
        $author = $this->authorCollection->get($command->authorId());

        if (!$author) {
            throw new \InvalidArgumentException(\sprintf('Author with id %s cannot be found.', (string) $command->authorId()));
        }

        $post = Post::createWithData(
            $command->postId(),
            $command->authorId(),
            $command->title(),
            $command->description(),
            $command->content()
        );

        $this->postCollection->save($post);
    }
}
