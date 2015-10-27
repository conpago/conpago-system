<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-10
	 * Time: 20:19
	 */

	namespace Conpago\Contract;

	use DateTime;

	class TimeService
	{
		/**
		 * @return DateTime
		 */
		function getCurrentTime()
		{
			return new DateTime('now');
		}
	}
