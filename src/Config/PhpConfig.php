<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Conpago\Config;

	use Conpago\Config\Contract\IConfig;
	use Conpago\File\Contract\IFileSystem;

	class PhpConfig extends BaseConfig implements IConfig
	{
		/**
		 * @param IFileSystem $fileSystem
		 * @param string $configMask
		 */
		function __construct(IFileSystem $fileSystem, $configMask = '*')
		{
			foreach ($fileSystem->glob($configMask) as $filePath)
			{
				$this->config = array_merge($this->config, $fileSystem->includeFile($filePath));
			}
		}
	}
