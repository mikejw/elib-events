<?php

namespace ELib\Store;
use ELib\Model;

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

    if(isset($_SESSION['cart']) && sizeof($_SESSION['cart']) > 0)
      {
	foreach($_SESSION['cart'] as $v => $qty)
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
	    $qty = $_SESSION['cart'][$id];	
	    $product_data[$index]['qty'] = $qty;
	    $product_data[$index]['line'] = $qty * $price; 
	  }    
      }
    
    return $product_data;
  }

  public function add($variant_id, $qty)
  {
    if(isset($_SESSION['cart'][$variant_id]))
      {
	$_SESSION['cart'][$variant_id] += (int)($qty);
      }
    else
      {
	$_SESSION['cart'][$variant_id] = (int)($qty);
      }      
  }

  public function remove($variant_id)
  {
    if(isset($_SESSION['cart'][$variant_id]))
      {
	unset($_SESSION['cart'][$variant_id]);
      }
  }


  public function update($variant_id, $qty)
  {
    if(isset($_SESSION['cart'][$variant_id]))
      {
	$_SESSION['cart'][$variant_id] = (int)($qty);
      }
  }


  public static function getTotalItems()
  {
    $total = 0;
    if(isset($_SESSION['cart']) && sizeof($_SESSION['cart']) > 0)
      {
	foreach($_SESSION['cart'] as $v => $qty)
	  {
	    $total += $qty;
	  }
      }
    return $total;
  }


  public function emptyCart()
  {
    $_SESSION['cart'] = array();
  }

  public function isEmpty()
  {
    $empty = false;
    if(sizeof($_SESSION['cart']) < 1)
      {
	$empty = true;
      }
    return $empty;
  }
}
?>