<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 27.10.15
	 * Time: 21:03
	 */

	namespace Conpago\Config;


	class ArrayConfig {

		/**
		 * @var array
		 */
		protected $config;

		function __construct(array $config) {
			$this->config = $config;
		}

		function getValue($path) {
			$pathArray      = explode('.', $path);
			$currentElement = $this->config;

			foreach ($pathArray as $currentName) {
				if ( ! array_key_exists($currentName, $currentElement)) {
					throw new MissingConfigurationException($path);
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
		function hasValue($path) {
			$pathArray      = explode('.', $path);
			$currentElement = $this->config;

			foreach ($pathArray as $currentName) {
				if ( ! array_key_exists($currentName, $currentElement)) {
					return false;
				}

				$currentElement = $currentElement[ $currentName ];
			}

			return true;
		}
	}