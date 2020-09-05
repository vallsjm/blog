<?php

declare(strict_types=1);

namespace Core\Domain\Model\Author\Event;

use Common\Domain\Event\BaseAggregateChanged;
use Core\Domain\Model\Author\AuthorId;
use Core\Domain\Model\Author\AuthorName;
use Core\Domain\Model\Author\AuthorSurname;

final class AuthorWasRegistered extends BaseAggregateChanged
{
    /**
     * @var AuthorId
     */
    private $authorId;

    /**
     * @var AuthorName
     */
    private $name;

    /**
     * @var AuthorSurname
     */
    private $surname;

    public static function withData(
        AuthorId $authorId,
        AuthorName $name,
        AuthorSurname $surname
    ): AuthorWasRegistered {
        /** @var self $event */
        $event = self::occur((string) $authorId, [
            'name' => (string) $name,
            'surname' => (string) $surname,
        ]);

        $event->authorId = $authorId;
        $event->name = $name;
        $event->surname = $surname;

        return $event;
    }

    public function authorId(): AuthorId
    {
        if (null === $this->authorId) {
            $this->authorId = AuthorId::fromString($this->aggregateId());
        }

        return $this->authorId;
    }

    public function name(): AuthorName
    {
        if (null === $this->name) {
            $this->name = AuthorName::fromString($this->payload['name']);
        }

        return $this->name;
    }

    public function surname(): AuthorSurname
    {
        if (null === $this->surname) {
            $this->surname = AuthorSurname::fromString($this->payload['surname']);
        }

        return $this->surname;
    }
}
