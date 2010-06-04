<?php

namespace ELib\Blog;

use ELib\AdminController;
use ELib\File\Image as ImageUpload;

use Empathy\Model\User as User;
use Empathy\Model\BlogCategory as BlogCategory;
use Empathy\Model\BlogItem as BlogItem;
use Empathy\Model\BlogImage as BlogImage;
use Empathy\Model\BlogTag as BlogTag;
use Empathy\Model\TagItem as TagItem;


define('REQUESTS_PER_PAGE', 12);
define('DRAFT', 1);
define('PUBLISHED', 2);
define('DELETED', 3);

class Controller extends AdminController
{ 
  public function default_event()
  {
    $ui_array = array('page', 'status');
    $this->loadUIVars('ui_blog', $ui_array);
    if(!isset($_GET['page']) || $_GET['page'] == '')
      {
	$_GET['page'] = 1;
      }
    if(!isset($_GET['status']) || $_GET['status'] == '')
      {
	$_GET['status'] = 1;
      }   
    $this->presenter->assign('page', $_GET['page']);
    $this->presenter->assign('status', $_GET['status']);
    

    $super = 0;

    // is superuser?
    $u = new User($this);
    $u->id = $_SESSION['user_id'];
    $u->load(User::$table);
    if($u->auth == 2)
      {
	$super = 1;
      }
    $this->presenter->assign('super', $super);

    $c = new BlogCategory($this);
    $cats = $c->getAllCustom(BlogCategory::$table, '');
    $cats_arr = array();
    foreach($cats as $index => $item)
      {
	$id = $item['id'];
	$cats_arr[$id] = $item['label'];
      }

    $b = new BlogItem($this);
    $blogs = array();

    $select = '*,t1.id AS id';
    $sql = ' WHERE status = '.$_GET['status'];

    if(!$super)
      {
	$sql .= ' AND user_id = '.$_SESSION['user_id'];
      }

    $sql .= ' AND t1.user_id = t2.id';
    $sql .= ' ORDER BY stamp DESC';

    $p_nav = $b->getPaginatePagesSimpleJoin($select, BlogItem::$table, User::$table, $sql, $_GET['page'], REQUESTS_PER_PAGE);
    $this->presenter->assign('p_nav', $p_nav);

    $this->presenter->assign('status', $_GET['status']);


    $blogs = $b->getAllCustomPaginateSimpleJoin($select, BlogItem::$table, User::$table, $sql, $_GET['page'], REQUESTS_PER_PAGE);

    foreach($blogs as $index => $item)
      {
	$cat_id = $item['blog_category_id'];
	$cat = $cats_arr[$cat_id];
	$blogs[$index]['category'] = $cat;
      }

    $this->setTemplate('elib:/admin/blog_admin.tpl');   
    $this->presenter->assign('blogs', $blogs);
  }


  public function upload_image()
  {
    $_GET['id'] = $_POST['id'];
    $sizes = array(array('l_', 800, 600),
		   array('tn_', 200, 200),
		   array('mid_', 468, 5000));
    $u = new ImageUpload('blog', true, $sizes);
    
    if($u->error != '')
      {
	$this->presenter->assign('error', $u->error);
      }
    else
      {
	$bi = new BlogImage($this);
	$bi->filename = $u->getFile();
	$bi->blog_id = $_GET['id'];
	$bi->insert(BlogImage::$table, 1, array(), 0);
	$this->redirect('admin/blog/view/'.$_GET['id']);
      }
    
	/*
	$b = new SectionItem($this);
	$section->getItem($_GET['id']);
	
	$gallery = strtolower(str_replace(" ", "", $section->label));
	
	$this->setNavigation();
	
	if(isset($_POST['upload']))
	  {
	    $upload = new ImageUpload();
	    
	    $upload->upload($gallery, true);
	    
	    if($upload->error != "")
	      {
		$this->presenter->assign("error", $upload->error);
	      }
	    else
	      {	
		$this->redirect("admin/sections/$section->id");
	      }           	    	  
	  }
	*/
  }

  public function remove_image()
  {
    if(!isset($_GET['id']) || !is_numeric($_GET['id']))
      {
	$_GET['id'] = 0;
      }
    $i = new BlogImage($this);
    $i->id = $_GET['id'];
    $i->load(BlogImage::$table);

    $u = new ImageUpload('blog', false, array());
    if($u->remove(array($i->filename)))
      {
	$i->delete(BlogImage::$table);
      }
    
    $this->redirect('admin/blog/view/'.$i->blog_id);
  }
    


  public function delete()
  {
    $b = new BlogItem($this);
    $b->id = $_GET['id'];
    $b->load(BlogItem::$table);
    $b->status = 3;
    $b->save(BlogItem::$table, array(), 2);
    $this->redirect('admin/blog/?page=1&status=2');
  }

  public function redraft()
  {
    $b = new BlogItem($this);
    $b->id = $_GET['id'];
    $b->load(BlogItem::$table);
    $b->status = 1;
    $b->save(BlogItem::$table, array(), 2);
    $this->redirect('admin/blog/view/'.$b->id);
  }

  public function publish()
  {
    $b = new BlogItem($this);
    $b->id = $_GET['id'];
    $b->load(BlogItem::$table);
    if(isset($_GET['stamp']) && $_GET['stamp'] == 1)
      {
	$b->stamp = date('Y-m-d H:i:s', time());	    
      }
    $b->status = 2;
    $b->save(BlogItem::$table, array(), 2);
    $this->redirect('admin/blog/?page=1&status=2');
  }
  
  public function view()
  {
    if(isset($_POST['upload_image']))
      {
	$this->upload_image();
      }
	

    $b = new BlogItem($this);
    $b->id = $_GET['id'];
    $b->load(BlogItem::$table);

    $u = new User($this);
    $u->id = $b->user_id;   
    $u->load(User::$table);    

    $this->presenter->assign('author', $u->username);
    $this->presenter->assign('blog', $b);

    $bi = new BlogImage($this);
    $sql = ' WHERE blog_id = '.$b->id;    
    $images = $bi->getAllCustom(BlogImage::$table, $sql);
    
    /*
    $image = array();
    foreach($images as $item)
      {
	array_push($image, $item['filename']);
      }
    */

    $this->presenter->assign('images', $images);
    
    // get tags
    $bt = new BlogTag($this);
    $tags_arr = $bt->getTags($b->id);
    $tags = implode(', ', $tags_arr);
    $this->presenter->assign('blog_tags', $tags);
 
    $this->setTemplate('elib:/admin/view_blog_item.tpl');       
  }


  public function create()
  {
    $c = new BlogCategory($this);
    $cats = $c->getAllCustom(BlogCategory::$table, '');
    $cats_arr = array();
    foreach($cats as $index => $item)
      {
	$id = $item['id'];
	$cats_arr[$id] = $item['label'];
      }

    $this->presenter->assign('cats', $cats_arr);
    

    $this->setTemplate('elib:/admin/create_blog.tpl');
    if(isset($_POST['save']))
      {
	$b = new BlogItem($this);       
	$tags_arr = $b->buildTags(); // errors ?

	$b->heading = $_POST['heading'];
	$b->body = $_POST['body'];
	$b->status = DRAFT;
	$b->blog_category_id = $_POST['category'];


	$b->checkForDuplicates($tags_arr);	
	$b->validates();       

	if($b->hasValErrors())
	  {
	    $this->presenter->assign('blog', $b);
	    $this->presenter->assign('blog_tags', $_POST['tags']);
	    $this->presenter->assign('errors', $b->getValErrors());
	  }
	else
	  {
	    $b->assignFromPost(array('user_id', 'id', 'stamp', 'tags', 'status', 'blog_category_id'));
	    $b->user_id = $_SESSION['user_id'];	    
	    $b->stamp = date('Y-m-d H:i:s', time());	    
	    $b->id = $b->insert(BlogItem::$table, 1, array(), 1);	    
	    $this->processTags($b, $tags_arr);
	    $this->redirect('admin/blog');
	  }
      }    
  }

  public function edit_blog()
  {
    $c = new BlogCategory($this);
    $cats = $c->getAllCustom(BlogCategory::$table, '');
    $cats_arr = array();
    foreach($cats as $index => $item)
      {
	$id = $item['id'];
	$cats_arr[$id] = $item['label'];
      }
    $this->presenter->assign('cats', $cats_arr);

    if(isset($_POST['save']))
      {
	$b = new BlogItem($this);
	$b->id = $_POST['id'];
	$tags_arr = $b->buildTags();

	$b->load(BlogItem::$table);

	$b->blog_category_id = $_POST['category'];
	$b->assignFromPost(array('stamp', 'id', 'tags', 'user_id', 'status', 'blog_category_id'));
	
	$b->validates($tags_arr);
	$b->checkForDuplicates($tags_arr);
	
	if($b->hasValErrors())
	  {
	    $b->heading = $_POST['heading'];
	    $b->body = $_POST['body'];
	    $this->presenter->assign('blog', $b);
	    $this->presenter->assign('blog_tags', $_POST['tags']);
	    $this->presenter->assign('errors', $b->getValErrors());
	  }
	else
	  {	    
	    $bi = new BlogImage($this);
	    $images = $bi->getForIDs(array($b->id));
	   
	    if(isset($images[$b->id]))
	      {
		// process blog images to create mid sized with id attributes - needs optimising?
		foreach($images[$b->id] as $item)
		  {		    		    
		    $b->body = preg_replace(
					    //'!<img +src=""(?: +id="(.*?)")?(?: +alt="(.*?)")? */>!m',
					    '!<img(?: +src="")?(?: +id="(.*?)")?(?: +alt="(.*?)")? */>!m',
					    '<img src="http://'.WEB_ROOT.PUBLIC_DIR.'/uploads/mid_'.$item['filename'].'" id="blog_image_'.$item['id'].'" alt="$2" />',
					    $b->body, 1);		    
		  }	
	      }

	    $b->save(BlogItem::$table, array(), 1);
	    
	    $this->processTags($b, $tags_arr); 
	    $this->redirect('admin/blog/view/'.$b->id);
	  }
      }
    else
      {
	$b = new BlogItem($this);
	$b->id = $_GET['id'];
	$b->load(BlogItem::$table);
       
	//	$b->body = preg_replace('!<img src="http://'.WEB_ROOT.PUBLIC_DIR.'/uploads/(.*?)" alt="(.*?)" />!m', '<img src="" alt="$2" />', $b->body);		    

	$this->presenter->assign('blog', $b);

	// get tags
	$bt = new BlogTag($this);
	$tags_arr = $bt->getTags($b->id);
	$tags = implode(', ', $tags_arr);
	$this->presenter->assign('blog_tags', $tags);
      }

    $this->setTemplate('elib:/admin/edit_blog.tpl');       
  }

  public function processTags($b, $tags_arr)
  {
    // deal with tags	       
    $bt = new BlogTag($this);
    $bt->removeAll($b->id);
    
    $t = new TagItem($this);	    
    
    if(strlen($_POST['tags']) > 0)
      {
	$tag_ids = $t->getIds($tags_arr, false);
	
	foreach($tag_ids as $id)
	  {
	    $bt = new BlogTag($this);
	    $bt->blog_id = $b->id;
	    $bt->tag_id = $id;
	    $bt->insert(BlogTag::$table, 0, array(), 0);
	  }	       
      }	   
    $t->cleanup();
  }


  // blog category stuff
  public function add_cat()
  {
    if(isset($_GET['id']) && is_numeric($_GET['id']))
      {
	$b = new BlogCategory($this);
	$b->blog_category_id = $_GET['id'];
	$b->label = 'New Category';       
	$b->insert(BlogCategory::$table, 1, array(), 0);	
      }
    $this->redirect('admin/blog/category/'.$_GET['id']);
  }


  public function category()
  {   
    $this->setTemplate('elib:/admin/blog_cat.tpl');
    $ui_array = array('id');
    $this->loadUIVars('ui_blog_cats', $ui_array);
    if(!isset($_GET['id']) || $_GET['id'] == '')
      {
	$_GET['id'] = 0;
      }   

    $this->buildNav();    
    $this->presenter->assign('blog_cat_id', $_GET['id']);
    $this->presenter->assign('class', 'blog_cat');
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
    //$this->assertID();

    if(!isset($_GET['collapsed']) || !is_numeric($_GET['collapsed']))
      {
	$_GET['collapsed'] = 0;
      }

    $b = new BlogCategory($this);
    $b->id = $_GET['id'];
    $b->load(BlogCategory::$table);
     
    $bt = new BlogCatTree($b, 1, $_GET['collapsed']);
    $this->presenter->assign('banners', $bt->getMarkup());
    $this->presenter->assign('banner', $b);
  }

  public function delete_category()
  {  
    $this->assertID();
    $b = new BlogCategory($this);
    $b->id = $_GET['id'];
    $b->load(BlogCategory::$table);
    if($b->hasCats($b->id))
      {
	$this->redirect('admin/blog/category/'.$b->id);           
      }   
    else
      {
	$b->delete(BlogCategory::$table);
	$this->redirect('admin/blog/category/'.$b->blog_category_id);           
      }    
  }

  public function rename_category()
  {
    $this->buildNav();
    if(isset($_POST['save']))
      {
	$b = new BlogCategory($this);
	$b->id = $_POST['id'];
	$b->load(BlogCategory::$table);
	$b->label = $_POST['label'];
	$b->validates();
	if($b->hasValErrors())
	  {
	    $this->presenter->assign('blog_category', $b);
	    $this->presenter->assign('errors', $b->getValErrors());	     
	  }
	else
	  {
	    $b->save(BlogCategory::$table, array(), 1);
	    $this->redirect('admin/blog/category/'.$b->id);
	  }
      }
    else
      {
	$b = new BlogCategory($this);
	$b->id = $_GET['id'];
	$b->load(BlogCategory::$table);
	$this->presenter->assign('blog_category', $b);
      }
    $this->setTemplate('elib:/admin/blog_cat.tpl');
    $this->assign('class', 'blog_cat');
    $this->assign('event', 'rename');
  }






}
?>