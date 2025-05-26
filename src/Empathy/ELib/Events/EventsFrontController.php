<?php

namespace Empathy\ELib\Events;

use Empathy\MVC\Model;
use Empathy\ELib\Storage\Event;
use Empathy\MVC\Controller\CustomController;
use Empathy\ELib\DateTime;


class EventsFrontController extends CustomController
{

    public function default_event()
    {
        $this->setTemplate('events.tpl');
        $now = new DateTime(array(time()-43200)); // minus 12 hours

        $e = Model::load(Event::class);
        $events = $e->getEvents(true, $now);

        $this->assign('events', $events);

    }

}
