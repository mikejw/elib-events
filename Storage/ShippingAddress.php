<?php

namespace ELib\Storage;
use ELib\Model;
use Empathy\Entity as Entity;


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

  /*
  public function loadFromOrder($order_id)
  {
    $sql = 'SELECT * FROM '.ShippingAddress::$table.' t1,'
      .' '.OrderItem::$table
  }
  */
  
  
  public function valString($text, $alnum)
  {
    $val = true;
    $text = str_replace('\'', '', $text);
    $text = str_replace('-', '', $text);
    $text = str_replace(' ', '', $text);
    
    if($alnum)
      {
	if($text == '' || !ctype_alnum($text))
	  {
	    $val = false;
	  }
      }
    else
      {
	if($text == '' || !ctype_alpha($text))
	  {
	    $val = false;
	  }
      }
    return $val;
  }
  

  public function validates()
  {
    
    if(!$this->valString($this->first_name, 0))
      {
	$this->addValError('Invalid firstname.');
      }
    if(!$this->valString($this->last_name, 0))
      {
	$this->addValError('Invalid lastname.');
      }
    if(!$this->valString($this->address1, 1))
      {
	$this->addValError('Invalid first line of address.');
      }
    if($this->address2 != '' && !$this->valString($this->address2, 1))
      {
	$this->addValError('Invalid second line of address.');
      }
    if(!$this->valString($this->city, 0))
      {
	$this->addValError('Invalid city name.');
      }
    if(!$this->valString($this->state, 0))
      {
	$this->addValError('Invalid county / state name.');
      } 
    if(!$this->valString($this->zip, 1))
      {
	$this->addValError('Invalid post code / zip.');
      }
    if(!$this->valString($this->country, 0))
      {
	$this->addValError('Invalid value for country.');
      }
    
  }
}
?>