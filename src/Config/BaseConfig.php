<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2015-10-26
	 * Time: 08:55
	 */

	namespace Conpago\Config;


	class BaseConfig {

		/**
		 * @var array
		 */
		protected $config = array();

		public function getValue( $path ) {
			$pathArray      = explode( '.', $path );
			$currentElement = $this->config;

			foreach ( $pathArray as $currentName ) {
				if ( ! array_key_exists( $currentName, $currentElement ) ) {
					throw new MissingConfigurationException( $path );
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
		public function hasValue( $path ) {
			$pathArray      = explode( '.', $path );
			$currentElement = $this->config;

			foreach ( $pathArray as $currentName ) {
				if ( ! array_key_exists( $currentName, $currentElement ) ) {
					return false;
				}

				$currentElement = $currentElement[ $currentName ];
			}

			return true;
		}
	}