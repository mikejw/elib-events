<?php

namespace Empathy\ELib\Events;


use Empathy\MVC\Model;
use Empathy\ELib\DateTime;
use Empathy\MVC\Session;
use Empathy\ELib\Storage\Event;
use Empathy\MVC\DI;

trait ControllerTrait 
{

    private function trimUrl($url) {
        $trimmed = preg_replace('/^https?:\/\//', '', $url);
        return [
            $trimmed,
            $url !== '' ? 'https://' . $trimmed : ''
        ];
    }

    public function filterInt($name)
    {
        if (isset($_GET[$name])) {
            return (int) $_GET[$name];
        } else {
            return 0;
        }
    }

    public function default_event()
    {
        $this->monthView();
    }

    public function view_event()
    {
        $id = $this->filterInt('id');
        $e = Model::load(Event::class);
        $e->load($id);
        $this->assign('event', $e);
        $this->setTemplate('elib:admin/view_event.tpl');
    }

    public function edit_event()
    {
        $this->setTemplate('elib:admin/edit_event.tpl');

        $id = $this->filterInt('id');

        if (isset($_POST['submit'])) {
            $time = array('day' => $_POST['start_day'],
                'month' => $_POST['start_month'] + 1,
                'year' => $_POST['start_year'],
                'hour' => $_POST['start_hour'],
                'minute' => $_POST['start_minute'],
                'second' => 0);
            $start = new DateTime($time);

            $time = array('day' => $_POST['end_day'],
                'month' => $_POST['end_month'] + 1,
                'year' => $_POST['end_year'],
                'hour' => $_POST['end_hour'],
                'minute' => $_POST['end_minute'],
                'second' => 0);
            $end = new DateTime($time);

            $e = Model::load(Event::class);
            $e->load($id);

            if (!$start->getValid()) {
                $e->addValError('invalid start date', 'start_time');
            }
            if (!$end->getValid()) {
                $e->addValError('invalid end date', 'end_time');
            }

            $e->user_id = DI::getContainer()->get('CurrentUser')->getUserID();
            $e->start_time = $start->getMySQLTime();
            $e->end_time = $end->getMySQLTime();

            if ($end->getTime() <= $start->getTime()) {
                $e->addValError('invalid end date/time', 'end_time');
            }

            $e->event_name = $_POST['event_name'];
            $e->short_desc = $_POST['short_desc'];
            $e->long_desc = $_POST['long_desc'];

            $tickets_link = $this->trimUrl($_POST['tickets_link']);
            $e->tickets_link = $tickets_link[1];

            $event_link = $this->trimUrl($_POST['event_link']);
            $e->event_link = $event_link[1];
            
            $e->status = 'DEFAULT';

            $e->validates();
            if ($e->hasValErrors()) {
                $e->tickets_link = $tickets_link[0];
                $e->event_link = $event_link[0];
                $start = $start->getTime();
                $end = $end->getTime();

                $e->setStartDay(date('d', $start));
                $e->setStartMonth(date('m', $start) - 1);
                $e->setStartYear(date('Y', $start));
                $e->setStartHour(date('H', $start));
                $e->setStartMinute(date('i', $start));

                $e->setEndDay(date('d', $end));
                $e->setEndMonth(date('m', $end) - 1);
                $e->setEndYear(date('Y', $end));
                $e->setEndHour(date('H', $end));
                $e->setEndMinute(date('i', $end));

                $this->assign('event', $e);
                $this->assignEventDefs();
                $this->assign('errors', $e->getValErrors());
            } else {
                $e->save();
                $this->redirect('admin/events');
            }
        } elseif (isset($_POST['cancel'])) {
            $this->redirect('admin/events/view_event/'.$id);
        } else {
            $e = Model::load(Event::class);
            $e->load($id);

            $start_time = strtotime($e->start_time);

            $end_time = strtotime($e->end_time);

            $e->setStartDay(date('d', $start_time));
            $e->setStartMonth(date('m', $start_time) - 1);
            $e->setStartYear(date('Y', $start_time));
            $e->setStartHour(date('H', $start_time));
            $e->setStartMinute(date('i', $start_time));

            $e->setEndDay(date('d', $end_time));
            $e->setEndMonth(date('m', $end_time) - 1);
            $e->setEndYear(date('Y', $end_time));
            $e->setEndHour(date('H', $end_time));
            $e->setEndMinute(date('i', $end_time));

            $this->assign('event', $e);
            $this->assignEventDefs();
        }
    }

    public function add_event()
    {
        if (isset($_POST['submit'])) {

            $time = array('day' => $_POST['start_day'],
                'month' => $_POST['start_month'] + 1,
                'year' => $_POST['start_year'],
                'hour' => $_POST['start_hour'],
                'minute' => $_POST['start_minute'],
                'second' => 0);
            $start = new DateTime($time);

            $time = array('day' => $_POST['end_day'],
                'month' => $_POST['end_month'] + 1,
                'year' => $_POST['end_year'],
                'hour' => $_POST['end_hour'],
                'minute' => $_POST['end_minute'],
                'second' => 0);
            $end = new DateTime($time);

            $e = Model::load(Event::class);

            if (!$start->getValid()) {
                $e->addValError('invalid start date', 'start_time');
            }
            if (!$end->getValid()) {
                $e->addValError('invalid end date', 'end_time');
            }

            $e->user_id = DI::getContainer()->get('CurrentUser')->getUserID();
            $e->start_time = $start->getMySQLTime();
            $e->end_time = $end->getMySQLTime();

            if ($end->getTime() <= $start->getTime()) {
                $e->addValError('invalid end date/time', 'end_time');
            }

            $e->event_name = $_POST['event_name'];
            $e->short_desc = $_POST['short_desc'];
            $e->long_desc = $_POST['long_desc'];

            $tickets_link = $this->trimUrl($_POST['tickets_link']);
            $e->tickets_link = $tickets_link[1];

            $event_link = $this->trimUrl($_POST['event_link']);
            $e->event_link = $event_link[1];

            $e->status = 'DEFAULT';

            $e->validates();
            if ($e->hasValErrors()) {

                $e->tickets_link = $tickets_link[0];
                $e->event_link = $event_link[0];
                $e->setStartDay($_POST['start_day']);
                $e->setStartMonth($_POST['start_month']);
                $e->setStartYear($_POST['start_year']);
                $e->setStartHour($_POST['start_hour']);
                $e->setStartMinute($_POST['start_minute']);
                $e->setEndDay($_POST['end_day']);
                $e->setEndMonth($_POST['end_month']);
                $e->setEndYear($_POST['end_year']);
                $e->setEndHour($_POST['end_hour']);
                $e->setEndMinute($_POST['end_minute']);

                $this->assign('event', $e);
                $this->assign('errors', $e->getValErrors());
            } else {
                $e->insert();
                $this->redirect('admin/events');
            }
        } elseif (isset($_POST['cancel'])) {
            $this->redirect('admin/events');
        } else {
            $e = Model::load(Event::class); // default (mostly empty) event

            $date = $this->filterInt('date');
            if (strlen($date) != 8) {
                $date = 0;
            }
            if ($date != 0) {
                $y = substr($date, 0, 4);
                $m = substr($date, 4, 2);
                $d = substr($date, 6, 2);
                $time = mktime(0, 0, 0, $m,
                    $d, $y);

                $e->setStartDay($d);
                $e->setStartMonth($m - 1);
                $e->setStartYear($y);
                $e->setStartHour(20);
                $e->setStartMinute(0);

                $e->setEndDay($d);
                $e->setEndMonth($m - 1);
                $e->setEndYear($y);
                $e->setEndHour(21);
                $e->setEndMinute(0);
                $this->assign('event', $e);
            }

        }

        $this->assignEventDefs();
        $this->setTemplate('elib:admin/add_event.tpl');
    }

    protected function assignEventDefs()
    {
        $select_days = array();
        $i = 1;
        while ($i < 32) {
            $select_days[$i] = $i;
            $i++;
        }
        $select_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

        $select_years = array();
        $date = new DateTime();
        $year = $date->getYear();
        $i =  $year - 5;
        while ($i < $year + 5) {
            $select_years[$i] = $i;
            $i++;
        }

        $select_hours = array();
        $i = 0;
        while ($i < 24) {
            $select_hours[sprintf('%02d', $i)] = sprintf('%02d', $i);
            $i++;
        }

        $select_minutes = array();
        $i = 0;
        while ($i < 60) {
            $select_minutes[sprintf('%02d', $i)] = sprintf('%02d', $i);
            $i += 5;
        }

        $this->assign('select_days', $select_days);
        $this->assign('select_months', $select_months);
        $this->assign('select_years', $select_years);
        $this->assign('select_hours', $select_hours);
        $this->assign('select_minutes', $select_minutes);
    }

    public function monthView()
    {
        if (isset($_GET['today'])) {
            Session::clear('ui_events');
        }
        $this->loadUIVars('ui_events', array('month'));

        $month = $this->filterInt('month');
        if (strlen($month) != 6) {
            $month = 0;
        }

        if ($month == 0) {
            $time = time();
        } else {
            $y = substr($month, 0, 4);
            $m = substr($month, 4, 2);
            $time = mktime(0, 0, 0, $m,
                1, $y);
        }

        $date = new DateTime(array($time));

        $c = new Calendar();

        $date->resetToFirst();
        $days = $date->getLastDay();

        $start_days = $date->getDayOfWeek() - 1; // days needed to pad beginning

        $date_prev_month = clone $date;
        $date_prev_month->adjustMonth(-1);
        $date_prev_month->resetToLast();
        $date_prev_month->adjustDay(($start_days - 1) * -1);

        $date_next_month = clone $date;
        $date_next_month->adjustMonth(1);

        $e = Model::load(Event::class);
        $events = $e->getEvents(false, $date_prev_month, $date_next_month);

        $month = $c->newBuildByMonth($date_prev_month->getDay(),
            $date_prev_month->getMonth(),
            $date_prev_month->getYear(),
            $date_prev_month->getLastDay(),
            $date->getLastDay(),
            $events);

        $this->assign('month', $date->getMonthText());
        $this->assign('year', $date->getYear());
        $this->assign('current_month', vsprintf("%02d", array($date->getMonth())));
        $this->assign('cal_month', $month);

        if ($date->getMonth() == 12) {
            $next_month_link = $date->getYear().'01';
        } else {
            $next_month_link = $date->getYear().vsprintf("%02d", array($date->getMonth()+1));
        }

        if ($date->getMonth() == 1) {
            $prev_month_link = $date->getYear().'12';
        } else {
            $prev_month_link = $date->getYear().vsprintf("%02d", array($date->getMonth()-1));
        }

        $this->assign('prev_month_link', $prev_month_link);
        $this->assign('next_month_link', $next_month_link);

        $prev_year_link = ($date->getYear() - 1).vsprintf("%02d", array($date->getMonth()));
        $next_year_link = ($date->getYear() + 1).vsprintf("%02d", array($date->getMonth()));

        $this->assign('prev_year_link', $prev_year_link);
        $this->assign('next_year_link', $next_year_link);

        $this->setTemplate('elib:admin/events_month.tpl');
    }

}