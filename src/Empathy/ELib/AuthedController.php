<?php

namespace ELib;
use ELib\User\CurrentUser;
use ELib\Model;

/*
user has logged in to be here...
*/

class AuthedController extends EController
{ 
  public function __construct($boot)
  {
    parent::__construct($boot);
    if(!CurrentUser::loggedIn())
      {
	$this->authFailed();
      }
  }

  protected function authFailed()
  {
    $this->redirect('');
  }
  
  

}
?>