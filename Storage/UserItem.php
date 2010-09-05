<?php

namespace ELib\Storage;

use ELib\Model;
use Empathy\Entity;


define('SALT', 'DRAGONFLY');

class UserItem extends Entity
{
  const TABLE = 'e_user';

  public $id;
  public $email;
  public $auth;
  public $username;
  public $password;
  public $reg_code;
  public $active;


  public function validates()
  {
    $email_pattern = '/^[^@\s<&>]+@([-a-z0-9]+\.)+[a-z]{2,}$/i';
    $username_pattern = '/^[a-z][_a-zA-Z0-9-]{3,7}$/';
    if($this->username == '' || !ctype_alnum(str_replace(' ', '', $this->username)) || !preg_match($username_pattern, $this->username))
      {
	$this->addValError('Invalid username');	
      }       
    if(!preg_match($email_pattern, $this->email))
      {
	$this->addValError('Invalid email address');	
      }
    if(!$this->hasValErrors())
      {
	$sql = 'SELECT id FROM '.Model::getTable('UserItem').' WHERE username = \''.$this->username.'\'';
	$error = 'Could not check for existing username.';
	$result = $this->query($sql, $error);
	if($result->rowCount() > 0)
	  {
	    $this->addValError('Username is already taken');
	  }

	$sql = 'SELECT id FROM '.Model::getTable('UserItem').' WHERE email = \''.$this->email.'\'';
	$error = 'Could not check for existing email address.';
	$result = $this->query($sql, $error);
	if($result->rowCount() > 0)
	  {
	    $this->addValError('The system is already aware of that email address');
	  }      
      }
  }

  public function getUsername($id)
  {
    $sql = "SELECT username FROM ".Model::getTable('UserItem')." WHERE id = $id";
    $error = "Could not get username.";
    $result = $this->query($sql, $error);
    $row = $result->fetch();
    return $row['username'];
  }

  /*  
  public function __construct()
  {

  }
  */

  public function buildInvalid($username, $password)
  {
    $this->id = 0;
    $this->username = $username;
    $this->password = $password;
  }


  public function getID($username, $password)
  {    
    $sql = "SELECT id FROM ".Model::getTable('UserItem')
      ." WHERE username = '$username'"
      ." AND password = '$password'";
    //." AND password = '".md5($this->password)."'";
    $error = "Could not verify user.";  
    $result = $this->query($sql, $error);
    if(1 == $result->rowCount())
    {
      $row =  $result->fetch();
      return $row['id'];
    }
    else
    {
      return 0;
    }
  }

  public function login()
  {
    $user_id = 0;
    $sql = 'SELECT * FROM '.Model::getTable('UserItem')
      .' WHERE username = BINARY \''.$this->username.'\''
      .' AND password = \''.md5(SALT.$this->password.SALT).'\''
      .' AND active = 1';
    $error = "Could not login.";
    $result = $this->query($sql, $error);
    $rows = $result->rowCount();
    if($rows == 1)
    {
      $row = $result->fetch();
      $user_id = $row['id'];
    }
    
    return $user_id;    
  }

  public function getAuth($id)
  {
    $auth = 0;
    $sql = "SELECT auth FROM ".Model::getTable('UserItem')." WHERE id = $id";
    $error = "Could not get auth code.";
    $result = $this->query($sql, $error);
    if($result->rowCount() == 1)
    {
      $row = $result->fetch();
      $auth = $row['auth'];
    }
    return $auth;
  }  

  public function findUserForActivation($reg_code)
  {
    $user_id = 0;
    //    $sql = 'SELECT id FROM '.Model::getTable('UserItem').' WHERE reg_code = \''.md5($reg_code).'\''
    $sql = 'SELECT id FROM '.Model::getTable('UserItem').' WHERE reg_code = \''.md5($reg_code).'\''
      .' AND active = 0';
    $error = 'Could not get user based on registation code.';
    $result = $this->query($sql, $error);
    if($result->rowCount() == 1)
      {
	$row = $result->fetch();
	$user_id = $row['id'];             
      }
    
    return $user_id;
  }

}
?>