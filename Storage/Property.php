<?php

namespace ELib\Storage;
use ELib\Model;
use Empathy\Entity as Entity;

class property extends Entity
{
  const TABLE = 'property';

  public $id;
  public $name;
  
  public function loadForVariant($variant_id)
  {
    $p = array();
    $sql = 'SELECT t1.name as property_name, t2.option_val '
      .' FROM '.Model::getTable('ProductVariantPropertyOption').', '.Model::getTable('Property').' t1 LEFT JOIN '
      .' '.Model::getTable('PropertyOption').' t2 ON t1.id = t2.property_id WHERE '
      .' t2.id = property_option_id AND product_variant_id = '.$variant_id;
    $error = 'Could not find variant properties.';
    $result = $this->query($sql, $error);
    foreach($result as $row)
      {
	array_push($p, $row);
      }
    return ($p);
  }


  public function getAllWithOptions($props)
  {
    if(sizeof($props) > 0)
      {
	$props_string = '('.implode(',', $props).')';
      }

    $property = array();
    $sql = 'SELECT t1.id, t1.name, t2.id AS option_id, t2.option_val FROM '
      .Model::getTable('Property').' t1 '
      .'LEFT JOIN '.Model::getTable('PropertyOption').' t2 ON t2.property_id = t1.id';
    if(isset($props_string))
      {
	$sql .= ' WHERE t1.id IN'.$props_string;
      }
    $sql .= ' ORDER BY t1.name, t2.option_val';

    $error = 'Could not get all properties and options.';    
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	foreach($result as $row)
	  {
	    $id = $row['id'];
	    if(!isset($property[$id]['name']))
	      {
		$property[$id]['name'] = $row['name'];
	      }
	    if(isset($row['option_id']))
	      {
		$option_id = $row['option_id'];
		$property[$id]['option'][$option_id] = $row['option_val'];
	      }
	  }
      }    
    return $property;
  }

  public function validates()
  {
    if($this->name == '' || !ctype_alnum(str_replace(' ', '', $this->name)))
      {
	$this->addValError('Invalid property name');	
      } 
  }



  /*
  public function loadIndexed()
  {
    $attr = array();
    //    $attr[0] = "None";
    $sql = "SELECT * FROM ".Attribute::$table;  
    $error = "Could not fetch attributes.";
    $result = $this->query($sql, $error);
    while($row = mysql_fetch_array($result))
    {
      $id = $row['id'];
      $attr[$id] = $row['name'];
    }
      
    return $attr;
  }
  */


  public function getAllWithOptionsForProduct($props, $opts)
  {
    if(sizeof($props) > 0)
      {
	$props_string = '('.implode(',', $props).')';
      }

    $property = array();
    $sql = 'SELECT t1.id, t1.name, t2.id AS option_id, t2.option_val FROM '
      .Model::getTable('Property').' t1 '
      .'LEFT JOIN '.Model::getTable('PropertyOption').' t2 ON t2.property_id = t1.id';
    if(isset($props_string))
      {
	$sql .= ' WHERE t1.id IN'.$props_string;
      }
    if($opts != '(0,)')
      {
	$sql .= ' AND t2.id IN'.$opts;
      }
    $sql .= ' ORDER BY t1.name, t2.option_val';

    $error = 'Could not get all properties and options.';    
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	foreach($result as $row)
	  {
	    $id = $row['id'];
	    if(!isset($property[$id]['name']))
	      {
		$property[$id]['name'] = $row['name'];
	      }
	    if(isset($row['option_id']))
	      {
		$option_id = $row['option_id'];
		$property[$id]['option'][$option_id] = $row['option_val'];
	      }
	  }
      }    
    return $property;
  }






}
?>