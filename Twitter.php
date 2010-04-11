<?php

namespace ELib;
use ELib\Twitter\Call;

class Twitter
{
  private $username;
  private $password;
  private $format;
  private $calls;

  public function __construct($username, $password, $format='XML')
  {
    $this->username = $username;
    $this->password = $password;
    $this->initCalls();

    $s = new \spyc();
    $yaml = $s->YAMLDump($this->calls, 4, 60);
    $fh = fopen(DOC_ROOT.'/logs/twitter_calls.yml', "w");
    fwrite($fh, $yaml);
    fclose($fh);	

    if($format != 'XML')
      {
	die('ELib Twitter library does not support return format other than XML.');
      }
  }

  public function doCall($call, $params=array())
  {
    $call_arr = explode('/', $call);
    $a = $call_arr[0];
    $b = $call_arr[1];
    
    $mycall = $this->calls[$a][$b];
    $url = $mycall['url'].'.xml';
    $c = new Call($url, $this->username, $this->password, true);
  }
  
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