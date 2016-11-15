<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-09
	 * Time: 00:00
	 */

	namespace Conpago\Config;

	use \Conpago\File\Contract\IFileSystem;

	class JsonConfigBuilderTest extends \PHPUnit_Framework_TestCase
	{
		/**
		 * @var \PHPUnit_Framework_MockObject_MockObject
		 */
		protected $fileSystem;
		/**
		 * @var JsonConfigBuilder
		 */
		protected $config;

		function test_ConstructorWillSearchForFilesWithDefaultMask()
		{
			$this->fileSystem = $this->createMock(IFileSystem::class);

			$this->fileSystem->expects($this->once())
			                 ->method("glob")
			                 ->with("*.config.json")
			                 ->willReturn([]);

			$this->config = new JsonConfigBuilder($this->fileSystem);
			$this->config->build();
		}

		function test_ConstructorWillSearchForFilesWithGivenMask()
		{
			$this->fileSystem = $this->createMock(IFileSystem::class);

			$this->fileSystem->expects($this->once())
			                 ->method("glob")
			                 ->with("8")
			                 ->willReturn([]);

			$this->config = new JsonConfigBuilder($this->fileSystem, "8");
			$this->config->build();
		}

		function test_LoadOneFileWillAddValuesToConfig()
		{
			$this->fileSystem = $this->createMock(IFileSystem::class);

			$this->fileSystem->expects($this->any())
			                 ->method("getFileContent")
			                 ->willReturn('{"a": "b"}');

			$this->fileSystem->expects($this->any())
			                 ->method("glob")
			                 ->willReturn(["x"]);

			$this->config = new JsonConfigBuilder($this->fileSystem);
			$this->assertEquals(["a" => "b"], $this->config->build());
		}

		function test_LoadTwoFilesWillAppendValuesFromSecondFileToConfig()
		{
			$this->fileSystem = $this->createMock(IFileSystem::class);

			$this->fileSystem->expects($this->any())
			                 ->method("getFileContent")
			                 ->withConsecutive(["x"], ["y"])
			                 ->willReturnOnConsecutiveCalls(
				                 '{"a": "b"}',
				                 '{"c": "d"}'
			                 );
			$this->fileSystem->expects($this->any())
			                 ->method("glob")
			                 ->willReturn(["x", "y"]);

			$this->config = new JsonConfigBuilder($this->fileSystem);
			$this->assertEquals(["a" => "b", "c" => "d"], $this->config->build());
		}

		function test_LoadTwoFilesWillOverrideValuesFromSecondFileToConfig()
		{
			$this->fileSystem = $this->createMock(IFileSystem::class);

			$this->fileSystem->expects($this->any())
			                 ->method("getFileContent")
			                 ->withConsecutive(["x"], ["y"])
			                 ->willReturnOnConsecutiveCalls(
					                 '{"c": "d"}',
					                 '{"c": "b"}'
			                 );
			$this->fileSystem->expects($this->any())
			                 ->method("glob")
			                 ->willReturn(["x", "y"]);

			$this->config = new JsonConfigBuilder($this->fileSystem);
			$this->assertEquals(["c" => "b"], $this->config->build());
		}
	}
