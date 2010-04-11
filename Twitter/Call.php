<?php

namespace ELib\Twitter;
use ELib\REST;

class Call
{
  private $url;  
  private $username;
  private $call;
  private $auth;
  private $xml; 
  private $ouput;

  public function __construct($url, $username, $password, $auth)
  {
    if($this->checkCache())
      {		
	if($this->checkExpired())
	  {
	    $r = new REST($url, array(), '', $username, $password);			
	    $r->fetch();
	    $this->output = $r->getResponse();
	    $this->xml = simplexml_load_string($this->output);

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
	    $tweet = $data['tweet'];
	  }
      }

    if(isset($tweet))
      {
	print_r($tweet);
	//$this->presenter->assign('twitter', $tweet);
      }
  }

  public function getOutput()
  {
    return $this->output;
  }

  public function getXML()
  {
    return $this->xml;
  }

  public function checkCache()
  {
    //    $s = new \spyc();
    //$data = $s->YAMLLoad(DOC_ROOT.'/logs/twitter.yml');
    //    if(isset($data['stamp']) && is_numeric($data['stamp'])
    //{
	// blah
    //}

    return 1;
  }

  public function checkExpired()
  {
    //$now = time();
    //if($now - $data['stamp'] > 600)	
    return 1;
  }

  public function writeToCache()
  {

    /*
$data['stamp'] = $now;			    
	    $yaml = $s->YAMLDump($data, 4, 60);
	    $fh = fopen(DOC_ROOT.'/logs/twitter.yml', "w");
	    fwrite($fh, $yaml);
	    fclose($fh);	   
	    */
  }


  //  public function 



}
?>