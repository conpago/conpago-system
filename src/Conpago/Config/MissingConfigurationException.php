<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 27.10.15
	 * Time: 21:04
	 */

	namespace Conpago\Config;


	use \Exception;

	class MissingConfigurationException extends Exception {
		/**
		 * @var string
		 */
		protected $path;

		public function getPath(){
			return $this->path;
		}

		function __construct($path, $message = "", $code = 0, Exception $previous = null ) {
			parent::__construct( $message, $code, $previous );
			$this->path = $path;
		}
	}