<?php

namespace ELib\Storage;

use ELib\Model;
use Empathy\Entity;

class TagItem extends Entity
{
  const TABLE = 'tag';

  public $id;
  public $tag;

  public function getIds($tags, $locked)
  {
    $table = Model::getTable('TagItem');
    $ids = array();
    $i = 0;
    foreach($tags as $tag)
      {
	$sql = 'SELECT id FROM '.$table.' WHERE tag = \''.$tag.'\'';
	$error = 'Could not check for tag id.';
	$result = $this->query($sql, $error);
	if($result->rowCount() == 1)
	  {
	    $row = $result->fetch();
	    $id = $row['id'];
	    $ids[$i] = $id;
	  }
	elseif(!($locked))
	  {
	    $sql = 'INSERT INTO '.$table.' VALUES(NULL, \''.$tag.'\')';
	    $error = 'Could not insert tag.';
	    $result = $this->query($sql, $error);
	    $ids[$i] = $this->insertId();
	  }
	$i++;
      }
    return $ids;
  }


  public function getAllTags()
  {
    $total = 0;  
    $sql = 'SELECT COUNT(b.blog_id) AS count FROM '.Model::getTable('BlogTag').' b,'
      .Model::getTable('BlogItem').' c WHERE c.id = b.blog_id AND c.status = 2';
    $error = 'Could not get total number of tagging instances';
    $result = $this->query($sql, $error);
    $row = $result->fetch();
    $total = $row['count'];
    
    $tag = array();   
    $sql = 'SELECT t.tag, COUNT(b.blog_id) AS count FROM '.Model::getTable('BlogItem').' c, '.Model::getTable('TagItem').' t LEFT JOIN '.Model::getTable('BlogTag')
      .' b ON (b.tag_id = t.id) WHERE c.status = 2 AND b.blog_id = c.id GROUP BY t.id';
    $error = 'Could not get all active tags';
    $result = $this->query($sql, $error);
    $i = 0;
    foreach($result as $row)
      {
	$tag[$i] = $row;
	$share = ceil(100 / $total * $tag[$i]['count']);
	if($share < 10)
	  {
	    $share = '0'.$share;
	  }
	elseif($share > 99)
	  {
	    $share = 99;
	  }
	$tag[$i]['share'] = $share;
	$i++;
      }
    return $tag;
  }


  public function cleanup()
  {
    $current = array();
    $sql = 'SELECT DISTINCT b.tag_id FROM '.Model::getTable('BlogTag').' b';
    $error = 'Could not get all current tag ids.';
    $result = $this->query($sql, $error);

    $i = 0;
    foreach($result as $row)
      {
	$current[$i] = $row['tag_id'];
	$i++;
      }

    $stored = array();
    $sql = 'SELECT t.id FROM '.Model::getTable('TagItem').' t';
    $error = 'Could not get all tag ids';
    $result = $this->query($sql, $error);
    $i = 0;
    foreach($result as $row)
      {
	$stored[$i] = $row['id'];
	$i++;
      }

    $dumped = '(0';

    foreach($stored as $item)
      {
	if(!in_array($item, $current))
	  {
	    $dumped .= ','.$item;
	  }
      }

    $dumped .= ')';

    if($dumped != '(0)')
      {
	$sql = 'DELETE FROM '.Model::getTable('TagItem').' WHERE id IN'.$dumped;
	$error = 'Could not remove redundant tags.';
	$this->query($sql, $error);
      }   
  }

}
?>