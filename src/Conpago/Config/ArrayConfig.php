<?php
namespace Conpago\Config;

class ArrayConfig extends BaseConfig
{
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
