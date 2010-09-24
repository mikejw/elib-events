<?php

namespace ELib\Store;
use ELib\Model;
use ELib\User\CurrentUser;
use ELib\Country\Country;

class StoreController extends StoreControllerLite
{  

  public function default_event()
  {
    $this->setTemplate('elib://store_category.tpl');
  }

  public function defaultLayout()
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



  








}
?>