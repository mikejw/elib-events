<?php

namespace ELib\Store;
use ELib\Model;
use Empathy\Session;

class ShoppingCart
{
  public function calcTotal($items)
  {
    $total = 0;
    foreach($items as $item)
      {
	$total += $item['line'];
      }
    return $total;
  }


  public function loadFromCart($c)
  {
    $ids = array();
    $product_data = array();

    if(($cart = Session::get('cart')) != false)
      {
	foreach($cart as $v => $qty)
	  {
	    array_push($ids, $v);
	  }	
	$v = Model::load('ProductVariant');
	$id_string = $v->buildUnionString($ids);
	$product_data = $v->getCartData($id_string);

	foreach($product_data as $index => $value)
	  {
	    $id = $value['id'];	   
	    $price = $value['price'];
	    $qty = $cart[$id];	
	    $product_data[$index]['qty'] = $qty;
	    $product_data[$index]['line'] = $qty * $price; 
	  }    
      }
    
    return $product_data;
  }

  public function add($variant_id, $qty)
  {
    if(($cart = Session::get('cart')) == false)
      {
	$cart = array();
      }

    if(isset($cart[$variant_id]))
      {
	$cart[$variant_id] += (int)($qty);
      }
    else
      {
	$cart[$variant_id] = (int)($qty);
      }      
    Session::set('cart', $cart);
  }

  public function remove($variant_id)
  {
    if(($cart = Session::get('cart')) != false)
      {	      
	if(isset($cart[$variant_id]))
	  {
	    unset($cart[$variant_id]);
	    Session::set('cart', $cart);
	  }	
      }
  }


  public function update($variant_id, $qty)
  {
    if(($cart = Session::get('cart')) != false)
      {
	if(isset($cart[$variant_id]))
	  {
	    $cart[$variant_id] = (int)($qty);
	    Session::set('cart', $cart);
	  }
      }
  }


  public static function getTotalItems()
  {
    $total = 0;
    if(($cart = Session::get('cart')) != false)
      {    
	foreach($cart as $v => $qty)
	  {
	    $total += $qty;
	  }
      }
    return $total;
  }


  public function emptyCart()
  {
    Session::set('cart', array());
  }

  public function isEmpty()
  {
    $empty = false;
    if(($cart = Session::get('cart')) == false
       || sizeof($cart) < 1)
      {
	$empty = true;
      }
    return $empty;
  }
}
?>