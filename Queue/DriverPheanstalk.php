<?php

namespace ELib\Queue;
use ELib\Queue\Job;

class DriverPheanstalk extends Driver
{
  protected static $job;

  public function load($h)
  {
    $this->d = new \Pheanstalk($h);
  }

  public function put($job, $tube)
  {
    if($tube === null)
      {
	$tube = 'default';
      }    
    $this->d->useTube($tube)->put($job->getSerialized());
  }

  public function getNext($tube)
  {
    self::$job = $this->d->watch($tube)->ignore('default')->reserve();

    $j = new Job(array(), $tube);
    $j->setBody(self::$job->getData());
    
    $j->deserialize();

    // remove job?
   
    return $j;
  }

  public function clear()
  {
    $this->d->delete(self::$job);
  }


}



?>