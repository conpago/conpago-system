<?php
    /**
     * Created by PhpStorm.
     * User: Bartosz Gołek
     * Date: 2014-06-09
     * Time: 00:00
     */

    namespace Conpago\Config;

    use Conpago\Config\Contract\IConfigBuilder;
    use Conpago\File\Contract\IFileSystem;

class PhpConfigBuilder implements IConfigBuilder
{
    /** @var IFileSystem */
    private $fileSystem;

    /** @var string */
    private $mask;

    /**
     * @param IFileSystem $fileSystem
     * @param string $mask
     */
    public function __construct(IFileSystem $fileSystem, $mask = '*.config.php')
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
            $config = array_merge($config, $this->fileSystem->includeFile($filePath));
        }

        return $config;
    }
}
