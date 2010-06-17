<?php

namespace Empathy\Model;
use Empathy\Entity as Entity;

class BlogComment extends Entity
{
  public $id;
  public $blog_id;
  public $user_id;
  public $status;
  public $stamp;
  public $heading;
  public $body;

  public static $table = 'blog_comment';


  public function validates()
  {
    if($this->body == '')
      {
	$this->addValError('Invalid body');	
      }
  }

}
?>