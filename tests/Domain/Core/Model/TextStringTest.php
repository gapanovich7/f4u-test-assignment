<?php

declare(strict_types=1);

namespace Tests\Domain\Core\Model;

use App\Application\Exception\InvalidCharException;
use App\Domain\Core\Model\TextString;
use PHPUnit\Framework\TestCase;

final class TextStringTest extends TestCase
{
    public function testCanBeCreatedFromValidTextString(): void
    {
        $this->assertInstanceOf(TextString::class, new TextString('AbcАбв'));
    }

    public function testCannotBeCreatedFromInvalidTextString(): void
    {
        $this->expectException(InvalidCharException::class);

        new TextString('AbcАбв1');
    }

    public function testCanBeUsedAsString(): void
    {
        $this->assertEquals('AbcАбв', new TextString('AbcАбв'));
    }

    public function testCanBeCompared(): void
    {
        $this->assertTrue((new TextString('AbcАбв'))->equals(new TextString('AbcАбв')));
    }
}