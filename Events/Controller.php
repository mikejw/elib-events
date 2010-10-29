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
    
    $date = new DateTime(time());

    $c = new Calendar();


    $date->resetToFirst();

    $prev_days = $date->getDayOfWeek() - 1; 

    $date_last_month = clone $date;

    $date_last_month->adjustMonth(-1);
    echo $date_last_month->getDayOfWeek();



    //    $cal = $c->buildByMonth($date);

    




    //    print_r($cal);

    $this->setTemplate('elib://admin/events_month.tpl');
  }



}
?>