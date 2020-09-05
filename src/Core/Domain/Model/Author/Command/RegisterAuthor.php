<?php

declare(strict_types=1);

namespace Core\Domain\Model\Author\Command;

use Assert\Assertion;
use Common\Domain\Command\BaseCommand;
use Core\Domain\Model\Author\AuthorId;
use Core\Domain\Model\Author\AuthorName;
use Core\Domain\Model\Author\AuthorSurname;

final class RegisterAuthor extends BaseCommand
{
    public static function withData(string $authorId, string $name, string $surname): self
    {
        return new self([
            'author_id' => $authorId,
            'name' => $name,
            'surname' => $surname,
        ]);
    }

    public function authorId(): AuthorId
    {
        return AuthorId::fromString($this->payload['author_id']);
    }

    public function name(): AuthorName
    {
        return AuthorName::fromString($this->payload['name']);
    }

    public function surname(): AuthorSurname
    {
        return AuthorSurname::fromString($this->payload['surname']);
    }

    public function validate(array $payload): void
    {
        Assertion::keyExists($payload, 'author_id');
        Assertion::uuid($payload['author_id']);
        Assertion::keyExists($payload, 'name');
        Assertion::string($payload['name']);
        Assertion::keyExists($payload, 'surname');
        Assertion::string($payload['surname']);
    }
}
