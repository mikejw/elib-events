<?php

namespace ELib\User;
use ELib\Model;
use Empathy\Session;


class CurrentUser
{
  private static $u;
  private static $user_id;

  public static function detectUser($c)
  {
    self::$u = Model::load('UserItem');
    self::$user_id = Session::get('user_id');

    if(is_numeric(self::$user_id) && self::$user_id > 0)
      {
	self::$u->id = self::$user_id;
	self::$u->load();
	$c->assign('current_user', self::$u->username);	
	$c->assign('user_id', self::$u->id);	
      }
  }

  public static function authenticate($c)
  {
    if(self::$u->id < 1 || !self::$u->getAuth(self::$u->id))
      {      
	$c->redirect("user/login");
      }
  }

  public static function getUserID()
  {
    return self::$u->id;
  }

  public static function loggedIn()
  {
    return (self::getUserID() > 0);
  }

}
?>