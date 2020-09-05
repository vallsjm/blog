<?php

declare(strict_types=1);

namespace Core\Domain\Model\Post;

use Common\Domain\Aggregate\BaseAggregateRoot;
use Common\Domain\Entity\EntityInterface;
use Core\Domain\Model\Author\AuthorId;
use Core\Domain\Model\Post\Event\PostWasCreated;

final class Post extends BaseAggregateRoot
{
    /**
     * @var PostId
     */
    private $postId;

    /**
     * @var AuthorId
     */
    private $authorId;

    /**
     * @var PostTitle
     */
    private $title;

    /**
     * @var PostDescription
     */
    private $description;

    /**
     * @var PostContent
     */
    private $content;

    public static function createWithData(
        PostId $postId,
        AuthorId $authorId,
        PostTitle $title,
        PostDescription $description,
        PostContent $content
    ): Post {
        $self = new self();

        $self->recordThat(PostWasCreated::withData(
            $postId,
            $authorId,
            $title,
            $description,
            $content
        ));

        return $self;
    }

    public function postId(): PostId
    {
        return $this->postId;
    }

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }

    public function title(): PostTitle
    {
        return $this->title;
    }

    public function description(): PostDescription
    {
        return $this->description;
    }

    public function content(): PostContent
    {
        return $this->content;
    }

    protected function aggregateId(): string
    {
        return (string) $this->postId;
    }

    protected function whenPostWasCreated(PostWasCreated $event): void
    {
        $this->postId = $event->postId();
        $this->authorId = $event->authorId();
        $this->title = $event->title();
        $this->description = $event->description();
        $this->content = $event->content();
    }

    public function equals(EntityInterface $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->postId->equals($other->postId);
    }
}
