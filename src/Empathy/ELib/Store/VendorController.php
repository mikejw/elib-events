<?php

namespace Empathy\ELib\Store;

use Empathy\ELib\EController,
    Empathy\ELib\User\CurrentUser;


class VendorController extends EController
{
    public function __construct($boot)
    {
        parent::__construct($boot);
        if (!(CurrentUser::loggedIn() && CurrentUser::isAuthLevel(Access::VENDOR))) {
            $this->redirect('');
        }
    }

}
