<?php

namespace ELib;

class YAML
{ 
  public static function save($data, $file)
  {
    $s = new \spyc();
    $yaml = $s->YAMLDump($data, 4, 60);
    $fh = fopen($file, "w");
    fwrite($fh, $yaml);
    fclose($fh);   
  }

  public static function load($file)
  {
    $s = new \spyc();
    return $s->YAMLLoad($file);
  }
}
?>
