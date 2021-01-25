<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Iluxaorlov\Base32;

class Base32Test extends TestCase
{
    /**
     * @return string[][]
     */
    public function dataProvider(): array
    {
        return [
            ['', ''],
            ['f', 'MY======'],
            ['fo', 'MZXQ===='],
            ['foo', 'MZXW6==='],
            ['foob', 'MZXW6YQ='],
            ['fooba', 'MZXW6YTB'],
            ['foobar', 'MZXW6YTBOI======'],
        ];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param string $data
     * @param string $base32
     */
    public function testEncode(string $data, string $base32): void
    {
        self::assertEquals(Base32::encode($data), $base32);
    }

    /**
     * @dataProvider dataProvider
     *
     * @param string $data
     * @param string $base32
     */
    public function testDecode(string $data, string $base32): void
    {
        self::assertEquals($data, Base32::decode($base32));
    }
}
