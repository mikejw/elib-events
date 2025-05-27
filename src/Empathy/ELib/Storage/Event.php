<?php

namespace Empathy\ELib\Storage;

use Empathy\MVC\Model;
use Empathy\ELib\Events\Status;
use Empathy\MVC\Entity;
use Empathy\MVC\Validate;
use Empathy\ELib\Storage\Event as EEvent;


class Event extends Entity
{
    const TABLE = 'event';

    public $id;
    public $user_id;
    public $start_time;
    public $end_time;
    public $event_name;
    public $short_desc;
    public $long_desc;
    public $tickets_link;
    public $event_link;
    public $status;

    private $start_day;
    private $start_month;
    private $start_year;
    private $start_hour;
    private $start_minute;
    private $end_day;
    private $end_month;
    private $end_year;
    private $end_hour;
    private $end_minute;



    public function setStartDay($day){
        $this->start_day = $day;
    }

    public function getStartDay(){
        return $this->start_day;
    }

    public function setStartMonth($month){
        $this->start_month = $month;
    }

    public function getStartMonth(){
        return $this->start_month;
    }

    public function setStartYear($year){
        $this->start_year = $year;
    }

    public function getStartYear(){
        return $this->start_year;
    }

    public function setStartHour($hour){
        $this->start_hour = $hour;
    }

    public function getStartHour(){
        return $this->start_hour;
    }

    public function setStartMinute($minute){
        $this->start_minute = $minute;
    }

    public function getStartMinute(){
        return $this->start_minute;
    }

    public function setEndDay($day){
        $this->end_day = $day;
    }

    public function getEndDay(){
        return $this->end_day;
    }

    public function setEndMonth($month){
        $this->end_month = $month;
    }

    public function getEndMonth(){
        return $this->end_month;
    }

    public function setEndYear($year){
        $this->end_year = $year;
    }

    public function getEndYear(){
        return $this->end_year;
    }

    public function setEndHour($hour){
        $this->end_hour = $hour;
    }

    public function getEndHour(){
        return $this->end_hour;
    }

    public function setEndMinute($minute){
        $this->end_minute = $minute;
    }

    public function getEndMinute(){
        return $this->end_minute;
    }


    public function validates()
    {
        $this->doValType(Validate::TEXT, 'event_name', $this->event_name, false);
        $this->doValType(Validate::URL, 'tickets_link', $this->tickets_link, true);
        $this->doValType(Validate::URL, 'event_link', $this->event_link, true);
    }

    public function getEvents($full, $start_date, $end_date = null)
    {
        $events = [];
        $params = [];
        if ($full) {
            $select = '*';
        } else {
            $select = 'DAYOFMONTH(start_time) AS dom, event_name, MONTH(start_time) AS month, id';
        }

        $sql = 'SELECT '.$select.' FROM '.Model::getTable(EEvent::class)
            .' WHERE start_time > ?';
        $params[] = $start_date->getMySQLTime();

        if ($end_date !== null) {
            $sql .= ' AND start_time < ?';
            $params[] = $end_date->getMySQLTime();
        }

        $sql .= ' AND status != '.Status::DELETED;
        $sql .= ' ORDER BY start_time';
        $error = 'Could not get events.';
        $result = $this->query($sql, $error, $params);

        if ($full) {
            foreach ($result as $row) {
                array_push($events, $row);
            }
        } else {
            foreach ($result as $row) {
                $index = sprintf("%02d", $row['month']).sprintf("%02d", $row['dom']);
                if (!isset($events[$index])) {
                    $events[$index] = array();
                }
                array_push($events[$index], $row);
                //	$row
            }
        }

        return $events;
    }

}
