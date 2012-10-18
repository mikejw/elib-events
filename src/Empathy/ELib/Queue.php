<?php

namespace ELib;
use ELib\Queue\DriverManager;
use ELib\Queue\Job;
use ELib\Queue\Stats;

class Queue
{  
  const DEFAULT_DRIVER = 'pheanstalk'; 

  private $driver;
  private $tube;
  
  public function __construct($host, $tube = null, $driver_name = null)
  {
    $this->tube = $tube;
    $this->driver = DriverManager::load($host, $driver_name);
  }

  public function setTube($tube)
  {
    $this->tube = $tube;
    return $this;
  }

  public function put($job_data)
  {    
    $j = new Job(array($job_data, $this->tube));
    $this->driver->put($j);    
  }
  
  public static function getStats()
  {
    return Stats::retrieve('stats');
  }
  

 

}
?>