<?php

namespace Empathy\Model;
use Empathy\Entity as Entity;

class DataItem extends Entity
{
  public $id;
  public $data_item_id;
  public $section_id;
  public $container_id;
  public $label;
  public $heading;
  public $body;
  public $image;
  public $video;
  public $user_id;
  public $position;
  public $hidden;
  public $meta;
  public $stamp;
  
  
  public static $table = "data_item";
  

  public function isContainer()
  {
    $container = false;
    if($this->heading == '' &&
       $this->body == '' &&
       $this->image == '' &&
       $this->video == '')
      {
	$container = true;
      }
    return $container;
  }  

  public function getSectionData($section_id)
  {
    $ids = array();
    $sql = 'SELECT id FROM '.DataItem::$table.' WHERE section_id = '.$section_id
      .' ORDER BY label';
    $error = 'Could not get data item id based on section id.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	foreach($result as $row)
	  {
	    array_push($ids, $row['id']);
	  }
      }
    return $ids;
  }
  

  public function validates()
  {    
    if($this->label == '' || !ctype_alnum(str_replace(' ', '', $this->label)))
      {
	$this->addValError('Invalid label');	
      }           
  }
  
  public function findLastSection($id)
  {
    $section_id = 0;
    $sql = 'SELECT id,section_id,data_item_id FROM '.DataItem::$table.' WHERE id = '.$id;
    $error = 'Could not find last section.';
    
    $result = $this->query($sql, $error);
    $row = $result->fetch();
    if(!is_numeric($row['section_id']))
      {
	$section_id = $this->findLastSection($row['data_item_id']);
      }
    else
      {
	$section_id = $row['section_id'];
      }
    return $section_id;
  }


  public function getAncestorIDs($id, $ancestors)
  {
    $data_item_id = 0;
    $sql = 'SELECT data_item_id FROM '.DataItem::$table.' WHERE id = '.$id;
    $error = 'Could not get parent id.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	$row = $result->fetch();
	$data_item_id = $row['data_item_id']; 
      }
    if($data_item_id != 0)
      {
	array_push($ancestors, $data_item_id);
	$ancestors = $this->getAncestorIDs($data_item_id, $ancestors);
      }
    return $ancestors;
  }

  public function buildDelete($id, &$ids, $section_start)
  {
    if($section_start)
      {
	$sql = 'SELECT id FROM '.DataItem::$table.' WHERE section_id = '.$id;
      }
    else
      {
	$sql = 'SELECT id FROM '.DataItem::$table.' WHERE data_item_id = '.$id;
	array_push($ids, $id);
      }
    $error = 'Could not find data items for deletion.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {				
	foreach($result as $row)
	  {	    
	    $this->buildDelete($row['id'], $ids, 0);
	  }
      }   
  }

  public function doDelete($ids)
  {
    $sql = 'DELETE FROM '.DataItem::$table.' WHERE id IN'.$ids;
    $error = 'Could not remove data item(s).';
    $this->query($sql, $error);
  }

  public function buildTree($current, $tree)
  {     
    $i = 0;
    $nodes = array();
    $sql = 'SELECT id,label FROM '.DataItem::$table.' WHERE data_item_id = '.$current
      .' ORDER BY id';
    $error = 'Could not get child data items.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {			
	foreach($result as $row)
	  {	    
	    $id = $row['id'];	    
	    $nodes[$i]['id'] = $id;
	    $nodes[$i]['data'] = 1;
	    $nodes[$i]['label'] = $row['label'];	    
	    $nodes[$i]['children'] = $tree->buildTree($id, 0, $tree);
	    $i++;
	  }		
      }
    
    return $nodes;   
  }

  public function getImageFilenames($ids)
  {
    $images = array();
    $sql = 'SELECT image FROM '.DataItem::$table.' WHERE image IS NOT NULL'
      .' AND id IN'.$ids;
    $error = 'Could not get matching data item image filenames.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	foreach($result as $row)
	  {
	    array_push($images, $row['image']);
	  }
      }
    return $images;    
  }
  
  public function getVideoFilenames($ids)
  {
    $videos = array();
    $sql = 'SELECT video FROM '.DataItem::$table.' WHERE video IS NOT NULL'
      .' AND id IN'.$ids;
    $error = 'Could not get matching data item video filenames.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	foreach($result as $row)
	  {
	    array_push($videos, $row['video']);
	  }
      }
    return $videos;    
  }

  public function getMostRecentVideoID()
  // ammended to perform search by position value
  {
    $id = 0;
    $sql = 'SELECT id FROM '.DataItem::$table.' WHERE video IS NOT NULL ORDER BY position LIMIT 0,1';
    $error = 'Could not get most recent video.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	$row = $result->fetch();
      }
    $id = $row['id'];
    return $id;
  }
    
}
?>