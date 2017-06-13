<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2014-10-10
 * Time: 07:57
 */

namespace Conpago\File;

use Conpago\File\Contract\IFileSystem;

class FileSystem implements IFileSystem
{

    public function includeFile(string $filePath)
    {
        return include $filePath;
    }

    public function glob(string $pattern)
    {
        return glob($pattern, null);
    }

    public function realPath(string $path): string
    {
        return realpath($path);
    }

    public function getFileContent(string $filename): string
    {
        return file_get_contents($filename);
    }

    public function setFileContent(string $filename, string $content): int
    {
        $result = file_put_contents($filename, $content);
        if ($result === false) {
            throw new \Exception("Content was not written");
        }

        return $result;
    }

    public function requireOnce(string $filePath)
    {
        require_once $filePath;
    }

    public function requireFile(string $filePath)
    {
        require $filePath;
    }

    private function getClassName($filePath)
    {
        $className = basename($filePath, '.php');
        $namespace = $this->getNameSpace($filePath);

        $classFullName = strlen($namespace) > 0
            ? '\\' . $namespace . '\\' . $className
            : '\\' . $className;

        return $classFullName;
    }

    private function getNameSpace($filePath)
    {
        $matches = [];
        if (preg_match('/namespace (.+) *[\{;]{1}/', file_get_contents($filePath), $matches)) {
            return $matches[1];
        }

        return '';
    }

    public function loadClass(string $filePath)
    {
        $className = $this->getClassName($filePath);
        $this->requireOnce($filePath);

        return new $className();
    }

    public function createDirectory(string $pathname, bool $recursive)
    {
        return mkdir($pathname, 0777, $recursive);
    }

    public function fileExists(string $filename): bool
    {
        return file_exists($filename);
    }
}
