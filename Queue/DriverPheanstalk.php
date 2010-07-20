<?php

namespace ELib\Queue;

class DriverPheanstalk extends Driver
{


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


}



?>