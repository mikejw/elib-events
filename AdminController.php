<?php

namespace ELib;
use Empathy\Model\User as User;

class AdminController extends EController
{	
  public function __construct($boot)
  {
    parent::__construct($boot);  

    $u = new User($this);
           
    if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && is_numeric($_SESSION['user_id']))
      {
	$u->id = $_SESSION['user_id'];
	$u->load(User::$table);
	$this->presenter->assign('current_user', $u->username);
      }
           
    if($this->module == "admin") // can we (actually) safely assume we are in admin?
      {				
	if((!(isset($_SESSION['user_id']))) || (!($u->getAuth($_SESSION['user_id']))))
	  {
	    $this->redirect("user/login");
	  }	
       
	$this->detectHelp();
      }     
  }


  public function detectHelp()
  {
    if(!isset($_SESSION['help_shown']))
      {
	$_SESSION['help_shown'] = false;
      }

    $this->presenter->assign('help_shown', $_SESSION['help_shown']);

    $help_file = 'admin_help/'.$this->class.'_'.$this->event.'.tpl';
    if(file_exists(DOC_ROOT.'/presentation/'.$help_file)
       || file_exists(Util::getLocation().'/tpl/'.$help_file))
      {
	$help_file = 'elib:/'.$help_file;
        $this->presenter->assign('help_file', $help_file);
      }
  }

}
?>