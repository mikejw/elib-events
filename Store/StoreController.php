<?php

namespace ELib\Store;
use ELib\Model;
use ELib\EController;
use ELib\User\CurrentUser;
use ELib\Country\Country;

class StoreController extends EController
{  

  public function default_event()
  {            
    $ui_array = array('page');
    $this->loadUIVars('ui_cats', $ui_array);
    if(!isset($_GET['page']))
      {
	$_GET['page'] = 1;
      }

    $category_id = 0;

    
    
    if(isset($_GET['id']) && is_numeric($_GET['id']))
      {
	$category_id = $_GET['id'];
      }
       

    if(isset($_GET['category_name']))
      {
	$cl = Model::load('CategoryItem');
	$category_id = $cl->loadIDByName($_GET['category_name']);
      }

    $_GET['category_id'] = $category_id;   
    $_SESSION['last_cat'] = $category_id;

    $_GET['product_id'] = 0;
    $_GET['option_id'] = 0;

    
    $p = Model::load('ProductItem');
    $c = Model::load('CategoryItem');
    $v = Model::load('ProductVariant');
    $o = Model::load('ProductVariantPropertyOption');
        
    $c->id = $_GET['category_id'];
    $p->id = 0;
    $v->id = 0;
    $o->id = 0;

    $l = new ProductsLayout($c, $p, $v, $o, $this); 
    
    $this->presenter->assign('breadcrumb', $l->getBreadCrumb());
    $this->presenter->assign('buttons', $l->getButtons());
    $this->presenter->assign('p_nav', $l->getPNav());

    
    $this->presenter->assign('category_id', $_GET['category_id']);
    $this->presenter->assign('product_id', $_GET['product_id']);
    $this->presenter->assign('option_id', $_GET['option_id']);

    $this->getPromos($_GET['category_id']);

    
    $this->setTemplate('elib://store_category.tpl');

    // seo
    if($category_id > 0)
      {
	$this->presenter->assign('custom_title', $c->name.' at Brighton BMX Co');
	$this->presenter->assign('category_name', $c->name);
      }    
  }


  // copied across from store.php
  public function getPromos($category_id)
  {
    $p = Model::load('PromoItem');

    $c = Model::load('CategoryItem');
    $ids = array();
    $c->buildDescendantIDs($category_id, $ids);
    $cat_string = $c->buildUnionString($ids);

    // remove root category unless in root
    $cat_string = str_replace('(0,', '(', $cat_string);
    
    $sql = ' WHERE category_id IN '.$cat_string
      .' AND image IS NOT NULL'
      .' AND url IS NOT NULL'
      .' ORDER BY id DESC';
    $promos = $p->getAllCustom(Model::getTable('PromoItem'), $sql);
    shuffle($promos);
    $this->presenter->assign('promos', $promos);
  }

  public function accepting_paypal()
  {
    $this->setTemplate('accepting_paypal.tpl');
  }


  // taken from old controller classes. eg. cart, checkout
  public function cart()
  {
    $this->setTemplate('cart.tpl');
    $c = new ShoppingCart();
    
    if(isset($_POST['update']))
      {
	foreach($_POST['qty'] as $v => $qty)
	  {
	    if(is_numeric($qty) && $qty > 0)
	      {
		$c->update($v, $qty);
	      }
	    elseif(is_numeric($qty) && $qty == 0)
	      {
		$c->remove($v);
	      }
	  }
	$this->redirect('store/cart');
      }
    elseif(isset($_POST['checkout']))
      {
	$this->redirect('store/checkout');
      }

    $items = $c->loadFromCart($this);
    
    if(sizeof($items) > 0)
      {
	$ids = array();
	foreach($items as $item)
	  {
	    array_push($ids, $item['id']);
	  }

	$v = Model::load('ProductVariant');
	$cat_ids = $v->getCategories($ids);
	$cat = Model::load('CategoryItem');
	$calc = new ShippingCalculator($c->calcTotal($items), $cat_ids, $cat, sizeof($items), false);
	$shipping = $calc->getFee();
	$this->presenter->assign('shipping', $shipping);
	$this->presenter->assign('total', $c->calcTotal($items) + $shipping);
	$this->presenter->assign('items', $items);
      }  
    
    $this->presenter->assign('last_cat', $_SESSION['last_cat']);
  }  
  

  public function checkout()
  { 
    $this->setTemplate('checkout.tpl');
    $s = Model::load('ShippingAddress');
    
    $sql = ' WHERE user_id = '.CurrentUser::getUserID().' ORDER BY id DESC';
    $addresses = $s->getAllCustom(Model::getTable('ShippingAddress'), $sql);

    $this->presenter->assign('addresses', $addresses);
    
    if(isset($_GET['checkout']))
      {	              
	$_SESSION['shipping_address_id'] = $_GET['shipping_address_id'];
	$this->redirect('paypal');
      }
  }

  public function edit_address()
  {
    $this->setTemplate('address.tpl');
    if(isset($_GET['id']) && is_numeric($_GET['id']))
      {
	if(isset($_POST['save']))
	  {
	    $s = Model::load('ShippingAddress');
	    $s->id = $_GET['id'];
	    $s->load();
	    $s->first_name = $_POST['first_name'];
	    $s->last_name = $_POST['last_name'];
	    $s->address1 = $_POST['address1'];
	    $s->address2  = $_POST['address2'];
	    $s->city = $_POST['city'];
	    $s->state = $_POST['state'];
	    $s->zip = $_POST['zip'];
	    $s->country = $_POST['country'];
	    $s->validates();
	    if($s->hasValErrors())
	      {
		$this->presenter->assign('address', $s);
		$this->presenter->assign('sc', $s->country);	   
	    	    
		$this->presenter->assign('errors', $s->getValErrors());

	      }
	    else
	      {
		$s->save(Model::getTable('ShippingAddress'), array(), 1);
		$this->redirect('store/checkout');
	      }
	  }
	else
	  {
	    $s = Model::load('ShippingAddress');
	    $s->id = $_GET['id'];
	    $s->load();
	    $this->presenter->assign('address', $s);
	    $this->presenter->assign('sc', $s->country);	   
	  }

	$countries = Country::build();
	$this->presenter->assign('countries', $countries); 
      }
  }

  public function add_address()
  {
    $this->setTemplate('address.tpl');
    $countries = Country::build();
    $this->presenter->assign('countries', $countries); 
    $this->presenter->assign('sc', 'GB');

    if(isset($_POST['save']))
      {
	$s = Model::load('ShippingAddress');
	$s->user_id = CurrentUser::getUserID();;
	$s->first_name = $_POST['first_name'];
	$s->last_name = $_POST['last_name'];
	$s->address1 = $_POST['address1'];
	$s->address2  = $_POST['address2'];
	$s->city = $_POST['city'];
	$s->state = $_POST['state'];
	$s->zip = $_POST['zip'];
	$s->country = $_POST['country'];
	$s->validates();
	if($s->hasValErrors())
	  {
	    $this->presenter->assign('address', $s);
	    $this->presenter->assign('sc', $s->country);	   	    
	    $this->presenter->assign('errors', $s->getValErrors());	    
	  }
	else
	  {
	    $s->insert(Model::getTable('ShippingAddress'), 1, array(), 0);
	    $this->redirect('store/checkout');
	  }
      }
  }

  


  public function product()
  {
    $this->setTemplate('product.tpl');
    $product_id = 0;
    
    
    if(isset($_GET['id']) && is_numeric($_GET['id']))
      {
	$product_id = $_GET['id'];
      }
    

    if(isset($_GET['product_name']))
      {
	$name_arr = explode('-', $_GET['product_name']);
	$product_id = $name_arr[sizeof($name_arr)-1];
      }

    $_GET['product_id'] = $product_id;   

    if($this->isXMLHttpRequest())
      {
	header('Content-type: application/json');
	$c = Model::load('ProductColour');
	$c->id = $_GET['colour_id'];
	$c->load();
	$item = array();
	$item['image'] = $c->image;
	$item['option_id'] = $c->property_option_id;
       	echo json_encode($item);	
	exit();
      }
    else
      {
	// default event from store.php

	$p = Model::load('ProductItem');
	$c = Model::load('CategoryItem');
	$v = Model::load('ProductVariant');
	$o = Model::load('ProductVariantPropertyOption');
	
	$c->id = 0;
	$p->id = $_GET['product_id'];
	$v->id = 0;
	$o->id = 0;

	if(isset($_POST['add']))
	  {       
	    $options = array();
	    if(isset($_POST['property']))
	      {
		foreach($_POST['property'] as $option)
		  {
		    array_push($options, $option);
		  }	    
	      }

	    if(sizeof($options) > 0)
	      {
		$variant_id = $v->findVariant($options, $p->id);
	      }
	    else
	      {	   
		$sql = ' WHERE product_id = '.$p->id.' LIMIT 0, 1';
		$variant = $v->getAllCustom(Model::getTable('ProductVariant'), $sql);
		if(sizeof($variant) > 0)
		  {
		    $variant_id = $variant[0]['id'];
		  }
	      }

	    if(is_numeric($variant_id) && $variant_id > 0)
	      {	    
		$sc = new ShoppingCart();
		$sc->add($variant_id, 1);		      		  
		$this->redirect('store/cart');	    
	      }	    
	  }

	$l = new ProductsLayout($c, $p, $v, $o, $this);
        
	$this->presenter->assign('breadcrumb', $l->getBreadCrumb());
	$this->presenter->assign('buttons', $l->getButtons());

	$this->presenter->assign('p_nav', $l->getPNav());

	if($_GET['product_id'] != 0)
	  {
	    $c = Model::load('ProductColour');
	    $colours = $c->getColoursIndexed($_GET['product_id']);
	    if(sizeof($colours) > 0)
	      {
		$this->presenter->assign('colours', $colours);
	      }

	    $b = Model::load('BrandItem');
	    $b->id = $p->brand_id;
	    $b->load();
	    $this->presenter->assign('brand', $b->name);
	    $this->presenter->assign('product_view', 1);
	    //$variant_count = $this->assignVariantsTableData($p, $v);
	    $this->getPropertiesAndOptions($p->id, (sizeof($colours) > 0));

	  }   
        

	$_GET['category_id'] = -1;
	
    
	$this->presenter->assign('category_id', $_GET['category_id']);
	$this->presenter->assign('product_id', $_GET['product_id']);
	$this->presenter->assign('option_id', 0);

	if($_GET['product_id'] != 0)
	  {
	    $p = $l->getProduct();
	    if(sizeof($colours) > 0)
	      {
		$p->image = $c->getFirstColourImage($_GET['product_id']);
	      }
	    
	    $this->presenter->assign('product', $p);

	    $qty = array();
	    $i = 0;
	    for($i; $i < 31; $i++)
	      {
		$qty[$i] = $i;
	      }
	    
	    $this->presenter->assign('qty', $qty);
	  }

	$this->setTemplate('store_product.tpl');	
      }

    // seo
    $c = Model::load('CategoryItem');
    $c->id = $p->category_id;
    $c->load();
    $this->presenter->assign('price', $p->getPrice());
    $this->presenter->assign('custom_title',
			     $b->name.' '.$p->name.' - '.$c->name
			     .' at Brighton BMX Co');
    $this->presenter->assign('custom_keywords', strtolower($b->name.' '.$p->name.' '.$c->name));
    $this->presenter->assign('custom_description', $b->name.' '.$p->name.' in '.$c->name.' - '.strip_tags($p->description));
  }




  public function assignVariantsTableData($p, $v)
  {
    $variants = $v->getAllForProduct($p->id, $p->name);       
    
    $total_weight_g = 0;
    $total_weight_lb = 0;
    foreach($variants as $item)
      {
	if(isset($item['weight_g']))
	  {
	    $total_weight_g += $item['weight_g'];

	  }
	if(isset($item['weight_lb']))
	  {
	    $total_weight_lb += $item['weight_lb'];
	  }
      }

    //    print_r($variants);
    $fixed_properties = array('id', 'weight_g', 'weight_lb', 'name');
    $dynamic_properties = array();
    foreach($variants as $index => $value)
      {
	foreach($value as $index2 => $value2)
	  {
	    if(!in_array($index2, $fixed_properties) && !in_array($index2, $dynamic_properties))
	      {
		array_push($dynamic_properties, $index2);
	      }
	  }
      }
    $this->presenter->assign('variants', $variants);
    $this->presenter->assign('dynamic_properties', $dynamic_properties);    
    $this->presenter->assign('total_weight_g', $total_weight_g);
    $this->presenter->assign('total_weight_lb', $total_weight_lb);
    return sizeof($variants);
  }


  // taken from product admin (variant properties)
  public function getPropertiesAndOptions($product_id, $colours)
  {
    /*
    $v = new ProductVariant($this);
    $v->id = $_GET['id'];
    $v->load(ProductVariant::$table);
    */
   
    $p = Model::load('ProductItem');
    $p->id = $product_id;
    $p->load();

    $c = Model::load('CategoryItem');
    $cats = $c->getAncestorIds($p->category_id, array());

    $cp = Model::load('CategoryProperty');

    array_push($cats, $p->category_id);
    $props = $cp->getPropertiesByCategory($cats);

    if(!$colours && $p->category_id != 8)
      {
	array_push($props, 2); // always allow colour property    
      }

    //    $this->presenter->assign('product', $p);
    //$this->presenter->assign('variant', $v);


    $opts = array();
    $pv = Model::load('ProductVariantPropertyOption');
    $opts = $pv->buildUnionString($pv->getActiveOptions($p->id));
    
    if(sizeof($props) > 0)
      {
	$property = Model::load('Property');
	$properties = $property->getAllWithOptionsForProduct($props, $opts);
	$this->presenter->assign('properties', $properties);

	/*
	$pv = new ProductVariantPropertyOption($this);
	$sql = ' WHERE product_variant_id = '.$_GET['id'];
	$options = $pv->getAllCustom(ProductVariantPropertyOption::$table, $sql);
	$o = array();
	foreach($options as $index => $value)
	  {
	    array_push($o, $value['property_option_id']);
	  }
	$this->presenter->assign('options', $o);    
	*/
	
      }
  }


  








}
?>