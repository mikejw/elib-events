<?php

namespace ELib\Twitter;
use ELib\REST;
use ELib\YAML;

class Call
{
  private $url;  
  private $username;
  private $call;
  private $auth;
  private $xml; 
  private $ouput;
  private $output_arr;
  private $cache_dir;
  private $signature;
  private $timestamp;
  private $cached;

  public function __construct($url, $username, $password, $auth, $signature)
  {
    $this->signature = $signature;
    $this->timestamp = time();
    $this->cache_dir = DOC_ROOT.'/data/twitter';


    if(!$this->checkCache() || $this->checkExpired())
      {
	$r = new REST($url, array(), '', $username, $password);			
	$r->fetch();
	$this->output = $r->getResponse();
	$this->xml = simplexml_load_string($this->output);
	$this->output_arr = $this->objectToArray($this->xml);
	
	/*
	  if(isset($xml->status->text))
	  {
	  $tweet = $xml->status->text;
	  $data['tweet'] = $tweet;
	  }
	*/	   	
	$this->writeToCache();
      }
    else
      {
	$this->output_arr = $this->cached;
      }
      
    /*
    if(isset($tweet))
      {
	print_r($tweet);
	$this->presenter->assign('twitter', $tweet);
      }
    */
  }

  public function getOutput()
  {
    return $this->output;
  }

  public function getXML()
  {
    return $this->xml;
  }

  public function getOutputArray()
  {
    return $this->output_arr;
  }

  public function checkCache()
  {
    $success = false;
    $this->cached = YAML::load($this->cache_dir.'/'.$this->signature.'.yml');
    if(isset($this->cached['elib_stamp']) && is_numeric($this->cached['elib_stamp']))
      {
	$success = true;
      }
      return $success;
  }

  public function checkExpired()
  {
    $expired = false;
    if(isset($this->cached['elib_stamp']) &&
       $this->timestamp - $this->cached['elib_stamp'] > 120)
      {
	$expired = true;
      } 
    return $expired;
  }

  public function writeToCache()
  {
    $this->output_arr['elib_stamp'] = $this->timestamp;
    YAML::save($this->output_arr, $this->cache_dir.'/'.$this->signature.'.yml');

    /*
$data['stamp'] = $now;			    
	    $yaml = $s->YAMLDump($data, 4, 60);
	    $fh = fopen(DOC_ROOT.'/logs/twitter.yml', "w");
	    fwrite($fh, $yaml);
	    fclose($fh);	   
	    */
  }


  //  public function 

  function objectToArray($object)
  {
    if(!is_object( $object ) && !is_array($object))
      {
	return $object;
      }
    if(is_object($object))
      {
	$object = get_object_vars($object);
      }
    return array_map(array($this, 'objectToArray'), $object);
  }



}
?>
