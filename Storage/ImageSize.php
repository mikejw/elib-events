<?php

namespace Empathy\Model;
use Empathy\Entity as Entity;

class ImageSize extends Entity
{
  public $id;
  public $name;
  public $prefix;
  public $width;
  public $height;
  
  public static $table = 'image_size';

  public function validates()
  {
    if(!ctype_alnum(str_replace(' ', '', $this->name)))
      {
	$this->addValError('Invalid name');
      }
    if(!ctype_alpha($this->prefix))
      {
	$this->addValError('Invalid prefix');
      }
    if(!is_numeric($this->width))
      {
	$this->addValError('Invalid width');	
      }       
    if(!is_numeric($this->height))
      {
	$this->addValError('Invalid height');	
      }    
  }

  public function getDataFiles()
  {
    $images = array();
    $ids = array();
    $sql = 'SELECT id from '.DataItem::$table.' d,'
      .ContainerImageSize::$table.' c WHERE c.image_size_id = '.$this->id
      .' AND c.container_id = d.container_id';    
    $error = 'Could not get data item containers that are using selected image size.';
    $result = $this->query($sql, $error);
    foreach($result as $row)
      {
	$ids[] = $row['id'];
      }
    
    if(sizeof($ids) > 0)
      {
	$sql = 'SELECT image FROM '.DataItem::$table.' WHERE data_item_id IN'.$this->buildUnionString($ids);
	$error = 'Could not got images matching image size.';
	$result = $this->query($sql, $error);
	foreach($result as $row)
	  {
	    $images[] = $row['image'];
	  }
      }
    return $images;
  }
}
?>