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
  private $body_s;
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
    $this->body_s = $data;
  }

  public function getBody()
  {
    return $this->body;
  }
  
  public function serialize()
  {
    $this->body_s = YAML::dump($this->body);
  }

  public function getSerialized()
  {
    return $this->body_s;
  }

  public function deserialize()
  {
    $this->body = YAML::loadString($this->body_s);   
  }

}
?>