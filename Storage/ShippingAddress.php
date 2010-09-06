<?php

namespace ELib\Storage;
use ELib\Model;
use Empathy\Entity as Entity;
use Empathy\Validate;


class ShippingAddress extends Entity
{
  const TABLE = 'shipping_address';

  public $id;
  public $user_id;
  public $first_name;
  public $last_name;
  public $address1;
  public $address2;
  public $city;
  public $state;
  public $zip;
  public $country;
  
  public function validates()
  {
    $this->doValType(Validate::TEXT, 'first_name', $this->first_name, false);
    $this->doValType(Validate::TEXT, 'last_name', $this->last_name, false);
    $this->doValType(Validate::TEXT, 'address1', $this->address1, false);
    $this->doValType(Validate::TEXT, 'address2', $this->address2, true);
    $this->doValType(Validate::TEXT, 'city', $this->city, false);
    $this->doValType(Validate::TEXT, 'state', $this->state, false);
    $this->doValType(Validate::TEXT, 'zip', $this->zip, false);
    $this->doValType(Validate::TEXT, 'country', $this->country, false);   
  }
}
?>