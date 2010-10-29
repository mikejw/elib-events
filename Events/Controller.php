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
	$time = mktime(0, 0, 0, substr($month, 0, 2),
		       1, substr($month, 2, 4));
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


    //    echo $date_prev_month->getMySQLTime()."<br />";
    //echo $date->getMySQLTime()."<br />";
    //echo $date_next_month->getMySQLTime()."<br />";
    


    $month = $c->newBuildByMonth($date_prev_month->getDay(),
				 $date_prev_month->getMonth(),
				 $date_prev_month->getYear(),
				 $date_prev_month->getLastDay(),
				 $date->getLastDay());

    
    $this->assign('month', $date->getMonthText());
    $this->assign('cal_month', $month);


    $prev_month_link = vsprintf("%02d", $date->getMonth()-1).$date->getYear();
    $next_month_link = vsprintf("%02d", $date->getMonth()+1).$date->getYear();

    $this->assign('prev_month_link', $prev_month_link);
    $this->assign('next_month_link', $next_month_link);



    //    $cal = $c->buildByMonth($date);

    




    //    print_r($cal);

    $this->setTemplate('elib://admin/events_month.tpl');
  }



}
?>