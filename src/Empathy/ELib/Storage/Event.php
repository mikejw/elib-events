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
