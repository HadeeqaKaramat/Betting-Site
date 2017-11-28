<?php
class NewPwdController
{
  private $notification='';
  private $alert='';
  public function __construct(){
	require_once('Models/DB.class.php');
  }

  public function run()
  {
		if(isset($_POST['pwd']) && isset($_POST['pwd2']))
		{
			if(empty($_POST['pwd']) || empty($_POST['pwd2']))
			{
			  $this->notification = 'Veuillez remplire touts les champs.';
			  $this->alert='alert alert-danger';

			}else if($_POST['pwd'] == $_POST['pwd2'])
			{
			  Db::getInstance()->changePass($_SESSION['id'],$_POST['pwd']);
			  $this->notification = 'Mot de passe changé';
			  $this->alert='alert alert-success';

			}else
			{
			  $this->notification = 'Les mots de passes que vous avez entrés ne correspondent pas.';
			  $this->alert='alert alert-danger';
			}
		}
		
		require_once (CHEMIN_VUES.'changepwd.php');
  }

   function getNotification(){
    $result = $this->notification;
    return $result;
  }
  function getAlert(){
	  return $this->alert;
  }
}
?>
