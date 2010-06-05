<?php

namespace ELib\User;
use ELib\EController;

use Empathy\Model\User as User;

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
      $n = new User($this);
      $n->username = $_POST['username'];
      $n->password = $_POST['password'];
      $n->sanitize();
      
      if(($_SESSION['user_id'] = $n->login()) > 0)
      {
	$n->id = $_SESSION['user_id'];
	$n->load(User::$table);

	if($n->auth)
	  {
	    $this->redirect('admin');
	  }
	else
	  {
	    $this->redirect('');
	  }
      }                  
      else
      {
	$this->presenter->assign('errors', array('Invalid login.'));
	$this->presenter->assign("username", $_POST['username']);
	$this->presenter->assign("password", $_POST['password']);	
      }
    }
  }
  
  public function logout()
  {    
    if(isset($_POST['logout']))
      {
	//$u = new Users($this);
	//$u->logout($this);      
	$this->sessionDown();
	$this->redirect('');
      }
  }
  
  public function register()
  {
    if(isset($_POST['submit']))
      {
	$u = new User($this);
	$u->username = $_POST['username'];
	$u->email = $_POST['email'];
	$u->validates();
	
	if($u->hasValErrors())
	  {
	    $this->presenter->assign('user', $u);
	    $this->presenter->assign('errors', $u->getValErrors());
	  }
	else
	  {
	    $password = exec('/usr/bin/makepasswd --chars=8');
	    $reg_code = exec('/usr/bin/makepasswd --chars=16');

	    $u->password = $password;
	    $u->reg_code = md5($reg_code);
	    $u->auth = 0;
	    $u->active = 0;
	    
	    $u->insert(User::$table, 1, array(), 0);
	    
	    $message = "\nHi ___,\n\n"
	      ."Thanks for registering.  I'll be your electronic go-between. Before I can let you"
	      ." know your password for using the Proper Bike Co website please confirm your registration"
	      ." by clicking the following link:\n\n"
	      ."http://".WEB_ROOT.PUBLIC_DIR."/misc/confirm_reg/?code=".$reg_code
	      ."\n\nI'll look forward to bumping into you soon. Cheers.\n\n"
	      ."- TheProperBot";
       	    
	    $r[0]['alias'] = $u->username;
	    $r[0]['address'] = $u->email;

	    $m = new Mailer($r, 'You have been registered', $message);
	    $this->redirect('misc/thanks/1');
	  }
      }
    $this->templateFile = "register.tpl";
  }
  
  public function confirm_reg()
  {
    $reg_code = $_GET['code'];
    $u = new User($this);
    $id = $u->findUserForActivation($reg_code);

    if($id > 0)
      {
	$u->id = $id;
	$u->load(User::$table);
	$password = $u->password;
	$u->password = md5(SALT.$password.SALT);
	$u->active = 1;
	$u->save(User::$table, array(), 0);

	$message = "\nHi ___,\n\n"
	  ."Thanks for confirming your registration.  You can now log in to the Proper Bike Co website using your username "
	  ." '___' and your password '".$password."'."	 
	  ."\n\nI'll look forward to bumping into you soon. Cheers.\n\n"
	  ."- TheProperBot";

	$r[0]['alias'] = $u->username;
	$r[0]['address'] = $u->email;

	$m = new Mailer($r, 'Welcome to Proper Bike Co', $message);
	$this->redirect('misc/thanks/2');
      }   
  }

  public function thanks()
  {
    $this->presenter->assign('id', $_GET['id']);
    $this->templateFile = 'thanks.tpl';
  }


}
?>