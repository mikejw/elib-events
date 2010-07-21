<?php

namespace ELib\Queue;

class Worker
{
  const DEF_MEM_LIMIT = 10000000;
  const DEF_SLEEP_INTERVAL = 100;
 
  private $name;
  private $driver;
  private $memory_limit;
  private $sleep_interval;

  public function __construct($name, $host, $display_log = null,
			      $driver_name = null,			      
			      $memory_limit = null,
			      $sleep_interval = null)
  {
    $this->display_log = ($display_log === true)? true: false;
    $this->memory_limit = ($memory_limit === null)? self::DEF_MEM_LIMIT: $memory_limit;
    $this->sleep_interval = ($sleep_interval === null)? self::DEF_SLEEP_INTERVAL: $memory_limit;
    $this->name = $name;
    $this->driver = DriverManager::load($host, $driver_name);
  }

  public function log($txt)
  {
    if($this->display_log)
      {
	echo $txt."\n";
      }
    else
      {
	file_put_contents(DOC_ROOT.'/logs/worker_'.$this->name.'.txt', $txt."\n", FILE_APPEND);
      }
  }

  public function nextJob($tube = 'default')
  {
    $this->log("running...");    
    $job = $this->driver->getNext($tube);

    $this->log($job->getSerialized());

    return $job;
  }

  public function removeJob()
  {
    $this->driver->clear();
    $this->checkMemory();
    $this->sleep();
  }

  public function sleep()
  {    
    usleep($this->sleep_interval);
  }

  public function checkMemory()
  {
    $memory = memory_get_usage();
    $this->log('Memory usage:' . $memory);    

    $this->log('Memory limit: '.$this->memory_limit);
    
    if($memory > $this->memory_limit)
      {
	$this->log('Exiting run due to memory limit.');
	exit();
      }
  }


}
?>