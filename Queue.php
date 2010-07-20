<?php

namespace ELib;
use ELib\Queue\DriverManager;

use ELib\Queue\Job;
use ELib\Queue\Tube;

class Queue
{  
  private $driver;
  
  public function __construct($host, $driver_name = null)
  {
    $this->driver = DriverManager::load($host, $driver_name);
  }

  public function put($job_data, $tube = null)
  {    
    $j = new Job($job_data, $tube);
    $this->driver->put($j, $tube);    
  }

  


}
?>