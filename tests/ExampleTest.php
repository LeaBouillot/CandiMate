<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testAddition()
    {
        $this->assertEquals(2, 1 + 1);
    }

    public function testStringComparison()
    {
        $this->assertSame('Hello', 'Hello');
    }

    public function testArrayContainsValue()
    {
        $array = ['apple', 'banana', 'cherry'];
        $this->assertContains('banana', $array);
    }

    public function testException()
    {
        $this->expectException(\InvalidArgumentException::class);
        throw new \InvalidArgumentException('This is an exception');
    }
}