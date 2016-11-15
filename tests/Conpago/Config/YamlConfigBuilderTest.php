<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-09
	 * Time: 00:00
	 */

	namespace Conpago\Config;

	use Conpago\File\Contract\IFileSystem;

    class YamlConfigBuilderTest extends \PHPUnit_Framework_TestCase
	{
		/**
		 * @var \PHPUnit_Framework_MockObject_MockObject
		 */
		protected $fileSystem;
		/**
		 * @var YamlConfigBuilder
		 */
		protected $config;

		function test_ConstructorWillSearchForFilesWithDefaultMask()
		{
			$this->fileSystem = $this->getFileSystemMock();

			$this->fileSystem->expects($this->once())
			                 ->method("glob")
			                 ->with("*.config.yaml")
			                 ->willReturn([]);

			$this->config = new YamlConfigBuilder($this->fileSystem);
			$this->config->build();
		}

		function test_ConstructorWillSearchForFilesWithGivenMask()
		{
			$this->fileSystem = $this->getFileSystemMock();

			$this->fileSystem->expects($this->once())
			                 ->method("glob")
			                 ->with("8")
			                 ->willReturn([]);

			$this->config = new YamlConfigBuilder($this->fileSystem, "8");
			$this->config->build();
		}

		function test_LoadOneFileWillAddValuesToConfig()
		{
			$this->fileSystem = $this->getFileSystemMock();

			$this->fileSystem->expects($this->any())
			                 ->method("getFileContent")
			                 ->willReturn('a: "b"');

			$this->fileSystem->expects($this->any())
			                 ->method("glob")
			                 ->willReturn(["x"]);

			$this->config = new YamlConfigBuilder($this->fileSystem);
			$this->assertEquals(["a" => "b"], $this->config->build());
		}

		function test_LoadTwoFilesWillAppendValuesFromSecondFileToConfig()
		{
			$this->fileSystem = $this->getFileSystemMock();

			$this->fileSystem->expects($this->any())
			                 ->method("getFileContent")
			                 ->withConsecutive(["x"], ["y"])
			                 ->willReturnOnConsecutiveCalls(
					                 'a: "b"',
					                 'c: "d"'
			                 );
			$this->fileSystem->expects($this->any())
			                 ->method("glob")
			                 ->willReturn(["x", "y"]);

			$this->config = new YamlConfigBuilder($this->fileSystem);
			$this->assertEquals(["a" => "b", "c" => "d"], $this->config->build());
		}

		function test_LoadTwoFilesWillOverrideValuesFromSecondFileToConfig()
		{
			$this->fileSystem = $this->getFileSystemMock();

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

			$this->config = new YamlConfigBuilder($this->fileSystem);
			$this->assertEquals(["c" => "b"], $this->config->build());
		}

        /**
         * @return \PHPUnit_Framework_MockObject_MockObject
         */
        public function getFileSystemMock()
        {
            return $this->createMock(IFileSystem::class);
        }
    }
