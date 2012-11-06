<?php

namespace Empathy\ELib;

use Empathy\ELib\User\CurrentUser,
    Empathy\MVC\Controller\CustomController;


class EController extends CustomController
{
    public function __construct($boot)
    {
        parent::__construct($boot);

        CurrentUser::detectUser($this);

        $this->assignELibTemplateDir();
    }

    private function assignELibTemplateDir()
    {
        $this->assign('elibtpl', Util::getLocation().'/tpl');
    }

}
