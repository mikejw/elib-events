<?php

namespace ELib\Storage;

use ELib\Model;
use Empathy\Entity;
use Empathy\Validate;

define('SALT', 'DRAGONFLY');

class UserItem extends Entity
{
  const TABLE = 'e_user';

  public $id;
  public $user_profile_id;
  public $email;
  public $auth;
  public $username;
  public $password;
  public $reg_code;
  public $active;
  public $registered;
  public $activated;
  

  public function validates()
  {
    if($this->doValType(Validate::USERNAME, 'username', $this->username, false))
      {
	if($this->usernameExists())
	  {
	    $this->addValError('Username is already taken', 'username');
	  }
      }
    if($this->doValType(Validate::EMAIL, 'email', $this->email, false))
      {	
        if($this->activeUser())
          {
            $this->addValError('That email address can\'t be used', 'email');
          }
	
      }
  }


  public function validateLogin()
  {
    $this->doValType(Validate::USERNAME, 'username', $this->username, false);
    $this->doValType(Validate::TEXT, 'password', $this->password, false);    
  }

  public function getUsername($id)
  {
    $sql = "SELECT username FROM ".Model::getTable('UserItem')." WHERE id = $id";
    $error = "Could not get username.";
    $result = $this->query($sql, $error);
    $row = $result->fetch();
    return $row['username'];
  }


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
      //.' WHERE username = BINARY \''.$this->username.'\''
      // user should not need to know exact casing of username (like twitter)
      .' WHERE username = \''.$this->username.'\''
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


  private function activeUser()
  {
    $active = 0;
    $sql = 'SELECT id FROM '.Model::getTable('UserItem').' WHERE email = \''.$this->email.'\''
      .' AND active = 1';
    if(isset($this->id))
      {
	$sql .= ' AND id != '.$this->id;
      }
    $error = 'Could not check for existing email address.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
        $active = 1;
      }
    return $active;
  }


  private function usernameExists()
  {
    $exists = 0;
    $sql = 'SELECT id FROM '.Model::getTable('UserItem').' WHERE username = \''.$this->username.'\'';
    if(isset($this->id))
      {
	$sql .= ' AND id != '.$this->id;
      }
    $error = 'Could not check for existing username.';
    $result = $this->query($sql, $error);
    if($result->rowCount() > 0)
      {
	$exists = 1;
      }
    return $exists;
  }





}
?>