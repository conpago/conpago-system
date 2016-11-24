<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-10
	 * Time: 20:19
	 */

	namespace Conpago;

	use Conpago\Time\Contract\ITimeService;
    use DateTime;

	class TimeService implements ITimeService
	{
		/**
		 * @return DateTime
		 */
		function getCurrentTime()
		{
			return new DateTime('now');
		}
	}
