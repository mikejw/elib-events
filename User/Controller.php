<?php

namespace ELib\User;
use ELib\EController;
use ELib\Model;
use ELib\Country\Country;
use ELib\Mailer;
use Empathy\Session;


class Controller extends EController
{
  public function default_event()
  {
    $this->redirect('');    
  }

  public function login()
  {
    $this->setTemplate('elib:/login.tpl');

    if(isset($_POST['login']))
    {
      $n = Model::load('UserItem');
      $n->username = $_POST['username'];
      $n->password = $_POST['password'];

      //      $n->sanitize();      
      $n->validateLogin();

      if(!$n->hasValErrors())
	{
	  $user_id = $n->login();
	  if($user_id > 0)
	    {
	      session_regenerate_id();
	      Session::set('user_id', $user_id);
	      $n->id = $user_id;
	      $n->load();
	      
	      if(0 && $n->auth)
		{
		  $this->redirect('admin');
		}
	      else
		{
		  $this->redirect('store');
		}
	    } 
	  else
	    {
	      $n->addValError('Wrong username/password combination.', 'success');
	    }
	}

      if($n->hasValErrors() || $user_id < 1)
	{       
	  $this->presenter->assign('errors', $n->getValErrors());
	  $this->presenter->assign("username", $_POST['username']);
	  $this->presenter->assign("password", $_POST['password']);	
	}
    }
  }
  
  public function logout()
  {    
    if(1 || isset($_POST['logout']))
      {
	$this->sessionDown();
	$this->redirect('');
      }
  }

  public function register()
  {
    if(isset($_POST['submit']))
      {
	$u = Model::load('UserItem');
	$u->username = $_POST['username'];
	$u->email = $_POST['email'];
	$u->validates();
	
	$p = Model::load('UserProfile');
	$p->fullname = $_POST['fullname'];
	$p->validates();


	$s = Model::load('ShippingAddress');

	if($p->fullname != '')
	  {
	    $fullname_arr = explode(' ', $p->fullname);
	    if(sizeof($fullname_arr) > 1)
	      {		
		$s->last_name = $fullname_arr[sizeof($fullname_arr) - 1];
		array_pop($fullname_arr);
		$s->first_name = implode(' ', $fullname_arr);
	      }
	  }

	$s->address1 = $_POST['address1'];
	$s->address2  = $_POST['address2'];
	$s->city = $_POST['city'];
	$s->state = $_POST['state'];
	$s->zip = strtoupper($_POST['zip']);
	$s->country = $_POST['country'];
	$s->validates();
		
	
	if($u->hasValErrors() || $s->hasValErrors() || $p->hasValErrors())
	  {
	    $this->presenter->assign('user', $u);
	    $this->presenter->assign('address', $s);
	    $this->presenter->assign('profile', $p);
	    	    
	    $this->presenter->assign('errors', array_merge($u->getValErrors(), $s->getValErrors(), $p->getValErrors()));
	  }
	else
	  {
	    $password = exec(MAKEPASSWD.' --chars=8');
	    $reg_code = exec(MAKEPASSWD.' --chars=16');

	    $u->password = $password;
	    $u->reg_code = md5($reg_code);
	    $u->auth = 0;
	    $u->active = 0;
	    $u->registered = 'MYSQLTIME';

	    $u->user_profile_id = $p->insert(Model::getTable('UserProfile'), 1, array(), 0);

	    $s->user_id = $u->insert(Model::getTable('UserItem'), 1, array(), 0);

	    $s->insert(Model::getTable('ShippingAddress'), 1, array(), 0);
	    
	    $message = "\nHi ___,\n\n"
	      ."Thanks for registering with ".ELIB_EMAIL_ORGANISATION."\n\nBefore we can let you"
	      ." know your password for using the site, please confirm your email address"
	      ." by clicking the following link:\n\n"
	      ."http://".WEB_ROOT.PUBLIC_DIR."/user/confirm_reg/?code=".$reg_code
	      ."\n\nCheers\n\n";
       	    
	    $r[0]['alias'] = $u->username;
	    $r[0]['address'] = $u->email;

	    $m = new Mailer($r, 'You have been registered with '.ELIB_EMAIL_ORGANISATION, $message, ELIB_EMAIL_FROM);

	    $this->postRegister($s->user_id);

	    $this->redirect('user/thanks/1');
	  }
      }

    $titles = array('Mr', 'Mrs', 'Miss', 'Ms', 'Dr');
    $this->presenter->assign('titles', $titles);
    
    $countries = Country::build();   
    $this->presenter->assign('countries', $countries); 
    $this->presenter->assign('sc', 'GB');
    $this->setTemplate('elib://register.tpl');
  }
  

  protected function postRegister($registration_id)
  {
    //
  }


  public function confirm_reg()
  {
    $reg_code = $_GET['code'];
    $u = Model::load('UserItem');
    $id = $u->findUserForActivation($reg_code);

    if($id > 0)
      {
	$u->id = $id;
	$u->load();
	$password = $u->password;
	$u->password = md5(SALT.$password.SALT);
	$u->active = 1;
	$u->activated = 'MYSQLTIME';
	$u->save(Model::getTable('UserItem'), array(), 0);

	Session::set('user_id',$u->id);

	$message = "\nHi ___,\n\n"
	  ."Thanks for confirming your registration. You can now log in to the ".ELIB_EMAIL_ORGANISATION." website using your username "
	  ." '___' and the password '".$password."'.\n\nCheers\n\n";	  

	$r[0]['alias'] = $u->username;
	$r[0]['address'] = $u->email;

	$m = new Mailer($r, 'Welcome to '.ELIB_EMAIL_ORGANISATION, $message, ELIB_EMAIL_FROM);
	$this->redirect('user/thanks/2');
      }   
    else
      {
	throw new \Exception('Unable to activate user.');
      }
  }

  public function thanks()
  {
    $this->presenter->assign('id', $_GET['id']);
    $this->setTemplate('elib://thanks.tpl');
  }



  


}
?>