<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-09
	 * Time: 00:00
	 */

	namespace Conpago\Config;

	use Conpago\Config\Contract\IConfig;
	use Conpago\File\Contract\IFileSystem;
	use Symfony\Component\Yaml\Yaml;


	class YamlConfig extends BaseConfig implements IConfig
	{
		/**
		 * @param IFileSystem $fileSystem
		 * @param string $mask
		 *
		 * @internal param IAppMask $appMask
		 */
		function __construct(IFileSystem $fileSystem, $mask = '*.config.yaml')
		{
			foreach ($fileSystem->glob($mask) as $filePath)
			{
				$this->config = array_merge($this->config, Yaml::parse($fileSystem->getFileContent($filePath)));
			}
		}
	}
