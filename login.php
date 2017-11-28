<?php
session_start();
require_once('models/DB.class.php');
if(!empty($_POST)){

  if(($id = Db::getInstance()->test_user($_POST['username'], $_POST['password'])) != 0)
  {
    echo 'YES';
	  $_SESSION['name'] = $_POST['username'];
    $_SESSION['id'] = $id;

  }else
  {
    echo 'NO';
  }
}
else
{
  echo 'NO';
}

?>
