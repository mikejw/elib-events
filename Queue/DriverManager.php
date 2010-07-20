<?php

namespace ELib\Queue;

class DriverManager
{  
  const DEF_D = 'pheanstalk'; 

  public static function load($h, $name = null)
  {
    $driver = null;

    if($name === null)
      {
	$name = self::DEF_D;
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

