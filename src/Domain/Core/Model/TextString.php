<?php

declare(strict_types=1);

namespace App\Domain\Core\Model;

use App\Application\Exception\InvalidCharException;

final class TextString implements ValueObjectInterface
{
    private $text;

    /**
     * @param string $text
     *
     * @throws InvalidCharException
     */
    public function __construct(string $text)
    {
        if (\preg_match('/[^A-Za-zА-Яа-яЁё]/u', $text) || empty($text)) {
            throw new InvalidCharException(sprintf('String^ %s contains invalid char', $text));
        }

        $this->text = $text;
    }

    public function __toString(): string
    {
        return $this->text;
    }

    public function equals(TextString $text): bool
    {
        return $this->text === (string) $text;
    }
}
