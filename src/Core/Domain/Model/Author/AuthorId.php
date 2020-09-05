<?php

declare(strict_types=1);

namespace Core\Domain\Model\Author;

use Assert\Assertion;
use Common\Domain\ValueObject\Identity\BaseUuid;

final class AuthorId extends BaseUuid
{
    public function validate(string $uuid): void
    {
        try {
            Assertion::uuid($uuid);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Invalid AuthorId because: '.$e->getMessage());
        }
    }
}
