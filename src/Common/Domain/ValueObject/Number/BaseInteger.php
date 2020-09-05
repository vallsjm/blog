<?php

declare(strict_types=1);

namespace Common\Domain\ValueObject\Number;

use Common\Domain\ValueObject\ValueObjectInterface;

abstract class BaseInteger implements ValueObjectInterface
{
    private $value;

    private final function __construct(int $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public static function fromInt(int $value): self
    {
        return new static($value);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function equals(ValueObjectInterface $object): bool
    {
        return \get_class($this) === \get_class($object) && $this->value === $object->value;
    }

    abstract public function validate(int $value): void;
}
