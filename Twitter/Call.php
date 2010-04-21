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
  private $timeout;
  private $format;

  public function __construct($url, $username, $password, $auth, $signature, $timeout, $format)
  {
    $call_params = array(
    	    'url' => $url,
    	    'username' => $username,
    	    'password' => $password,
    	    'auth' => $auth);
  	  
    $this->format = $format;
    $this->timeout = $timeout;
    $this->signature = $signature;
    $this->timestamp = time();
    $this->cache_dir = DOC_ROOT.'/data/twitter';
    $restore = false;

    if(!$this->checkCache() || $this->checkExpired())
      {	
      	if(!$this->call($call_params))
      	{
      	  $restore = true;	
      	}
      	else
      	{	  
	  if($this->format == 'xml')
	    {
	      $this->xml = simplexml_load_string($this->output);
	      $this->output_arr = $this->objectToArray($this->xml);	
	    }
	  else
	    {
	      $this->output_arr = $this->objectToArray(json_decode($this->output));
	    }
	  $this->writeToCache();
	}
      }
    else
      {
      	$restore = true;      	      
      }
            
      if($restore) // and restore possible?
      {
      	// TODO: need to update timestamp
      	// otherwise will continue to make failed calls
      	// on ever request?
        $this->output_arr = $this->cached;      	      
      }
      
  }

  public function call($call_params)
  {
    $r = new REST($call_params['url'], array(), '', $call_params['username'],
    	    $call_params['password'], $call_params['auth']);       
    if($r->fetch())
    {
      $this->output = $r->getResponse();
    }
    return $r->getSuccess();
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
       $this->timestamp - $this->cached['elib_stamp'] > $this->timeout)
      {
	$expired = true;
      } 
    return $expired;
  }

  public function writeToCache()
  {
    $this->output_arr['elib_stamp'] = $this->timestamp;
    YAML::save($this->output_arr, $this->cache_dir.'/'.$this->signature.'.yml');
  }



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
