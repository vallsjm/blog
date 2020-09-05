<?php

declare(strict_types=1);

namespace Core\Domain\Model\Post;

use Assert\Assertion;
use Common\Domain\ValueObject\String\BaseString;

final class PostTitle extends BaseString
{
    public function validate(string $value): void
    {
        try {
            Assertion::minLength($value, 3);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid post title because: '.$e->getMessage());
        }
    }
}
