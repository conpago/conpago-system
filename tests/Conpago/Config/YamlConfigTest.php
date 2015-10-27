<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-09
	 * Time: 00:00
	 */

	namespace Conpago\Config;

	class YamlConfigTest extends \PHPUnit_Framework_TestCase
	{
		/**
		 * @var \PHPUnit_Framework_MockObject_MockObject
		 */
		protected $fileSystem;
		/**
		 * @var YamlConfig
		 */
		protected $config;

		function test_ConstructorWillSearchForFilesWithDefaultMask()
		{
			$this->fileSystem = $this->getMock("Conpago\File\Contract\IFileSystem");

			$this->fileSystem->expects($this->once())
			                 ->method("glob")
			                 ->with("*.config.yaml")
			                 ->willReturn([]);

			$this->config = new YamlConfig($this->fileSystem);
		}

		function test_ConstructorWillSearchForFilesWithGivenMask()
		{
			$this->fileSystem = $this->getMock("Conpago\File\Contract\IFileSystem");

			$this->fileSystem->expects($this->once())
			                 ->method("glob")
			                 ->with("8")
			                 ->willReturn([]);

			$this->config = new YamlConfig($this->fileSystem, "8");
		}

		function test_LoadOneFileWillAddValuesToConfig()
		{
			$this->fileSystem = $this->getMock("Conpago\File\Contract\IFileSystem");

			$this->fileSystem->expects($this->any())
			                 ->method("getFileContent")
			                 ->willReturn('a: "b"');

			$this->fileSystem->expects($this->any())
			                 ->method("glob")
			                 ->willReturn(["x"]);

			$this->config = new YamlConfig($this->fileSystem);
			$this->assertEquals("b", $this->config->getValue("a"));
		}

		function test_LoadTwoFilesWillAppendValuesFromSecondFileToConfig()
		{
			$this->fileSystem = $this->getMock("Conpago\File\Contract\IFileSystem");

			$this->fileSystem->expects($this->any())
			                 ->method("getFileContent")
			                 ->withConsecutive(["x"], ["y"])
			                 ->willReturnOnConsecutiveCalls(
					                 'c: "d"',
					                 'a: "b"'
			                 );
			$this->fileSystem->expects($this->any())
			                 ->method("glob")
			                 ->willReturn(["x", "y"]);

			$this->config = new YamlConfig($this->fileSystem);
			$this->assertEquals("b", $this->config->getValue("a"));
			$this->assertEquals("d", $this->config->getValue("c"));
		}

		function test_LoadTwoFilesWillOverrideValuesFromSecondFileToConfig()
		{
			$this->fileSystem = $this->getMock("Conpago\File\Contract\IFileSystem");

			$this->fileSystem->expects($this->any())
			                 ->method("getFileContent")
			                 ->withConsecutive(["x"], ["y"])
			                 ->willReturnOnConsecutiveCalls(
					                 'c: "d"',
					                 'c: "b"'
			                 );
			$this->fileSystem->expects($this->any())
			                 ->method("glob")
			                 ->willReturn(["x", "y"]);

			$this->config = new YamlConfig($this->fileSystem);
			$this->assertEquals("b", $this->config->getValue("c"));
		}
	}
