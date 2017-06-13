<?php
namespace Conpago\File;

use Conpago\File\Contract\IPath;

class Path implements IPath
{
    /** @var string */
    private $path;

    /** @var string */
    private $realPath;

    /**
     * Path constructor.
     *
     * @param string $path
     * @param string $realPath
     */
    public function __construct(string $path, string $realPath)
    {
        $this->path = $path;
        $this->realPath = $realPath;
    }

    public function get(): string
    {
        return $this->path;
    }

    public function getReal(): string
    {
        return $this->realPath;
    }
}
