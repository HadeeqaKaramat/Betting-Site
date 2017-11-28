<?php
session_start();
require_once('models/DB.class.php');
/*function age($date)
{
  $d = strtotime($date);
  //echo strftime('%a %d %b %Y', $d).' > ';
  return (int) ((time() - $d) / 3600 / 24 / 365.242);
}*/
if(empty($_POST))
{
  header('Location:index.php');
}else
{
  $notification ='';
  $num = Db::getInstance()->getUserByName($_POST['user']);
  $mail = Db::getInstance()->getUserByMail($_POST['mail']);
  $a = $_POST['year'];
  $m = $_POST['month'];
  $j = $_POST['day'];
  $date18 = 0;
  if($a == date('Y')-18 ){
	  if(($m == date('n') && $d >  date('j')) || $m >= date('n')){
		$date18 = 17;
	  }else{
		$date18 = date('Y') - $a;
	  }
  }else{
	  $date18 = date('Y') - $a;
  }

  if($num == 0 && $mail == 0 && $date18 >= 18 && $_POST['pwd'] == $_POST['pwd2'])
  {
    $birth = $a+"/"+$m+"/"+$j;
	  Db::getInstance()->addUser($_POST['user'], $_POST['pwd'], $_POST['mail'],$birth,$_POST['adress'],$_POST['city'],$_POST['work'], 0);
    $notification = 'yes';
  }else{
	  if($num !=0)
	  {
		$notification = 'cet utilisateur existe deja </br>';
	  }
	  if($mail != 0)
	  {
		$notification .= 'cet email est invalide </br>';
	  }
	  if($date18 <  18)
	  {
		$notification .= 'Vous devez avoir au moins 18 ans </br>';
	  }

	  if($_POST['pwd'] != $_POST['pwd2']){
		$notification .= 'Vous devez retaper deux fois le meme mot de passe </br>';
	  }
  }

  echo $notification;

}

?>
