<?php

namespace ELib\Store;
use ELib\Model;

class OrdersController extends AdminController
{
  public function default_event()
  {
    $o = Model::load('OrderItem');
    $orders = $o->getOrders();
    $this->presenter->assign('orders', $orders);
    $this->setTemplate('elib://admin/orders.tpl');
  }
}
?>