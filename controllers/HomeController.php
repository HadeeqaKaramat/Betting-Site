<?php
class HomeController{
  private $_notification='';
  public function __construct(){

  }

  public function run(){

    require_once(CHEMIN_VUES . 'home.php');
  }

  public  function notification(){
    $result = $this->_notification;
    return $result;
  }
}
?>
