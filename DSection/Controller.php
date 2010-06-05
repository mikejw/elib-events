<?php

namespace ELib\DSection;

use ELib\AdminController;
use ELib\File\Image as ImageUpload;
use ELib\DSection\SectionsUpdate;
use ELib\DSection\SectionsDelete;
use ELib\DSection\SectionsTree;

use Empathy\Model\SectionItem as SectionItem;
use Empathy\Model\DataItem as DataItem;
use Empathy\Model\Container as Container;
use Empathy\Model\ImageSize;

class Controller extends AdminController
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
	    $this->redirect('admin/dsection/add_data_heading/'.$_GET['id']);
	    break;
	  case 1:
	    $this->redirect('admin/dsection/add_data_body/'.$_GET['id']);
	    break;
	  case 2:
	    $this->redirect('admin/dsection/add_data_image/'.$_GET['id']);
	    break;
	  case 3:
	    $this->redirect('admin/dsection/add_data_video/'.$_GET['id']);
	    break;
	  case 4:
	    $this->addDataContainer();
	    break;
	  default:
	    $this->redirect('admin/dsection/'.$_GET['id']);
	    break;
	  }      	
      }
    elseif(isset($_GET['cancel']))
      {
	$this->redirect('admin/dsection/'.$_GET['id']);
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
	//	$this->presenter->assign('class', 'section');
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
    $this->redirect('admin/dsection/data_item/'.$id);
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
	    $this->redirect('admin/dsection/'.$d->section_id);
	  }
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection/'.$_POST['id']);
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
	    $this->redirect('admin/dsection/'.$d->section_id);
	  }	
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection/'.$_POST['id']);
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
	    $this->redirect('admin/dsection/data_item/'.$id);
	  }      
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection/'.$_POST['id']);
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
    $this->setTemplate('elib:/admin/section.tpl');
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
    $this->redirect('admin/dsection/'.$_GET['id']);
  }


  public function delete()
  {
    $this->assertID();
    $s = new SectionItem($this);
    $d = new DataItem($this);
    $s->id = $_GET['id'];
    $s->load(SectionItem::$table);
    $sd = new SectionsDelete($s, $d, 1);     
    $this->redirect('admin/dsection/'.$s->section_id);           
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
	    $this->redirect('admin/dsection/'.$s->id);
	  }
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection/'.$_POST['id']);
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
	    $this->redirect('admin/dsection/'.$s->id);
	  }
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection/'.$_POST['id']);
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
    $this->redirect('admin/dsection/'.$s->id);
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
    $this->setTemplate('elib:/admin/section.tpl');
    
    // fake event
    $this->assign('event', 'default_event');
  }

 
  public function delete_data_item()
  {
    $this->assertID();
    $this->setTemplate('section.tpl');
    $s = new SectionItem($this);
    $d = new DataItem($this);
    $d->id = $_GET['id'];
    $d->load(DataItem::$table);
    $this->update_timestamps($d->id);
    $sd = new SectionsDelete($s, $d, 0);  
    if(!is_numeric($d->data_item_id))
      {
	$this->redirect('admin/dsection/'.$d->section_id);       
      }
    else
      {
	$this->redirect('admin/dsection/data_item/'.$d->data_item_id);       
      }
  }


  public function update_timestamps($id)
  {
    $d = new DataItem($this);
    $ancestors = array();
    $ancestors = $d->getAncestorIDs($id, $ancestors);
    
    if(sizeof($ancestors) > 0)
      {
	$d->id = min($ancestors);
      }
    else
      {
	$d->id = $id;
      }
    $d->load(DataItem::$table);
    $u = new SectionsUpdate((new SectionItem($this)), $d->section_id);
  }



  public function rename_data_item()
  {
    if(isset($_POST['save']))
      {
	$d = new DataItem($this);
	$d->id = $_POST['id'];
	$d->load(DataItem::$table);
	$d->label = $_POST['label'];
	$d->validates();
	if($d->hasValErrors())
	  {
	    $this->presenter->assign('data_item', $d);
	    $this->presenter->assign('errors', $d->getValErrors());	     
	  }
	else
	  {
	    $d->save(DataItem::$table, array(), 1);
	    $this->update_timestamps($d->id);
	    $this->redirect('admin/dsection/data_item/'.$d->id);
	  }
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection/data_item/'.$_POST['id']);
      }

    $this->buildNavData();
    $this->setTemplate('elib:/admin/section.tpl');
    $d = new DataItem($this);
    $d->id = $_GET['id'];
    $d->load(DataItem::$table);
    $this->presenter->assign('data_item', $d);        
    $this->assign('event', 'rename');
  }



  public function edit_data_item_meta()
  {
    $this->assign('event', 'edit_meta');
    if(isset($_POST['save']))
      {
	$d = new DataItem($this);
	$d->id = $_POST['id'];
	$d->load(DataItem::$table);
	$d->meta = $_POST['meta'];

	$d->validates();
	//if($d->hasValErrors())
	if(0)
	  {
	    $this->presenter->assign('data_item', $d);
	    $this->presenter->assign('errors', $d->getValErrors());	     
	  }
	else
	  {
	    $d->save(DataItem::$table, array(), 1);
	    $this->update_timestamps($d->id);
	    $this->redirect('admin/dsection/data_item/'.$d->id);
	  }
      }
    elseif(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection/data_item/'.$_POST['id']);
      }
    
    $this->buildNavData();
    $this->setTemplate('elib:/admin/section.tpl');
    $d = new DataItem($this);
    $d->id = $_GET['id'];
    $d->load(DataItem::$table);
    $this->presenter->assign('data_item', $d);
  }


  public function data_item_toggle_hidden()
  {
    $d = new DataItem($this);
    $d->id = $_GET['id'];
    $d->load(DataItem::$table);
    $d->hidden = ($d->hidden)? 0 : 1;
    $d->save(DataItem::$table, array(), 0);
    $this->redirect('admin/dsection/data_item/'.$d->id);
  }


  // containers
  public function add_container()
  {
    $c = new Container($this);
    $c->name = '#New Container';
    $c->insert(Container::$table, 1, array(), 0);
    $this->redirect('admin/dsection/containers');
  }

  public function containers()
  {
    if(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection');
      }
    elseif(isset($_POST['save']))
      {
	foreach($_POST['image_size'] as $index => $value)
	  {
	    $c = new Container($this);
	    $c->update($index, $value);	    
	  }
	$this->redirect('admin/dsection');
      }

    $this->setTemplate('elib:/admin/containers.tpl');
    $c = new Container($this);
    $containers = $c->getAll();
    $this->assign('containers', $containers);
    $i = new ImageSize($this);
    $image_sizes = $i->loadAsOptions(ImageSize::$table, 'name');
    $this->presenter->assign('image_sizes', $image_sizes);        
  }

  public function remove_container()
  {
    $c = new Container($this);
    $c->id = $_GET['id'];
    $c->remove();
    $this->redirect('admin/dsection/containers');   
  }

  public function rename_container()
  {
    $this->setTemplate('elib:/admin/containers.tpl');
    if(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection/containers');
      }
    elseif(isset($_POST['save']))
      {
	$c = new Container($this);
	$c->id = $_GET['id'];
	$c->load(Container::$table);
	$c->name = $_POST['name'];
	$c->validates();
	if(!$c->hasValErrors())
	  {
	    $c->save(Container::$table, array(), 1);
	    $this->redirect('admin/dsection/containers');
	  }
	else
	  {
	    $this->assign('container', $c);
	    $this->presenter->assign('errors', $c->getValErrors());
	  }
      }
    else
      {
	$c = new Container($this);
	$c->id = $_GET['id'];
	$c->load(Container::$table);
	$this->assign('container', $c);
      }
  }





  // image sizes  
  public function add_image_size()
  {
    $i = new ImageSize($this);
    $i->name = 'New Image Size';
    $i->width = 0;
    $i->height = 0;
    $i->prefix = 'new';
    $i->insert(ImageSize::$table, 1, array(), 0);
    $this->redirect('admin/dsection/image_sizes');
  }

  public function image_sizes()
  {
    if($this->isXMLHttpRequest())
      {
	$return_code = 1;	
	if(isset($_POST['id']) && is_numeric($_POST['id']))
	  {
	    $i = new ImageSize($this);
	    $i->id = $_POST['id'];
	    $i->load(ImageSize::$table);
	    $field = $_POST['field'];
	    $i->$field = $_POST['value'];
	    $i->validates();
	    if($i->hasValErrors())
	      {		
		//$this->logMe($i->getValErrors());
		$return_code = 2;
	      }
	    else
	      {
		$i->save(ImageSize::$table, array(), 1);
		$return_code = 0;
	      }
	  }       
	header('Content-type: application/json');
	echo json_encode($return_code);
	exit();
      }       

    if(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection');
      }
    elseif(isset($_POST['save']))
      {
	foreach($_POST['image_size'] as $index => $value)
	  {
	    $c = new Container($this);
	    $c->update($index, $value);	    
	  }
	$this->redirect('admin/dsection');
      }

    $this->setTemplate('elib:/admin/image_sizes.tpl');

    $i = new ImageSize($this);
    $sql = ' ORDER BY name';
    $image_sizes = $i->getAllCustom(ImageSize::$table, $sql);

    $this->presenter->assign('image_sizes', $image_sizes);        
  }

  public function remove_image_size()
  {
    $i = new ImageSize($this);
    $i->id = $_GET['id'];
    $i->delete(ImageSize::$table);
    $this->redirect('admin/dsection/image_sizes');   
  }

  /*
  public function rename_image_size()
  {
    if(isset($_POST['cancel']))
      {
	$this->redirect('admin/dsection/containers');
      }
    elseif(isset($_POST['save']))
      {
	$c = new Container($this);
	$c->id = $_GET['id'];
	$c->load(Container::$table);
	$c->name = $_POST['name'];
	$c->validates();
	if(!$c->hasValErrors())
	  {
	    $c->save(Container::$table, array(), 1);
	    $this->redirect('admin/containers');
	  }
	else
	  {
	    $this->assign('container', $c);
	    $this->presenter->assign('errors', $c->getValErrors());
	  }
      }
    else
      {
	$c = new Container($this);
	$c->id = $_GET['id'];
	$c->load(Container::$table);
	$this->assign('container', $c);
      }
  }
  */

  public function update_image_size()
  {
    $i = new ImageSize($this);    
    $i->id = $_GET['id'];
    $i->load(ImageSize::$table);
    $images = $i->getDataFiles();
   
    $d = array(array($i->prefix.'_', $i->width, $i->height));
    $u = new ImageUpload('', false, $d);
    set_time_limit(300);
    $u->resize($images);    
    $this->redirect('admin/image_sizes');
  }



}
?>