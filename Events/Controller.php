<?php

namespace ELib\Events;

use ELib\AdminController;
use ELib\Model;
use ELib\DateTime;

use Empathy\Session;

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


    $date = new DateTime($time);

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