<?php

declare(strict_types=1);

namespace Core\Domain\Model\Post\Event;

use Common\Domain\Event\BaseAggregateChanged;
use Core\Domain\Model\Author\AuthorId;
use Core\Domain\Model\Post\PostContent;
use Core\Domain\Model\Post\PostDescription;
use Core\Domain\Model\Post\PostId;
use Core\Domain\Model\Post\PostTitle;

final class PostWasCreated extends BaseAggregateChanged
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

    public static function withData(
        PostId $postId,
        AuthorId $authorId,
        PostTitle $title,
        PostDescription $description,
        PostContent $content
    ): PostWasCreated {
        /** @var self $event */
        $event = self::occur((string) $postId, [
            'author_id' => (string) $authorId,
            'title' => (string) $title,
            'description' => (string) $description,
            'content' => (string) $content,
        ]);

        $event->postId = $postId;
        $event->authorId = $authorId;
        $event->title = $title;
        $event->description = $description;
        $event->content = $content;

        return $event;
    }

    public function postId(): PostId
    {
        if (null === $this->postId) {
            $this->postId = PostId::fromString($this->aggregateId());
        }

        return $this->postId;
    }

    public function authorId(): AuthorId
    {
        if (null === $this->authorId) {
            $this->authorId = AuthorId::fromString($this->payload['author_id']);
        }

        return $this->authorId;
    }

    public function title(): PostTitle
    {
        if (null === $this->title) {
            $this->title = PostTitle::fromString($this->payload['title']);
        }

        return $this->title;
    }

    public function description(): PostDescription
    {
        if (null === $this->description) {
            $this->description = PostDescription::fromString($this->payload['description']);
        }

        return $this->description;
    }

    public function content(): PostContent
    {
        if (null === $this->content) {
            $this->content = PostContent::fromString($this->payload['content']);
        }

        return $this->content;
    }
}
