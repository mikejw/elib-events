<?php

namespace ELib\Store;
use ELib\EController;
use ELib\User\CurrentUser;
use ELib\Model;

class VendorController extends EController
{ 
  public function __construct($boot)
  {
    parent::__construct($boot);       
    if(!(CurrentUser::loggedIn() && CurrentUser::isAuthLevel(Access::VENDOR)))
      {
	$this->redirect('');
      }
  }

}
?>