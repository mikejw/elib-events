<?php

namespace Empathy\ELib\Storage;

use Empathy\MVC\Entity;

class LineItem extends Entity
{
    const TABLE = 'line_item';

    public $id;
    public $order_id;
    public $variant_id;
    public $price;
    public $quantity;

}
