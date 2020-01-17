<?php

declare(strict_types=1);

namespace Tests\Domain\Core\Model;

use App\Application\Exception\InvalidCharException;
use App\Domain\Core\Model\DigitString;
use PHPUnit\Framework\TestCase;

final class DigitStringTest extends TestCase
{
    public function testCanBeCreatedFromValidDigitString(): void
    {
        $this->assertInstanceOf(DigitString::class, new DigitString('01'));
    }

    public function testCannotBeCreatedFromInvalidDigitString(): void
    {
        $this->expectException(InvalidCharException::class);

        new DigitString('0a');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals('01', new DigitString('01'));
    }

    public function testCanBeCompared(): void
    {
        $this->assertTrue(
            (new DigitString('01'))->equals(new DigitString('01'))
        );
    }
}