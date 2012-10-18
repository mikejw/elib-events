<?php

// memcache wrapper
// will potentiall support other variable caching systems
namespace ELib;

use ELib\VCache\DriverManager;


class VCache
{
  const DEFAULT_DRIVER = 'memcached';

  private $driver;
  

  public function __construct($host, $port, $driver_name=null)
  {
    $this->driver = DriverManager::load($host, $port, $driver_name);

  }



  public function get($key)
  {
    return $this->driver->get($key);
  }



  public function set($key, $value)
  {
    return $this->driver->set($key, $value);
  }


  public function init()
  {
    
    $this->driver->init();
  }


  


}

?>