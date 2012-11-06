<?php

namespace Empathy\ELib\Events;

class Calendar
{

    public function __construct()
    {
        //
    }

    public function buildByMonth($date)
    {
        $cal = array();
        for ($i = 1; $i < ($date->getLastDay() + 1); $i++) {
            $cal[$i] = 'calendar day';
        }

        return $cal;
    }

    public function newBuildByMonth(
        $start_day, $start_month, $start_year,
        $prev_month_end, $current_month_end,
        $events)

    {
        $month = array();
        $i = 0;
        $leg = 0;

        if ($start_day == 1) {
            $leg++;
        }

        while ($i < 42) {
            $date = "$start_year:$start_month:$start_day 00:00:00";
            $month[$i]['date'] = $date;
            $month[$i]['day'] = $start_day;

            $index = sprintf("%02d", $start_month)
                .sprintf("%02d", $start_day);
            if (isset($events[$index])) {
                $month[$i]['events'] = $events[$index];
            }

            if ($leg == 1) {
                $month[$i]['current_month'] = true;
            }
            $i++;
            $start_day++;

            if(($start_day > $prev_month_end && $leg < 1) ||
               ($start_day > $current_month_end && $leg > 0))
            {
                $start_day = 1;
                $start_month++;
                $leg++;
            }
        }

        return $month;
    }

}
