<?php

namespace ELib\Storage;

use ELib\Model;
use Empathy\Entity;

class Event extends Entity
{
  const TABLE = 'event';

  public $id;
  public $user_id;
  public $start_time;
  public $end_time;
  public $event_name;
  public $short_desc;
  public $long_desc;
  public $tickets_link;
  public $event_link;


}
?>