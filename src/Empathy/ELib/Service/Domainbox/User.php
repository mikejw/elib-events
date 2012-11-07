<?php

namespace Empathy\ELib\Service\Domainbox;

class User
{
    private $reseller;
    private $username;
    private $password;

    public function __construct(
        $reseller, $username, $password)
    {
        $this->reseller = $reseller;
        $this->username = $username;
        $this->password = $password;

        //    print_r($this);
        //exit();

    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __call($name, $args)
    {
        if (strpos($name, 'get') === 0) {
            $param = strtolower(substr($name, 3));
        }

        return $this->$param;
    }

}
