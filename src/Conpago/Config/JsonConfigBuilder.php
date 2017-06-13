<?php
namespace Conpago\Config;

use Conpago\Config\Contract\IConfigBuilder;
use Conpago\File\Contract\IFileSystem;

class JsonConfigBuilder implements IConfigBuilder
{
    /** @var IFileSystem */
    private $fileSystem;

    /** @var string */
    private $mask;

    /**
     * @param IFileSystem $fileSystem
     * @param string $mask
     */
    public function __construct(IFileSystem $fileSystem, $mask = '*.config.json')
    {
        $this->fileSystem = $fileSystem;
        $this->mask = $mask;
    }

    /**
     * @return array
     */
    public function build(): array
    {
        $config = [];
        foreach ($this->fileSystem->glob($this->mask) as $filePath) {
            $jsonDecodedArray = json_decode($this->fileSystem->getFileContent($filePath), true);
            $config       = array_merge($config, $jsonDecodedArray);
        }

        return $config;
    }
}
