<?php
class HistoryController
{
  private $notification='';
  public function __construct(){
    require_once 'models/DB.class.php';
  }

  function run()
  {
	if(isset($_SESSION['id']))
	{	
		require_once (CHEMIN_VUES.'history.php');
	}else{
		echo '<div class="alert alert-danger">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<strong></strong>Veuillez vous connecter pour à avoir accès à cette page</div>';
	}
  }

  function getNotification(){
    return $this->notification;
  }
}
?>
