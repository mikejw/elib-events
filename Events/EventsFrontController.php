<?php

namespace ELib\Events;
use ELib\Model;
use Empathy\Controller\CustomController;

use ELib\DateTime;

class EventsFrontController extends CustomController
{ 

  public function default_event()
  {
    $this->setTemplate('elib://events.tpl');
    $now = new DateTime();
    $e = Model::load('Event');
    $events = $e->getEvents(true, $now);


    //    print_r($events);
    

  }






}
?>