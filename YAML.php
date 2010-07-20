<?php

namespace ELib;

class YAML
{ 
  public static function save($data, $file)
  {
    $s = new \spyc();    
    $yaml = self::dump($data);
    $fh = fopen($file, "w");
    fwrite($fh, $yaml);
    fclose($fh);   
  }

  public static function load($file)
  {
    $s = new \spyc();
    return $s->YAMLLoad($file);
  }

  
  public static function dump($data)
  {
    $s = new \spyc();
    return $s->YAMLDump($data, 4, 60);
  }


  public static function loadString($data)
  {
    $s = new \spyc();
    return $s->YAMLLoadString($data);
  }

}
?>
