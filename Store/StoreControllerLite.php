<?php

namespace ELib\Store;
use ELib\Model;

use ELib\AuthedController;
use ELib\EController;

use ELib\User\CurrentUser;

class StoreControllerLite extends EController
{

  public function filterInt($name)
  {
    if(isset($_GET[$name]))
      {
	return (int)$_GET[$name];
      }
    else
      {
	return 0;
      }
  }

  public function default_event()
  {
    $this->setTemplate('elib://store_category.tpl');
  }

  
  public function minimalLayout()
  {
    $page = $this->filterInt('page');
    $vendor_id = $this->filterInt('vendor_id');
    $this->assign('cart_items', ShoppingCart::getTotalItems());
    $this->assign('top_cats', ProductsLayout::getTopCats());
    if(!isset($_GET['vendor_id']))
      {
	$_GET['vendor_id'] = 0;
      }
    else 
      {
	$_GET['vendor_id'] = (int)$_GET['vendor_id'];
      }
    $p = Model::load('ProductItem');
    $status = '('
      .StoreStatus::AVAILABLE.', '
      .StoreStatus::SOLD_OUT
      .')';
    $sql = ' WHERE status IN'.$status;
    if($vendor_id > 0)
      {
	$sql .= ' AND vendor_id = '.$vendor_id;
      }
    $sql .= ' ORDER BY id DESC';

    if($page < 1)
      {
	$page = 1;
      }
        
    $per_page = 4;
    $products = $p->getAllCustomPaginate(Model::getTable('ProductItem'), $sql, $page, $per_page);
    $p_nav = $p->getPaginatePages(Model::getTable('ProductItem'), $sql, $page, $per_page); 

    $this->assign('products', $products);      
    $this->assign('p_nav', $p_nav);
    $this->assign('vendor_id', $vendor_id);
    $this->assign('vendor_id', $_GET['vendor_id']);
  }


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

	    if(defined('ELIB_USE_PRODUCT_BRANDS') &&
	       ELIB_USE_PRODUCT_BRANDS == true)
	      {
		$b = Model::load('BrandItem');
		$b->id = $p->brand_id;
		$b->load();
		$this->presenter->assign('brand', $b->name);
	      }
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

    $custom_title = '';
    $custom_keywords = '';
    $custom_description = '';
    if(isset($b))
      {
	$custom_title = $b->name.' ';
	$custom_keywords = $b->name.' ';
	$custom_description = $b->name.' ';
      }
    $custom_title .= $p->name.' - '.$c->name.' at Brighton BMX Co';
    $custom_keywords .= $p->name.' '.$c->name;
    $custom_description .= $p->name.' in '.$c->name;

    $this->presenter->assign('custom_title', $custom_title);
    $this->presenter->assign('custom_keywords', strtolower($custom_keywords));
    $this->presenter->assign('custom_description', $custom_description.' - '.strip_tags($p->description));
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