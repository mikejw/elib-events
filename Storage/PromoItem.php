<?php

namespace ELib\Storage;
use ELib\Model;
use Empathy\Entity as Entity;

class PromoItem extends Entity
{
  const TABLE = 'promo';

  public $id;
  public $category_id;
  public $name;
  public $alt;
  public $url;
  public $image;
  public $hidden;
  

  public function validates()
  {
    if($this->url == '')
      {
	$this->addValError('Invalid URL');	
      }       
    if($this->name == '')
      {
	$this->addValError('Invliad name.');
      }
  }
  
  
}
?>