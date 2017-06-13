<?php
namespace Conpago\Config;

use Conpago\Conpago\Config\Contract\KeyNotFoundException;
use PHPUnit\Framework\TestCase;

class ArrayConfigTest extends TestCase
{
    const SIMPLE_VALUE = 1;
    const NESTED_VALUE = 2;
    const SIMPLE_KEY = 'simple';
    const NESTING_KEY = 'nesting';
    const NESTED_KEY = 'nested';

    public function testGetSimpleValue()
    {
        $config = new ArrayConfig([self::SIMPLE_KEY => self::SIMPLE_VALUE]);
        $this->assertEquals(self::SIMPLE_VALUE, $config->getValue(self::SIMPLE_KEY));
    }

    public function testGetNestedValue()
    {
        $config = new ArrayConfig([
                self::NESTING_KEY => [
                        self::NESTED_KEY => self::NESTED_VALUE
                ]
        ]);
        $result = $config->getValue($this->buildNestedPath(array(self::NESTING_KEY, self::NESTED_KEY)));
        $this->assertEquals(self::NESTED_VALUE, $result);
    }

    public function testGetNotExistingSimpleValue()
    {
        $this->expectedException(KeyNotFoundException::class);

        $config = new ArrayConfig([]);
        $config->getValue('dummy');
    }

    public function testGetNotExistingNestedValue()
    {
        $this->expectedException(KeyNotFoundException::class);

        $config = new ArrayConfig([]);
        $config->getValue($this->buildNestedPath([self::NESTING_KEY, 'dummy']));
    }

    public function testHasSimpleValue()
    {
        $config = new ArrayConfig([self::SIMPLE_KEY => self::SIMPLE_VALUE]);
        $this->assertTrue($config->hasValue(self::SIMPLE_KEY));
    }

    public function testHasNestedValue()
    {
        $config = new ArrayConfig([
                self::NESTING_KEY => [
                        self::NESTED_KEY => self::NESTED_VALUE
                ]
        ]);
        $result = $config->hasValue($this->buildNestedPath(array(self::NESTING_KEY, self::NESTED_KEY)));
        $this->assertTrue($result);
    }

    public function testHasNotExistingNestedValue()
    {
        $config = new ArrayConfig([]);
        $result = $config->hasValue($this->buildNestedPath(array(self::NESTING_KEY, 'dummy')));
        $this->assertFalse($result);
    }

    public function testHetNotExistingSimpleValue()
    {
        $config = new ArrayConfig([]);
        $result = $config->hasValue('dummy');
        $this->assertFalse($result);
    }

    /**
     * @param array $elements
     *
     * @return string
     */
    private function buildNestedPath(array $elements)
    {
        return implode('.', $elements);
    }
}
