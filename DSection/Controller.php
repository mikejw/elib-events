<?php

namespace ELib\DSection;

use Empathy\Controller\CustomController;
use Empathy\Model\SectionItem as SectionItem;
use Empathy\Model\DataItem as DataItem;
use Empathy\Model\Container as Container;

use ELib\File\Image as ImageUpload;
use ELib\DSection\SectionsUpdate;
use ELib\DSection\SectionsDelete;
use ELib\DSection\SectionsTree;


class Controller extends CustomController
{   
  // functions that are similar to those in data_item
  public function getDataTypes()
  {
    return array('Heading', 'Body', 'Image', 'Video', 'Container');
  }

  public function add_data()
  {
    $this->buildNav();
    $this->presenter->assign('add_data_menu', 1);

    if(isset($_GET['data_type']) && is_numeric($_GET['data_type'])
       && isset($_GET['add']))
      {
	switch($_GET['data_type'])
	  {
	  case 0:
	    $this->redirect('admin/section/add_data_heading/'.$_GET['id']);
	    break;
	  case 1:
	    $this->redirect('admin/section/add_data_body/'.$_GET['id']);
	    break;
	  case 2:
	    $this->redirect('admin/section/add_data_image/'.$_GET['id']);
	    break;
	  case 3:
	    $this->redirect('admin/section/add_data_video/'.$_GET['id']);
	    break;
	  case 4:
	    $this->addDataContainer();
	    break;
	  default:
	    $this->redirect('admin/section/'.$_GET['id']);
	    break;
	  }      	
      }
    elseif(isset($_GET['cancel']))
      {
	$this->redirect('admin/section/'.$_GET['id']);
      }
    else
      {       
	$s = new SectionItem($this);
	$s->id = $_GET['id'];
	$s->load(SectionItem::$table);
	$this->presenter->assign('section_item', $s);
	$this->presenter->assign('section_item_id', $s->id);
	$this->presenter->assign('data_types', $this->getDataTypes());
	
	$c = new Container($this);
	$containers = $c->getAllCustom('',  Container::$table);
	$containers_arr = array();
	$containers_arr[0] = 'Default';
	foreach($containers as $item)
	  {
	    $id = $item['id'];
	    $containers_arr[$id] = $item['name'];
	  }		
	$this->presenter->assign('container_types', $containers_arr);  
      }
  }

  public function addDataContainer()
  {
    if(isset($_GET['container_type']) && is_numeric($_GET['container_type']))
      {
	$d = new DataItem($this);
	$d->section_id = $_GET['id'];
	if($_GET['container_type'] > 0)
	  {
	    $d->container_id = $_GET['container_type'];
	  }
	$d->label = 'Container';
	$d->position = 'DEFAULT';
	$d->hidden = 'DEFAULT';
	$su = new SectionItem($this);
	$u = new SectionsUpdate($su, $d->section_id);
	$id = $d->insert(DataItem::$table, 1, array(), 0);
      }
    $this->redirect('admin/data_item/'.$id);
  }

  public function add_data_heading()
  {
    if(isset($_POST['save']))
      {
	$d = new DataItem($this);
	$d->label = 'Heading';
	$d->section_id = $_GET['id'];
	$d->heading = $_POST['heading'];
	$d->position = 'DEFAULT';
	$d->hidden = 'DEFAULT';	
	$d->validates();
	if($d->hasValErrors())
	  {
	    $this->presenter->assign('data_item', $d);
	    $this->presenter->assign('errors', $d->getValErrors());	     
	  }
	else
	  {       
	    $su = new SectionItem($this);
	    $u = new SectionsUpdate($su, $d->section_id);
	    $d->insert(DataItem::$table, 1, array(), 1);		
	    $this->redirect('admin/section/'.$d->section_id);
	  }
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/section/'.$_POST['id']);
      }

    $this->buildNav();
    $this->presenter->assign('section_id', $_GET['id']);
  }


  public function add_data_body()
  {
    if(isset($_POST['save']))
      {
	$d = new DataItem($this);
	$d->label = 'Body';
	$d->section_id = $_GET['id'];
	$d->body = $_POST['body'];
	$d->position = 'DEFAULT';
	$d->hidden = 'DEFAULT';	
	$d->validates();
	if($d->hasValErrors())
	  {
	    $this->presenter->assign('data_item', $d);
	    $this->presenter->assign('errors', $d->getValErrors());	     
	  }
	else
	  {
	    $su = new SectionItem($this);
	    $u = new SectionsUpdate($su, $d->section_id);	    
	    $d->insert(DataItem::$table, 1, array(), 1);		
	    $this->redirect('admin/section/'.$d->section_id);
	  }	
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/section/'.$_POST['id']);
      }       

    $this->buildNav();
    $this->presenter->assign('section_id', $_GET['id']);    
  }

  public function add_data_image()
  {
    if(isset($_POST['save']))
      {
	$_GET['id'] = $_POST['id'];
	$u = new ImageUpload('data', true, array());
    
	if($u->error != '')
	  {
	    $this->presenter->assign('error', $u->error);
	  }
	else
	  {
	    $d = new DataItem($this);
	    $d->label = $u->getFileEncoded();
	    $d->section_id = $_GET['id'];
	    $d->image = $u->getFile();
	    $d->position = 'DEFAULT';
	    $d->hidden = 'DEFAULT';
	    $su = new SectionItem($this);
	    $u = new SectionsUpdate($su, $d->section_id);
	    $id = $d->insert(DataItem::$table, 1, array(), 1);		
	    $this->redirect('admin/data_item/'.$id);
	  }      
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/section/'.$_POST['id']);
      }

    $this->buildNav();
    $this->presenter->assign('section_id', $_GET['id']);    
  }
  
 
  public function default_event()
  { 
    
    $ui_array = array('id');
    $this->loadUIVars('ui_section', $ui_array);
    if(!isset($_GET['id']) || $_GET['id'] == '')
      {
	$_GET['id'] = 0;
      }

    $this->buildNav(); 
    $this->presenter->assign('section_id', $_GET['id']);
    

  }


  
  public function assertID()
  {
    if(!isset($_GET['id']) || !is_numeric($_GET['id']))
      {
	$_GET['id'] = 0;
      }
  }

  public function buildNav()
  {
    $this->setTemplate('admin/section.tpl');
    $this->assertID();
    $s = new SectionItem($this);
    $d = new DataItem($this);
    
    if(isset($_GET['collapsed']) && $_GET['collapsed'] == 1)
      {
	$collapsed = 1;
      }
    else
      {
	$collapsed = 0;
      }

    $s->id = $_GET['id'];
    $s->load(SectionItem::$table);       
     
    $st = new SectionsTree($s, $d, 1, $collapsed);
    $this->presenter->assign('sections', $st->getMarkup());
    $this->presenter->assign('section', $s);

    // fake controller
    $this->assign('class', 'section');
  }

  public function add_section()
  {
    if(isset($_GET['id']) && is_numeric($_GET['id']))
      {
	$s = new SectionItem($this);
	$s->section_id = $_GET['id'];
	$s->label = 'New Section';
	$s->template = 'DEFAULT';
	$s->position = 'DEFAULT';
	$s->hidden = 'DEFAULT';
	$s->insert(SectionItem::$table, 1, array(), 0);	
      }
    $this->redirect('admin/section/'.$_GET['id']);
  }


  public function delete()
  {
    $this->assertID();
    $s = new SectionItem($this);
    $d = new DataItem($this);
    $s->id = $_GET['id'];
    $s->load(SectionItem::$table);
    $sd = new SectionsDelete($s, $d, 1);     
    $this->redirect('admin/section/'.$s->section_id);           
  }

  public function rename()
  {
    $this->buildNav();
    if(isset($_POST['save']))
      {
	$s = new SectionItem($this);
	$s->id = $_POST['id'];
	$s->load(SectionItem::$table);
	$s->label = $_POST['label'];
	$s->validates();
	if($s->hasValErrors())
	  {
	    $this->presenter->assign('section', $s);
	    $this->presenter->assign('errors', $s->getValErrors());	     
	  }
	else
	  {
	    $s->save(SectionItem::$table, array(), 1);
	    $su = new SectionItem($this);
	    $u = new SectionsUpdate($su, $s->id);
	    $this->redirect('admin/section/'.$s->id);
	  }
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/section/'.$_POST['id']);
      }
    else
      {
	$s = new SectionItem($this);
	$s->id = $_GET['id'];
	$s->load(SectionItem::$table);
	$this->presenter->assign('section', $s);
      }
  }



  public function change_template()
  {
    $this->buildNav();
    if(isset($_POST['save']))
      {
	$s = new SectionItem($this);
	$s->id = $_POST['id'];
	$s->load(SectionItem::$table);
	$s->template = $_POST['template'];
	$s->validates();
	if($s->hasValErrors())
	  {
	    $this->presenter->assign('section', $s);
	    $this->presenter->assign('errors', $s->getValErrors());	     
	  }
	else
	  {
	    $s->save(SectionItem::$table, array(), 2);
	    $su = new SectionItem($this);
	    $u = new SectionsUpdate($su, $s->id);
	    $this->redirect('admin/section/'.$s->id);
	  }
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/section/'.$_POST['id']);
      }
    else
      {
	$s = new SectionItem($this);
	$s->id = $_GET['id'];
	$s->load(SectionItem::$table);

	$t = array('0' => '0', 'A' => 'A', 'B' => 'B', 'C' => 'C');

	$this->presenter->assign('templates', $t);
	$this->presenter->assign('section', $s);
      }
  }  

  public function toggle_hidden()
  {
    $s = new SectionItem($this);
    $s->id = $_GET['id'];
    $s->load(SectionItem::$table);
    $s->hidden = ($s->hidden)? 0 : 1;
    $s->save(SectionItem::$table, array(), 0);
    $this->redirect('admin/section/'.$s->id);
  }  




  // data item stuff
  public function buildNavData()
  {
    //    $this->setTemplate('admin/data_item.tpl');
    $this->assertID();
    $s = new SectionItem($this);
    $d = new DataItem($this);
    
    $d->id = $_GET['id'];
    $d->load(DataItem::$table);
    $is_section = 0;
    if(isset($_GET['collapsed']) && $_GET['collapsed'] == 1)
      {
	$collapsed = 1;
      }
    else
      {
	$collapsed = 0;
      }
	  
    $st = new SectionsTree($s, $d, 0, $collapsed);
    $this->presenter->assign('sections', $st->getMarkup());
    $this->presenter->assign('data_item', $d);
    $this->presenter->assign('is_container', $d->isContainer());

    // fake controller (for template logic)
    $this->assign('class', 'data_item');
  }


 public function data_item()
  {    
    $ui_array = array('id');
    $this->loadUIVars('ui_data_item', $ui_array);
    if(!isset($_GET['id']) || $_GET['id'] == '')
      {
	$_GET['id'] = 0;
      }

    $this->buildNavData();
    $this->presenter->assign('data_item_id', $_GET['id']);
    $this->setTemplate('admin/section.tpl');
    
    // fake event
    $this->assign('event', 'default_event');
  }


}
?>