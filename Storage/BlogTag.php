<?php

namespace Empathy\Model;
use Empathy\Entity as Entity;

class BlogTag extends Entity
{
  public $blog_id;
  public $tag_id;


  public static $table = 'blog_tag';


  public function removeAll($blog_id)
  {
    $table = $this->appendPrefix(self::$table);
    $sql = 'DELETE FROM '.$table.' WHERE blog_id = '.$blog_id;
    $error = 'Could not clear existing tags for blog item.';
    $this->query($sql, $error);
  }

  public function getTags($blog_id)
  {
    $tags = array();
    $sql = 'SELECT t.tag FROM '.$this->appendPrefix(TagItem::$table).' t, '
      .$this->appendPrefix(BlogTag::$table).' b WHERE t.id = b.tag_id AND b.blog_id = '.$blog_id;
    $error = 'Could not get tags.';
    $result = $this->query($sql, $error);
    $i = 0;
    foreach($result as $row)
      {
	$tags[$i] = $row['tag'];
	$i++;
      }
    return $tags;
  }
  
  public function getBlogs($tags)
  {    
    $id = array();
    $sql = 'SELECT DISTINCT b.id FROM '.$this->appendPrefix(BlogItem::$table).' b';
    $i = 0;
    foreach($tags as $tag)
      {
	$glue = 't'.($i + 1);
	$sql .= ' LEFT JOIN '.$this->appendPrefix(BlogTag::$table).' '.$glue.' ON '.$glue.'.tag_id = '.$tag;
	$i++;
      }
    $i = 0;
    foreach($tags as $tag)
      {
	$glue = 't'.($i + 1);
	if($i == 0)
	  {
	    $sql .= ' WHERE';
	  }
	else
	  {
	    $sql .= ' AND';
	  }
	$sql .= ' b.id = '.$glue.'.blog_id';
	$i++;
      }
    
    $error = 'Could not get active blog ids.';
    $result = $this->query($sql, $error);
    $i = 0;
    foreach($result as $row)
      {
	$id[$i] = $row['id'];
	$i++;
      }
    return $id;
  }
}



?>