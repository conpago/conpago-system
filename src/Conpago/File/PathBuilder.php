<?php
namespace Conpago\File;

use Conpago\File\Contract\IPathBuilder;

class PathBuilder implements IPathBuilder
{
    public function createPath(array $elements): string
    {
        return implode(DIRECTORY_SEPARATOR, $elements);
    }

    public function fileName(string $filePath): string
    {
        return basename(str_replace('\\', '/', $filePath));
    }
}
