<?php

namespace ELib\Events;
use ELib\Model;
use Empathy\Controller\CustomController;

use ELib\DateTime;

class EventsFrontController extends CustomController
{ 

  public function default_event()
  {
    $this->setTemplate('events.tpl');
    $now = new DateTime(array(time()-43200)); // minus 12 hours

    $e = Model::load('Event');
    $events = $e->getEvents(true, $now);


    $this->assign('events', $events);
    

  }






}
?>