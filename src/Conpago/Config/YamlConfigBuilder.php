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
	use Symfony\Component\Yaml\Yaml;


	class YamlConfigBuilder implements IConfigBuilder
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
		function __construct(IFileSystem $fileSystem, $mask = '*.config.yaml') {
			$this->fileSystem = $fileSystem;
			$this->mask = $mask;
		}

		/**
		 * @return array
		 */
		function build() {
			$config = [];
			foreach ($this->fileSystem->glob($this->mask) as $filePath) {
				$config = array_merge($config, Yaml::parse($this->fileSystem->getFileContent($filePath)));
			}

			return $config;
		}
	}
