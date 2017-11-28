<?php
session_start();
define('CHEMIN_VUES','Views/');
require_once('models/DB.class.php');
$notification='';


if(!empty($_GET)){

  $connect = (isset($_GET['send'])) ? htmlentities($_GET['send']) : 'default';
  
  if(isset($_SESSION['id']))
  {
	  if($_SESSION['id'] == 1 && ($connect == 'new' || $connect == 'addmatch'))
	  {
		  if($connect == 'new')
		  {
			  require_once('controllers/UserController.php');
              $connect = new UserController();
		  }
		  else if ($connect == 'addmatch')
		  {
			  require_once('controllers/MatchController.php');
              $connect = new MatchController();
		  }
	  }
	  else{
		    switch ($connect) {
			case 'newpwd':
			  require_once('controllers/NewPwdController.php');
			  $connect = new NewPwdController();
			  break;
			case 'history':
			  require_once('controllers/HistoryController.php');
			  $connect = new HistoryController();
			  break;
			default:
			  require_once('controllers/BetController.php');
			  $connect = new BetController();
			  break;
		}
	  }
  }

}else
{
  require_once('controllers/BetController.php');
  $connect = new BetController();
}
if(isset($_SESSION['id']))
{
  $_SESSION['credit'] = Db::getInstance()->getCredit($_SESSION['id']);
}


require_once (CHEMIN_VUES.'header.php');

require_once (CHEMIN_VUES.'navbar-index.php');
$connect->run();
$notification = $connect->getNotification();
if($notification !=''){
	echo '<div class="'.$connect->getAlert().'">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	<strong></strong>'. $notification.'</div>';
}



require_once (CHEMIN_VUES.'footer.php');

?>
