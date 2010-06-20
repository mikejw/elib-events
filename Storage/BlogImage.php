<?php

namespace ELib\Storage;
use Empathy\Entity;

class BlogImage extends Entity
{
  const TABLE = 'blog_image';

  public $id;
  public $blog_id;
  public $filename;


  public function getForIDs($ids)
  {
    $images = array();
    $i= 0;
    foreach($ids as $item)
      {
	$sql = 'SELECT * FROM '.BlogImage::TABLE.' WHERE blog_id = '.$item
	  .' ORDER BY id';
	$error = 'Could not get blog images.';
	$result = $this->query($sql, $error);
	if($result->rowCount() > 0)
	  {
	    foreach($result as $row)
	      {
		$images[$item][$i] = $row;
		$i++;
	      }
	  }
      }

    return $images;
  }


}
?>