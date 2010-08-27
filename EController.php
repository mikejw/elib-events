<?php

namespace ELib;
use ELib\User\CurrentUser;
use Empathy\Controller\CustomController;

class EController extends CustomController
{	
  public function __construct($boot)
  {
    parent::__construct($boot);  

    CurrentUser::detectUser($this);

    $this->assignELibTemplateDir();	
  }

  public function assignELibTemplateDir()
  {
    $this->assign('elibtpl', Util::getLocation().'/tpl');
  }

}
?>