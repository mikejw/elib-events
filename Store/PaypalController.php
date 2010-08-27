<?php

namespace ELib\Store;
use ELib\Model;
use ELib\EController;
use ELib\ThirdParty\PaypalClass;

//require(DOC_ROOT.'/application/paypal-class/paypal.class.php');


define('PAYPAL_URL', 'http://www.sandbox.paypal.com/cgi-bin/webscr');
//define('PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscr');

class PaypalController extends EController
{
  public function success()
  {
    $this->assignMessage('Thank you for your order');
  }

  public function cancel()
  {
    $this->assignMessage('The order was canceled');
  }

  public function writeLog($data)
  {
    if(sizeof($data) > 0)
      {
	$yaml = \Spyc::YAMLDump($data, 4, 60);
	$fh = fopen(DOC_ROOT.'/logs/paypal', "a");
	fwrite($fh, $yaml);
	fclose($fh);
      }
  }

  public function ipn()
  {    
    $p = new PaypalClass();
    $p->ipn_log = false;
    $p->paypal_url = PAYPAL_URL;

    if($p->validate_ipn())
      {
	if(isset($p->ipn_data['invoice']) && is_numeric($p->ipn_data['invoice'])
	   && 'Completed' == $p->ipn_data['payment_status'])
	  {
	    $o = Model::load('OrderItem');
	    $o->id = $p->ipn_data['invoice'];
	    $o->load();
	    $o->status = 2;
	    $o->save(Model::getTable('OrderItem'), array(), 0);
	  }	    
	$this->writeLog($p->ipn_data);
      }
  }

  public function assignMessage($message)
  {
    if($message != '')
      {
	$this->presenter->assign('message', $message);
      }
  }


  public function default_event()
  {  
    $c = new ShoppingCart();
    if($c->isEmpty())
      {
	$this->redirect('paypal/cancel');
      }
    $items = $c->loadFromCart($this);

    $co = new Checkout($items, $this);
    $invoice_no = $co->getInvoiceNo();

    $o = Model::load('OrderItem');
    $o->id = $invoice_no;
    $o->load();
    
    $products = array();    

    //$product[0]['alias'] = 'Some product';
    //$product[0]['price'] = 1.99;
    //$product[0]['code'] = 23;

    $interface = 'http://'.WEB_ROOT.PUBLIC_DIR.'/paypal/';
    $message = '';
    $p = new PaypalClass();
    $p->ipn_log = false;
    $p->paypal_url = PAYPAL_URL;
    $p->add_field('cmd', '_cart');
    $p->add_field('upload', '1');

    // address
    $p->add_field('first_name', $o->first_name);
    $p->add_field('last_name', $o->last_name);
    $p->add_field('address1', $o->address1);
    $p->add_field('address2', $o->address2);
    $p->add_field('city', $o->city);
    $p->add_field('state', $o->state);
    $p->add_field('zip', $o->zip);
    $p->add_field('country', $o->country);
    $p->add_field('address_override', 1);
    $p->add_field('no_shipping', 1);


    // shipping
    $ids = array();
    foreach($items as $item)
      {
	array_push($ids, $item['id']);
      }
    $v = Model::load('ProductVariant');
    $cat_ids = $v->getCategories($ids);
    $cat = Model::load('CategoryItem');

    if($o->country != 'GB')
      {
	$intl = true;
      }
    else
      {
	$intl = false;
      }
    $calc = new ShippingCalculator($c->calcTotal($items), $cat_ids, $cat, sizeof($items), $intl);
    $shipping = $calc->getFee();

    $p->add_field('shipping_1', $shipping);
    $o->shipping = $shipping;
    $o->save(Model::getTable('OrderItem'), array(), 1);

    $i = 1;
    foreach($items as $index => $item)
      {
	$p->add_field('item_name_'.$i, $item['name']);
	$p->add_field('amount_'.$i, $item['price']);
	$p->add_field('item_number_'.$i, $item['id']);
	$p->add_field('quantity_'.$i, $item['qty']);

	$o = explode(', ', $item['options']);
	$pr = explode(', ', $item['properties']);
	foreach($o as $index => $item)
	  {	    
	    $p->add_field('os'.$index.'_'.$i, $o[$index]);
	    $p->add_field('on'.$index.'_'.$i, $pr[$index]);
	  }

	$i++;
      }

    //    $p->add_field('image_url', 'http://'.WEB_ROOT.PUBLIC_DIR.'/img/pier.png');
    $p->add_field('invoice', $invoice_no);
    $p->add_field('no_shipping', 1);
    $p->add_field('currency_code', 'GBP');
        
    //$p->add_field('business', 'dev_1238707777_biz@mikejw.co.uk');
    //$p->add_field('business', 'rbhughes63@yahoo.co.uk');
    
    $p->add_field('return', $interface.'success');
    $p->add_field('notify_url', $interface.'ipn');
    $p->add_field('cancel_return', $interface.'cancel');    

    
    $c->emptyCart();

    $this->presenter->assign('paypal_url', $p->paypal_url);
    $this->presenter->assign('fields', $p->fields);
    //$p->dump_fields();

  }
}
?>