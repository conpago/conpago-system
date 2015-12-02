<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 10:34
 */

namespace Conpago\File;

use Conpago\File\Contract\IPath;

class Path implements IPath
{
    /**
     * @var
     */
    private $path;
    /**
     * @var
     */
    private $realPath;

    /**
     * Path constructor.
     *
     * @param string $path
     * @param string $realPath
     */
    function __construct($path, $realPath)
    {
        $this->path = $path;
        $this->realPath = $realPath;
    }

    public function get()
    {
        return $this->path;
    }

    public function getReal()
    {
        return $this->realPath;
    }
}