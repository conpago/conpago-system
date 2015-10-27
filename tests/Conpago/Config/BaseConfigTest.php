<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 27.10.15
	 * Time: 21:26
	 */

	namespace Conpago\Config;


	class BaseConfigTest extends \PHPUnit_Framework_TestCase
	{
		const SIMPLE_VALUE = 1;
		const NESTED_VALUE = 2;
		const SIMPLE_KEY = 'simple';
		const NESTING_KEY = 'nesting';
		const NESTED_KEY = 'nested';

		public function testGetSimpleValue()
		{
			$config = new TestableBaseConfig([self::SIMPLE_KEY => self::SIMPLE_VALUE]);
			$this->assertEquals(self::SIMPLE_VALUE, $config->getValue(self::SIMPLE_KEY));
		}

		public function testGetNestedValue()
		{
			$config = new TestableBaseConfig([
					self::NESTING_KEY => [
							self::NESTED_KEY => self::NESTED_VALUE
					]
			]);
			$result = $config->getValue($this->buildNestedPath(array(self::NESTING_KEY, self::NESTED_KEY)));
			$this->assertEquals(self::NESTED_VALUE, $result);
		}

		/**
		 * @expectedException \Conpago\Config\MissingConfigurationException
		 */
		public function testGetNotExistingSimpleValue()
		{
			$config = new TestableBaseConfig([]);
			$config->getValue('dummy');
		}

		/**
		 * @expectedException \Conpago\Config\MissingConfigurationException
		 */
		public function testGetNotExistingNestedValue()
		{
			$config = new TestableBaseConfig([]);
			$config->getValue( $this->buildNestedPath( array( self::NESTING_KEY, 'dummy' ) ) );
		}

		public function testHasSimpleValue()
		{
			$config = new TestableBaseConfig([self::SIMPLE_KEY => self::SIMPLE_VALUE]);
			$this->assertTrue($config->hasValue(self::SIMPLE_KEY));
		}

		public function testHasNestedValue()
		{
			$config = new TestableBaseConfig([
					self::NESTING_KEY => [
							self::NESTED_KEY => self::NESTED_VALUE
					]
			]);
			$result = $config->hasValue($this->buildNestedPath(array(self::NESTING_KEY, self::NESTED_KEY)));
			$this->assertTrue($result);
		}

		public function testHasNotExistingNestedValue()
		{
			$config = new TestableBaseConfig([]);
			$result = $config->hasValue($this->buildNestedPath(array(self::NESTING_KEY, 'dummy')));
			$this->assertFalse($result);
		}

		public function testHetNotExistingSimpleValue()
		{
			$config = new TestableBaseConfig([]);
			$result = $config->hasValue('dummy');
			$this->assertFalse($result);
		}

		/**
		 * @param array $elements
		 * @return string
		 */
		private function buildNestedPath(array $elements)
		{
			return implode('.', $elements);
		}
	}

	class TestableBaseConfig extends BaseConfig
	{
		function __construct(array $config) {
			$this->config = $config;
		}
	}
