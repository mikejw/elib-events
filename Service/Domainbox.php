<?php

namespace ELib\Service;


class Domainbox
{
  private $service_def;
  private $client;
  private $mode;
  private $user;

  private $available;


  public function __construct($domain)
  { 
    if(ELIB_DOMAINBOX_LIVE_MODE)
      {
	$this->mode = 'live';
	$password = ELIB_DOMAINBOX_LIVE_PASS;
      }
    else
      {
	$this->mode = 'sandbox';
	$password = ELIB_DOMAINBOX_SANDBOX_PASS;  	 
      }
    
    $this->user = new Domainbox\User(ELIB_DOMAINBOX_RESELLER,
				     ELIB_DOMAINBOX_USERNAME,
				     $password);  
 
    $this->service_def = 'https://'.$this->mode.'.domainbox.net/?WSDL';
    
    $this->client = new \SoapClient($this->service_def,
				    array('exceptions' => 1, 'soap_version' => SOAP_1_2,
					  'location' => 'https://'.$this->mode.'.domainbox.net',
					  'trace' => true));  		
    
    $result = $this->client->
      CheckDomainAvailability(
			      array( 					
				    'AuthenticationParameters'
				    => array(
					     'Reseller' => $this->user->getReseller(),
					     'Username' => $this->user->getUsername(),
					     'Password' => $this->user->getPassword()),								
				    'CommandParameters'
				    => array(
					     'DomainName' => $domain,
					     'LaunchPhase' => 'GA')
									));					 
   
    $this->available = $result->CheckDomainAvailabilityResult->AvailabilityStatus; 
    


    //echo header('Content-type: text/xml');
    // echo $this->client->__getLastResponse();
    //exit();
    
    //echo header('Content-type: text/xml');
    //echo $this->client->__getLastRequest();
    //exit();
    
  }

  public function getAvailable()
  {
    return $this->available;
  }


}


?>