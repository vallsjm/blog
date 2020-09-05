<?php

declare(strict_types=1);

namespace Core\Domain\Model\Author;

use Assert\Assertion;
use Common\Domain\ValueObject\String\BaseString;

final class AuthorSurname extends BaseString
{
    public function validate(string $value): void
    {
        try {
            Assertion::notEmpty($value);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid author surname because: '.$e->getMessage());
        }
    }
}
