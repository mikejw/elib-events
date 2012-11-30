<?php

namespace Empathy\ELib;

class Mongo
{
    private static $mob;
    
    public static function getInstance()
    {

        if(self::$mob === null) {
            self::$mob = new Mongo\Instance();
        }

        return self::$mob;
    }
    
}
