<?php

namespace ELib\Queue;
use ELib\YAML;


class Job
{  
  private $priority;
  private $time_to_run;
  private $delay;
  private $id;
  private $body;
  private $body_flat;
  private $tube;

  public function __construct($body_data, $tube)
  {
    $this->tube = $tube;
    $this->body = $body_data;   
    // set other properties?
    $this->serialize();
  }

  public function setBody($data)
  {
    if(!is_array($data))
      {
	throw new Exception('Job body must be an array');
      }
    else
      {
	$this->body = $data;
      }
  }

  public function serialize()
  {
    //$this->body_flat = YAML::dump($this->body);
    $this->body_flat = json_encode($this->body);
  }

  public function getSerialized()
  {
    return $this->body_flat;
  }


  public function deserialize()
  {
    $this->body = YAML::loadString($body_flat);
  }

  


}
?>

