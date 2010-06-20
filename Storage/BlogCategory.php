<?php

namespace ELib\Storage;
use Empathy\Entity;

class BlogCategory extends Entity
{
  const TABLE = 'blog_category';

  public $id;  
  public $blog_category_id;
  public $label;
  
  public function validates()
  {
    if($this->label == '' || !ctype_alnum(str_replace(' ', '', $this->label)))
      {
	$this->addValError('Invalid label');	
      }       
  }

  
  public function buildTree($current, $tree)
  {     
    $i = 0;   
    $nodes = array();
    $sql = 'SELECT id,label FROM '.BlogCategory::TABLE.' WHERE blog_category_id = '.$current;
    $error = 'Could not get child blog categories.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {	
	foreach($result as $row)
	  {	    
	    $id = $row['id'];	    
	    $nodes[$i]['id'] = $id;
	    $nodes[$i]['banner'] = 0;
	    $nodes[$i]['label'] = $row['label'];	    
	    $nodes[$i]['children'] = $tree->buildTree($id, $tree);
	    $i++;
	  }		
      }

    return $nodes;
  }


  public function getAncestorIDs($id, $ancestors)
  {
    $section_id = 0;
    $sql = 'SELECT blog_category_id FROM '.BlogCategory::TABLE.' WHERE id = '.$id;
    $error = 'Could not get parent id from blog category.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	$row = $result->fetch();
	$blog_category_id = $row['blog_category_id']; 
      }
    if(isset($blog_category_id) && $blog_category_id != 0)
      {
	array_push($ancestors, $blog_category_id);
	$ancestors = $this->getAncestorIDs($blog_category_id, $ancestors);
      }
    return $ancestors;
  }

  public function hasCats($id)
  {
    $cats = 0;
    $sql = 'SELECT id FROM '.BlogCategory::TABLE.' WHERE blog_category_id = '.$id;
    $error = 'Could not check for existing child categories.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	$cats = 1;
      }
    return $cats;
  }
  
}
?>