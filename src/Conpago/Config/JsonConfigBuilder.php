<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-09
	 * Time: 00:00
	 */

	namespace Conpago\Config;

	use Conpago\Config\Contract\IConfigBuilder;
	use Conpago\File\Contract\IFileSystem;


	class JsonConfigBuilder implements IConfigBuilder
	{
		/**
		 * @var IFileSystem
		 */
		private $fileSystem;
		/**
		 * @var string
		 */
		private $mask;

		/**
		 * @param IFileSystem $fileSystem
		 * @param string $mask
		 */
		function __construct(IFileSystem $fileSystem, $mask = '*.config.json') {
			$this->fileSystem = $fileSystem;
			$this->mask = $mask;
		}

		/**
		 * @return array
		 */
		function build() {
			$config = [];
			foreach ($this->fileSystem->glob($this->mask) as $filePath)
			{
				$json_decoded_array = json_decode($this->fileSystem->getFileContent($filePath), true);
				$config       = array_merge($config, $json_decoded_array);
			}

			return $config;
		}
	}
