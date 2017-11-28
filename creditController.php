<?php
session_start();
require_once('Models/DB.class.php');

if(isset($_POST['email']) && isset($_POST['credit']) && isset($_POST['password']))
{
  $id = Db::getInstance()->checkEmail($_POST['email'], $_POST['password']);
  $notification='';
  if($id==$_SESSION['id'] && $_POST['credit']>0)
  {
     Db::getInstance()->addCredit($id,$_POST['email'],$_POST['credit']);
     $_SESSION['credit'] = $_SESSION['credit'] + $_POST['credit'];
     $notification ='Credit rajouté';
  }else
  {
    if($id != $_SESSION['id'])
    {
      $notification ='Email et/ou mot de passe éronné(s) </br>';
    }
    if($_POST['credit']<=0)
    {
      $notification .='Veuillez entrez un credit supérieur à 0';
    }
  }

  echo $notification;
}else{
  echo 'fail';
}
?>
