<?php

declare(strict_types=1);

namespace App\Domain\Core\Model;

use App\Application\Exception\InvalidCharException;

final class DigitString implements ValueObjectInterface
{
    private $digit;

    /**
     * @param string $digit
     *
     * @throws InvalidCharException
     */
    public function __construct(string $digit)
    {
        if (!ctype_digit($digit) || empty($digit)) {
            throw new InvalidCharException(sprintf('String^ %s contains invalid char', $digit));
        }

        $this->digit = $digit;
    }

    public function __toString(): string
    {
        return $this->digit;
    }

    public function equals(DigitString $digit): bool
    {
        return $this->digit === (string) $digit;
    }
}
