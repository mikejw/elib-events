<?php


namespace ELib\Util;
use ELib\YAML;


class SQLLog
{  
  public static function log($data)
  {    
    $queries = YAML::load(DOC_ROOT.'/logs/sql_log');
    $queries[] = $data;
    YAML::save($queries, DOC_ROOT.'/logs/sql_log');   
  }

  

}
?>