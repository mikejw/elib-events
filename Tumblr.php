<?php

namespace ELib;
use ELib\Tumblr\Call;
use ELib\YAML;

class Tumblr
{
  private $username;
  private $password;
  private $format;
  private $calls;
  private $calls_yaml;
  private $timeout;

  public function __construct($username, $format='XML', $timeout=600, $password=null)
  {
    $this->calls_yaml = dirname(__FILE__).'/Tumblr/tumblr_calls.yml';
    $this->username = $username;
    $this->password = $password;
    $this->timeout = $timeout;

    //$this->initCalls();
    $this->initCallsFromYaml();

    //$this->saveCalls();

    if($format != 'XML')
      {
	die('ELib Tumblr library does not support return format other than XML.');
      }
  }

  public function saveCalls()
  {
    YAML::save($this->calls, $this->calls_yaml);
  }

  public function doCall($call, $params=array(), $raw=false)
  {    
    $call_arr = explode('/', $call);
    
    $i = 0;
    $level = $this->calls;
    while($i < sizeof($call_arr))
    {
      $new_index = $call_arr[$i];
      $level = $level[$new_index];
      $i++;
    }
    
//    $a = $call_arr[0];
//    $b = $call_arr[1];
    $signature = $this->genCallSignature($call_arr, $params);
    $auth = false;

    $mycall = $level;    
    
//    print_r($mycall);
  //  exit();
    
  //  $mycall = $this->calls[$a][$b];
    if(!isset($mycall['url']))
      {
	die('Twitter error (ELib). Call: '.$call.' not found!');
      }

    if($mycall['auth'] === true)
      {
	$auth = true;
      }
    
    if(isset($mycall['format']))
      {
	$format = $mycall['format'];
      }
    else
      {
	$format = 'xml';
      }

    //    $url = $mycall['url'].'.'.$format;
    $url = $mycall['url'];

    // find params within the url
    foreach($params as $index => $value)
      {
	$pattern = '/\{'.$index.'\}/';
	$url = preg_replace($pattern, $value, $url);
      }

    $param_string = '';
    $i = 0;
    foreach($params as $index => $value)
      {
	if($i == 0)
	  {
	    $param_string .= '?';
	  }
	else
	  {
	    $param_string .= '&';
	  }
	$param_string .= $index.'='.$value;
	$i++;
      }


    // do not add any params to the end of request
    if(0)
      {
	$url .= $param_string;
      }
        
    $c = new Call($url, $this->username, $this->password, $auth, $signature, $this->timeout, $format);
    if($raw)
      {
	return $c->getOutput();
      }
    else
      {
	//return $c->getXML();
	return $c->getOutputArray();
      }
  }
  
  public function genCallSignature($call_arr, $params)
  {
    ksort($params);
    return implode('-', $call_arr).implode('-', $params);
  }

  public function initCallsFromYaml()
  {
    $this->calls = YAML::load($this->calls_yaml);
  }

  // deprecated
  public function initCalls()
  {
    $this->calls = array(
			 'api' => array(
					'read'
					=> array(
						 'url' => 'http://{username}.tumblr.com/api/read',
						 'auth' => false,
						 'required_params' => array('username'))
					));		    
  }
}
?>