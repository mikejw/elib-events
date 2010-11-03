<?php

namespace ELib\Events;

use ELib\AdminController;
use ELib\Model;
use ELib\DateTime;

use Empathy\Session;
use ELib\User\CurrentUser;

class Controller extends AdminController
{ 

  public function filterInt($name)
  {
    if(isset($_GET[$name]))
      {
	return (int)$_GET[$name];
      }
    else
      {
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
    $e = Model::load('Event');
    $e->id = $id;
    $e->load();
    $this->assign('event', $e);
    $this->setTemplate('elib://admin/view_event.tpl');
  }


  public function add_event()
  {
    if(isset($_POST['submit']))
      {       

	$time = array('day' => $_POST['start_day'],
		      'month' => $_POST['start_month'] + 1,
		      'year' => $_POST['start_year'],
		      'hour' => $_POST['start_hour'],
		      'minute' => $_POST['start_minute'] * 5,
		      'second' => 0);
	$start = new DateTime($time);
	

	$time = array('day' => $_POST['end_day'],
		      'month' => $_POST['end_month'] + 1,
		      'year' => $_POST['end_year'],
		      'hour' => $_POST['end_hour'],
		      'minute' => $_POST['end_minute'] * 5,
		      'second' => 0);
	$end = new DateTime($time);

	$e = Model::load('Event');

	if(!$start->getValid())
	  {
	    $e->addValError('invalid start date', 'start_time');
	  }
	if(!$end->getValid())
	  {
	    $e->addValError('invalid end date', 'end_time');
	  }

	$e->user_id = CurrentUser::getUserID();
	$e->start_time = $start->getMySQLTime();
	$e->end_time = $end->getMySQLTime();

	if($end->getTime() <= $start->getTime())
	  {
	    $e->addValError('invalid end date/time', 'end_time');
	  }

	$e->event_name = $_POST['event_name'];
	$e->short_desc = $_POST['short_desc'];
	$e->long_desc = $_POST['long_desc'];
	$e->tickets_link = $_POST['tickets_link'];
	$e->event_link = $_POST['event_link'];

	$e->validates();
	if($e->hasValErrors())
	  {
	    $e->start_day = $_POST['start_day'];
	    $e->start_month = $_POST['start_month'];
	    $e->start_year = $_POST['start_year'];
	    $e->start_hour = $_POST['start_hour'];
	    $e->start_minute = $_POST['start_minute'];

	    $e->end_day = $_POST['end_day'];
	    $e->end_month = $_POST['end_month'];
	    $e->end_year = $_POST['end_year'];
	    $e->end_hour = $_POST['end_hour'];
	    $e->end_minute = $_POST['end_minute'];

	    $this->assign('event', $e);
	    $this->assign('errors', $e->getValErrors());
	  }
	else
	  {	  
	    $e->insert(Model::getTable('Event'), 1, array(), 1);
	    $this->redirect('admin/events');
	  }
      }
    else
      {	
	$e = Model::load('Event'); // default (mostly empty) event

	$date = $this->filterInt('date');
	if(strlen($date) != 8)
	  {
	    $date = 0;
	  }
	if($date != 0)
	  {
	    $y = substr($date, 0, 4);
	    $m = substr($date, 4, 2);
	    $d = substr($date, 6, 2);
	    $time = mktime(0, 0, 0, $m,
			   $d, $y);	


	    $e->start_day = $d;
	    $e->start_month = $m - 1;
	    $e->start_year = $y;
	    $e->start_hour = 20;
	    $e->start_minute = 0;

	    $e->end_day = $d;
	    $e->end_month = $m - 1;
	    $e->end_year = $y;
	    $e->end_hour = 20;
	    $e->end_minute = 0;
	    $this->assign('event', $e);
	  }
	
      }

    
    if(0) //$date == 0)
      {
	//$time = time();
      }
    else
      {
	/*
	$y = substr($date, 0, 4);
	$m = substr($date, 4, 2);
	$d = substr($date, 6, 2);
	$time = mktime(0, 0, 0, $m,
		       $d, $y);	
	$this->assign('day', $d);
	$this->assign('month', $m - 1);
	$this->assign('year', $y);
	
	$this->assign('hour', 20);
	$this->assign('minute', 0);
	*/
      }    

    $select_days = array();
    $i = 1;
    while($i < 32)
      {
	$select_days[$i] = $i;
	$i++;
      }
    $select_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    
    $select_years = array();
    $date = new DateTime();
    $year = $date->getYear();
    $i =  $year - 5;
    while($i < $year + 5)
      {
	$select_years[$i] = $i;
	$i++;
      }
    
    $select_hours = array();
    $i = 0;
    while($i < 24)
      {
	$select_hours[$i] = sprintf("%02d", $i);
	$i++;
      }

    $select_minutes = array();
    $i = 0;
    $minute = 0;
    while($minute < 60)
      {
	$select_minutes[$i] = sprintf("%02d", $minute);
	$minute += 5;
	$i++;
      }
    

    $this->assign('select_days', $select_days);
    $this->assign('select_months', $select_months);
    $this->assign('select_years', $select_years);
    $this->assign('select_hours', $select_hours);
    $this->assign('select_minutes', $select_minutes);
 

    $this->setTemplate('elib://admin/add_event.tpl');
  }

  public function monthView()
  {
    $month = $this->filterInt('month');
    if(strlen($month) != 6)
      {
	$month = 0;
      }
    
    if($month == 0)
      {
	$time = time();
      }
    else
      {
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


    $e = Model::load('Event');
    $events = $e->getEvents($date_prev_month, $date_next_month);

    $month = $c->newBuildByMonth($date_prev_month->getDay(),
				 $date_prev_month->getMonth(),
				 $date_prev_month->getYear(),
				 $date_prev_month->getLastDay(),
				 $date->getLastDay(),
				 $events);

    $this->assign('month', $date->getMonthText());
    $this->assign('year', $date->getYear());
    $this->assign('current_month', vsprintf("%02d", $date->getMonth()));
    $this->assign('cal_month', $month);


    if($date->getMonth() == 12)
      {
	$next_month_link = $date->getYear().'01';
      }
    else
      {
        $next_month_link = $date->getYear().vsprintf("%02d", $date->getMonth()+1);
      }

    if($date->getMonth() == 1)
      {
	$prev_month_link = $date->getYear().'12';
      }
    else
      {
	$prev_month_link = $date->getYear().vsprintf("%02d", $date->getMonth()-1);
      }


    $this->assign('prev_month_link', $prev_month_link);
    $this->assign('next_month_link', $next_month_link);

    $prev_year_link = ($date->getYear() - 1).vsprintf("%02d", $date->getMonth());
    $next_year_link = ($date->getYear() + 1).vsprintf("%02d", $date->getMonth());

    $this->assign('prev_year_link', $prev_year_link);
    $this->assign('next_year_link', $next_year_link);

    $this->setTemplate('elib://admin/events_month.tpl');
  }



}
?>