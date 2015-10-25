<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-09
	 * Time: 00:00
	 */

	namespace Conpago\Config;

	use Conpago\Config\Contract\IConfig;


	class PhpConfig implements IConfig
	{
		/**
		 * @param $path
		 *
		 * @return mixed
		 */
		function getValue($path){

		}

		/**
		 * @param $path
		 *
		 * @return bool
		 */
		function hasValue($path){

		}
	}
