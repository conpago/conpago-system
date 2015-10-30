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


	class JsonConfig extends BaseConfig implements IConfig
	{
		/**
		 * @param IFileSystem $fileSystem
		 * @param string $mask
		 */
		function __construct(IFileSystem $fileSystem, $mask = '*.config.json')
		{
			foreach ($fileSystem->glob($mask) as $filePath)
			{
				$json_decoded_array = json_decode($fileSystem->getFileContent($filePath), true);
				$this->config       = array_merge($this->config, $json_decoded_array);
			}
		}
	}
