<?php

declare(strict_types=1);

namespace Core\Domain\Model\Post\Command;

use Assert\Assertion;
use Common\Domain\Command\BaseCommand;
use Core\Domain\Model\Author\AuthorId;
use Core\Domain\Model\Post\PostContent;
use Core\Domain\Model\Post\PostDescription;
use Core\Domain\Model\Post\PostId;
use Core\Domain\Model\Post\PostTitle;

final class CreatePost extends BaseCommand
{
    public static function withData(
        string $postId,
        string $authorId,
        string $title,
        string $description,
        string $content
    ): self {
        return new self([
            'post_id' => $postId,
            'author_id' => $authorId,
            'title' => $title,
            'description' => $description,
            'content' => $content,
        ]);
    }

    public function postId(): PostId
    {
        return PostId::fromString($this->payload['post_id']);
    }

    public function authorId(): AuthorId
    {
        return AuthorId::fromString($this->payload['author_id']);
    }

    public function title(): PostTitle
    {
        return PostTitle::fromString($this->payload['title']);
    }

    public function description(): PostDescription
    {
        return PostDescription::fromString($this->payload['description']);
    }

    public function content(): PostContent
    {
        return PostContent::fromString($this->payload['content']);
    }

    public function validate(array $payload): void
    {
        Assertion::keyExists($payload, 'post_id');
        Assertion::uuid($payload['post_id']);
        Assertion::keyExists($payload, 'author_id');
        Assertion::uuid($payload['author_id']);
        Assertion::keyExists($payload, 'title');
        Assertion::string($payload['title']);
        Assertion::keyExists($payload, 'description');
        Assertion::string($payload['description']);
        Assertion::keyExists($payload, 'content');
        Assertion::string($payload['content']);
    }
}
