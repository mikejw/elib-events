<?php

namespace ELib\Queue;

class DriverManager
{  
  public static function load($h, $name = null)
  {
    $driver = null;

    if($name === null)
      {
	$name = \ELib\Queue::DEFAULT_DRIVER;
      }

    switch($name)
      {
      case 'pheanstalk':
	$driver_name = 'ELib\Queue\Driver'.ucfirst($name);
	$driver = new $driver_name($driver_name);
	
	$driver->load($h);

	break;
      default:
	break;
      }

    return $driver;
  }

}
?>