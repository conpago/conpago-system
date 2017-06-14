<?php
namespace Conpago\Config;

use Conpago\Config\Contract\IConfig;
use Conpago\Config\Contract\KeyNotFoundException;

abstract class BaseConfig implements IConfig
{

    /** @var array */
    protected $config = [];

    public function getValue(string $path)
    {
        $pathArray      = explode('.', $path);
        $currentElement = $this->config;

        foreach ($pathArray as $currentName) {
            if (! array_key_exists($currentName, $currentElement)) {
                throw new KeyNotFoundException();
            }

            $currentElement = $currentElement[ $currentName ];
        }

        return $currentElement;
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public function hasValue(string $path): bool
    {
        $pathArray      = explode('.', $path);
        $currentElement = $this->config;

        foreach ($pathArray as $currentName) {
            if (! array_key_exists($currentName, $currentElement)) {
                return false;
            }

            $currentElement = $currentElement[ $currentName ];
        }

        return true;
    }
}
