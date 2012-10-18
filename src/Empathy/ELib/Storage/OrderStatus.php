<?php

namespace ELib\Storage;
use ELib\Model;
use Empathy\Entity as Entity;


class OrderStatus extends Entity
{
  const TABLE = 'order_status';

  public $id;
  public $user_id;
  public $status;
  public $stamp;
    
}
?>