<?php
namespace Conpago\Time;

use Conpago\Time\Contract\ITimeZone;

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
    public function setDefaultTimeZone(string $timezoneIdentifier): bool
    {
        return date_default_timezone_set($timezoneIdentifier);
    }
}
