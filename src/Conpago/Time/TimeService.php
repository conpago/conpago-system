<?php
namespace Conpago\Time;

use Conpago\Time\Contract\ITimeService;
use DateTime;

class TimeService implements ITimeService
{
    /**
     * @return DateTime
     */
    public function getCurrentTime(): DateTime
    {
        return new DateTime('now');
    }
}
