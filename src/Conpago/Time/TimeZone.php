<?php
/**
 * Created by PhpStorm.
 * User: bg
 * Date: 26.04.17
 * Time: 21:48
 */

namespace Conpago\Time;
use Conpago\Time\Contract\ITimeZone;


/**
 *
 * @license MIT
 * @author Bartosz Gołek <bartosz.golek@gmail.com>
 **/
class TimeZone implements ITimeZone
{

    /**
     * Sets the default timezone used by all date/time functions in a script
     *
     * @param string $timezoneIdentifier The timezone identifier, like UTC or
     * Europe/Lisbon. The list of valid identifiers is
     * available in the.
     *
     * @return bool This function returns false if the
     * timezone_identifier isn't valid, or true
     * otherwise.
     */
    public function setDefaultTimeZone($timezoneIdentifier)
    {
        date_default_timezone_set($timezoneIdentifier);
    }
}