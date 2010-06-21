<?php

namespace ELib\Admin;
use ELib\AdminController;
use ELib\Model;

use Empathy\Session;

class Controller extends AdminController
{ 
  public function default_event()
  {        
    $this->setTemplate('elib:/admin/admin.tpl');
  }

  public function password()
  {
    $this->setTemplate('elib:/admin/password.tpl');
    if(isset($_POST['submit']))
      {
	$errors = array();
	$old_password = md5(SALT.$_POST['old_password'].SALT);
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	
	$u = Model::load('UserItem');
	$u->id = Session::get('user_id');
	$u->load();

	if($old_password != $u->password)
	  {
	    array_push($errors, 'The existing password you have entered is not correct');
	  }

	if($password1 != $password2)
	  {
	    array_push($errors, 'The new password entered does not match the confirmation');
	  }
	
	if(!ctype_alnum($password1) || !ctype_alnum($password2))
	  {
	    array_push($errors, 'Please only use alpha and numeric characters for new passwords');
	  }

	if(sizeof($errors) < 1)
	  {
	    $u->password = md5(SALT.$password1.SALT);
	    $u->save(Model::getTable('UserItem'), array(), 0);
	    $this->redirect('admin');
	  }
	else
	  {
	    $this->presenter->assign('error', $errors);
	  }
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin');
      }
  }


  public function toggle_help()
  {
    $help_shown = Session::get('help_shown');
    if($help_shown)
      {
	Session::set('help_shown', false);
      }
    else
      {
	Session::set('help_shown', true);
      }
    echo json_encode(1);
    exit();
  }


}
?>