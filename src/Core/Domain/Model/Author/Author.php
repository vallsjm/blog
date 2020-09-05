<?php

declare(strict_types=1);

namespace Core\Domain\Model\Author;

use Common\Domain\Aggregate\BaseAggregateRoot;
use Common\Domain\Entity\EntityInterface;
use Core\Domain\Model\Author\Event\AuthorWasRegistered;

final class Author extends BaseAggregateRoot
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

    public static function registerWithData(
        AuthorId $authorId,
        AuthorName $name,
        AuthorSurname $surname
    ): Author {
        $self = new self();

        $self->recordThat(AuthorWasRegistered::withData(
            $authorId,
            $name,
            $surname
        ));

        return $self;
    }

    public function authorId(): AuthorId
    {
        return $this->authorId;
    }

    public function name(): AuthorName
    {
        return $this->name;
    }

    public function surname(): AuthorSurname
    {
        return $this->surname;
    }

    protected function aggregateId(): string
    {
        return (string) $this->authorId;
    }

    protected function whenAuthorWasRegistered(AuthorWasRegistered $event): void
    {
        $this->authorId = $event->authorId();
        $this->name = $event->name();
        $this->surname = $event->surname();
    }

    public function equals(EntityInterface $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->authorId->equals($other->authorId);
    }
}
