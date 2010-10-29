<?php

namespace ELib\Events;

class Calendar
{
  
  public function __construct()
  {
    //
  }

  public function buildByMonth($date)
  {
    $cal = array();
    for($i = 1; $i < ($date->getLastDay() + 1); $i++)
      {
	$cal[$i] = 'calendar day';
      }    

    return $cal;
  }

}
?>