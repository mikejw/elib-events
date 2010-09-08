<?php

namespace ELib\Store;
use ELib\Model;

class VendorsController extends AdminController
{ 

  public function default_event()
  {   
    if(isset($_POST['verify']))
      {
	$v = Model::load('Vendor');
	$v->id = $_POST['vendor_id'];
	$v->load();

	$u = Model::load('UserItem');
	$u->id = $v->user_id;
	$u->load();
	
	if($u->active && $v->name != '')
	  {
	    $v->verified = 'DEFAULT';
	    $v->save(Model::getTable('Vendor'), array(), 2);	   
	  }
	$this->redirect('admin/vendors');
      }
    else
      {
	$v = Model::load('Vendor');
	$select = '*,UNIX_TIMESTAMP(registered) AS registered, t2.id as vendor_id';
	$t1 = Model::getTable('UserItem');
	$t2 = Model::getTable('Vendor');
	$t3 = Model::getTable('ShippingAddress');
	$sql = ' WHERE t1.id = t2.user_id AND t1.id = t3.user_id';
	$page = 1;
	$per_page = 10;
	
	$vendors = $v->getAllCustomPaginateMultiJoin($select, $t1, $t2, $t3, $sql, $page, $per_page);
	$paginate = $v->getPaginatePagesMultiJoin($select, $t1, $t2, $t3, $sql, $page, $per_page);
	
	$this->assign('vendors', $vendors);
	$this->assign('paginate', $paginate);
	
	$this->setTemplate('elib://admin/vendors.tpl');
      }
  }

  

}
?>