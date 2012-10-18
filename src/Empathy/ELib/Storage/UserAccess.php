<?php

namespace ELib\Storage;

class UserAccess
{
  const REGULAR = 0;
  const LOGGED_IN = 1;
  const ADMIN = 2;
  const SUPER_ADMIN = 3;

  public function getLevel($name)
  {
    $c = get_class($this);               
    $level = @constant($c.'::'.strtoupper($name));
    if($level === null)
      {
	throw new \Exception('Use of invalid access level');
      }    
    return $level;
  }

}
?>