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


	class PhpConfig extends BaseConfig implements IConfig
	{
		/**
		 * @param IFileSystem $fileSystem
		 * @param string $mask
		 */
		function __construct(IFileSystem $fileSystem, $mask = '*.config.php')
		{
			foreach ($fileSystem->glob($mask) as $filePath)
			{
				$this->config = array_merge($this->config, $fileSystem->includeFile($filePath));
			}
		}


	}
