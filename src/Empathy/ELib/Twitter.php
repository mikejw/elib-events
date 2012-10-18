<?php

namespace ELib;
use ELib\Twitter\Call;
use ELib\YAML;

class Twitter
{
  private $username;
  private $password;
  private $format;
  private $calls;
  private $calls_yaml;
  private $timeout;

  public function __construct($username, $password, $format='XML', $timeout=600)
  {
    $this->calls_yaml = dirname(__FILE__).'/Twitter/twitter_calls.yml';
    $this->username = $username;
    $this->password = $password;
    $this->timeout = $timeout;

    //$this->initCalls();
    $this->initCallsFromYaml();

    //$this->saveCalls();

    if($format != 'XML')
      {
	die('ELib Twitter library does not support return format other than XML.');
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

    $url = $mycall['url'].'.'.$format;

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
    $url .= $param_string;
        
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
			 'statuses' => array(
					     'public_timeline'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/public_timeline',
						      'auth' => false),
					     'home_timeline'
					     => array(						      
						      'url' => 'http://api.twitter.com/1/statuses/home_timeline',
						      'auth' => true),
					     'friends_timeline'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/friends_timeline',
						      'auth' => true),
					     'user_timeline'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/user_timeline',
						      'auth' => true),
					     'mentions'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/mentions',
						      'auth' => true),
					     'retweeted_by_me'
					     => array(
						     'url' => 'http://api.twitter.com/1/statuses/retweeted_by_me',
						     'auth' => true),
					     'retweeted_to_me'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/retweeted_to_me',
						      'auth' => true),
					     'retweets_of_me'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/retweets_of_me',
						      'auth' => true),
					     //
					     'show'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/show/{id}',
						      'auth' => true,
						      'required_params' => array('id')),
					     'update'
					     => array(
						      'url' => 'http://api.twitter.com/1/users/upadate',
						      'auth' => true),
					     'destroy'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/destroy/{id}',
						      'auth' => true),
					     'retweet'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/retweet/{id}',
						      'auth' => true,
						      'required_params' => array('id')),
					     'retweets'
					     => array(
						      'url' => 'http://api.twitter.com/1/statuses/retweets/{id}',
						      'auth' => true,
						      'required_params' => array('id')),
					     'retweeted_by'
					     => array(
						      'ids' => array(
								     'url' => 'http://api.twitter.com/1/statuses/{id}/retweeted_by/ids',
								     'auth' => true,
								     'required_params' => array('id')))
					     ));					     					     						    
  }
}
?>