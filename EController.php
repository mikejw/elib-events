<?php

namespace ELib;
use Empathy\Controller\CustomController;

class EController extends CustomController
{	
  public function __construct($boot)
  {
    parent::__construct($boot);  
    $this->assignELibTemplateDir();	
  }

  public function assignELibTemplateDir()
  {
    $this->assign('elibtpl', Util::getLocation().'/tpl');
  }

}
?>