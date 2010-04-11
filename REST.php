<?php

namespace ELib;

class REST extends Curl
{ 

  
  
  public function configure()
  {
    curl_setopt($this->ch, CURLOPT_URL, $this->url);
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
  }


}
?>