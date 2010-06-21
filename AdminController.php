<?php

namespace ELib;

use ELib\Model;

use Empathy\Model\UserItem as User;
use Empathy\Session;


class AdminController extends EController
{	
  public function __construct($boot)
  {
    parent::__construct($boot);  

    $u = Model::load('UserItem');
           
    $user_id = Session::get('user_id');

    if(is_numeric($user_id) && $user_id > 0)
      {
	$u->id = $user_id;
	$u->load();
	$this->presenter->assign('current_user', $u->username);	
      }
       
    //$u->getAuth($user_id);
    
    if($this->module == "admin" &&
       ($user_id < 1 || !$u->getAuth($user_id)))
      {      
	$this->redirect("user/login");
      }
    else
      {       
	$this->detectHelp();
      }     
  }


  public function detectHelp()
  {
    if(!Session::get('help_shown'))
      {
	Session::set('help_shown', false);
      }

    $this->presenter->assign('help_shown', Session::get('help_shown'));

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