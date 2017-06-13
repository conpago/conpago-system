<?php
namespace Conpago\Config;

use Conpago\File\Contract\IFileSystem;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class YamlConfigBuilderTest extends \PHPUnit_Framework_TestCase
{
    /** @var  MockObject | IFileSystem*/
    protected $fileSystemMock;

    /** @var YamlConfigBuilder */
    protected $config;

    public function testConstructorWillSearchForFilesWithDefaultMask()
    {
        $this->fileSystemMock = $this->getFileSystemMock();

        $this->fileSystemMock->expects($this->once())
                         ->method("glob")
                         ->with("*.config.yaml")
                         ->willReturn([]);

        $this->config = new YamlConfigBuilder($this->fileSystemMock);
        $this->config->build();
    }

    public function testConstructorWillSearchForFilesWithGivenMask()
    {
        $this->fileSystemMock = $this->getFileSystemMock();

        $this->fileSystemMock
            ->expects($this->once())
            ->method("glob")
            ->with("8")
            ->willReturn([]);

        $this->config = new YamlConfigBuilder($this->fileSystemMock, "8");
        $this->config->build();
    }

    public function testLoadOneFileWillAddValuesToConfig()
    {
        $this->fileSystemMock = $this->getFileSystemMock();

        $this->fileSystemMock
            ->method("getFileContent")
            ->willReturn('a: "b"');

        $this->fileSystemMock
            ->method("glob")
            ->willReturn(["x"]);

        $this->config = new YamlConfigBuilder($this->fileSystemMock);
        $this->assertEquals(["a" => "b"], $this->config->build());
    }

    public function testLoadTwoFilesWillAppendValuesFromSecondFileToConfig()
    {
        $this->fileSystemMock = $this->getFileSystemMock();

        $this->fileSystemMock
            ->method("getFileContent")
            ->withConsecutive(["x"], ["y"])
            ->willReturnOnConsecutiveCalls(
                'a: "b"',
                'c: "d"'
            );
        $this->fileSystemMock
            ->method("glob")
            ->willReturn(["x", "y"]);

        $this->config = new YamlConfigBuilder($this->fileSystemMock);
        $this->assertEquals(["a" => "b", "c" => "d"], $this->config->build());
    }

    public function testLoadTwoFilesWillOverrideValuesFromSecondFileToConfig()
    {
        $this->fileSystemMock = $this->getFileSystemMock();

        $this->fileSystemMock
            ->method("getFileContent")
            ->withConsecutive(["x"], ["y"])
            ->willReturnOnConsecutiveCalls(
                'c: "d"',
                'c: "b"'
            );
        $this->fileSystemMock
            ->method("glob")
            ->willReturn(["x", "y"]);

        $this->config = new YamlConfigBuilder($this->fileSystemMock);
        $this->assertEquals(["c" => "b"], $this->config->build());
    }

    /**
     * @return IFileSystem | MockObject
     */
    private function getFileSystemMock()
    {
        return $this->createMock(IFileSystem::class);
    }
}
