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
	$e->user_id = CurrentUser::getUserID();
	$e->start_time = $start->getMySQLTime();
	$e->end_time = $end->getMySQLTime();
	$e->event_name = $_POST['event_name'];
	$e->short_desc = $_POST['short_desc'];
	$e->long_desc = $_POST['long_desc'];
	$e->tickets_link = $_POST['tickets_link'];
	$e->event_link = $_POST['event_link'];				
	$e->insert(Model::getTable('Event'), 1, array(), 1);
	$this->redirect('admin/events');
      }



    $date = $this->filterInt('date');
    if(strlen($date) != 8)
      {
	$date = 0;
      }
    
    if($date == 0)
      {
	//$time = time();
      }
    else
      {
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


    $month = $c->newBuildByMonth($date_prev_month->getDay(),
				 $date_prev_month->getMonth(),
				 $date_prev_month->getYear(),
				 $date_prev_month->getLastDay(),
				 $date->getLastDay());

    
    $this->assign('month', $date->getMonthText());
    $this->assign('year', $date->getYear());
    $this->assign('current_month', vsprintf("%02d", $date->getMonth()));
    $this->assign('cal_month', $month);


    $prev_month_link = $date->getYear().vsprintf("%02d", $date->getMonth()-1);
    $next_month_link = $date->getYear().vsprintf("%02d", $date->getMonth()+1);

    $this->assign('prev_month_link', $prev_month_link);
    $this->assign('next_month_link', $next_month_link);

    $prev_year_link = ($date->getYear() - 1).vsprintf("%02d", $date->getMonth());
    $next_year_link = ($date->getYear() + 1).vsprintf("%02d", $date->getMonth());

    $this->assign('prev_year_link', $prev_year_link);
    $this->assign('next_year_link', $next_year_link);

    //    $cal = $c->buildByMonth($date);

    




    //    print_r($cal);

    $this->setTemplate('elib://admin/events_month.tpl');
  }



}
?>