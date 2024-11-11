<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function getFridaysInMonth($date)
    {
        $carbonDate = ($date instanceof Carbon) ? $date : Carbon::parse($date);
        $startDate = $carbonDate->copy()->startOfMonth();
        $daysInMonth = $startDate->daysInMonth;
        $fridays = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dateInMonth = $startDate->copy()->day($day);

            if ($dateInMonth->dayOfWeek === Carbon::FRIDAY) {
                $fridays[] = $dateInMonth->toDateString();  // Or format as needed
            }
        }
        return $fridays;
    }
}
