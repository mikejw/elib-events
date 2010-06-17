<?php

namespace Empathy\Model;
use Empathy\Entity as Entity;

class ContainerImageSize extends Entity
{
  public $container_id;
  public $image_size_id;
  
  public static $table = 'container_image_size';


  public function getImageSizes($container_id)
  {
    $sizes = array();
    $sql = 'SELECT prefix, width, height FROM '.ImageSize::$table.' i, '
      .ContainerImageSize::$table.' c WHERE c.image_size_id = i.id'
      .' AND c.container_id = '.$container_id;
    $error = 'Could not get image sizes for container.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	foreach($result as $row)
	  {
	    array_push($sizes, array($row['prefix'].'_', $row['width'], $row['height']));
	  }	
      }
    return $sizes;
  }
  
  public function getContainerPrefixes($container_id)
  {
    $prefix = array();
    $sql = 'SELECT prefix FROM '.ImageSize::$table.' i, '
      .ContainerImageSize::$table.' c WHERE c.image_size_id = i.id'
      .' AND c.container_id = '.$container_id;
    $error = 'Could not get image sizes for container.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	foreach($result as $row)
	  {
	    array_push($prefix, $row['prefix'].'_');
	  }	
      }
    return $prefix;
  }


}
?>