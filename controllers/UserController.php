<?php
class UserController
{
  private $notification='';
  private $alert='';
  public function __construct()
  {
    require_once('Models/DB.class.php');
  }

  function run()
  {
    if(!empty($_GET))
    {
      if(!empty($_POST))
      {
        if(isset($_POST['add']))
        {
          Db::getInstance()->addPendingUser($_POST['add']);
        }
        if(isset($_POST['delete']))
        {
          Db::getInstance()->deletePendingUser($_POST['delete']);
        }
      }
      if($_GET['send']=='new'){
        $row = Db::getInstance()->PendingUsers();
        echo '<table class="table table-striped">'.
              '<thead><tr><th>Nom</th><th>Email</th><th>Adresse</th><th>Ville</th><th>Travail</th></tr></thead><tbody>';
    		if(!empty($row)){
    			foreach($row as $value)
    			{
    			  echo '<tr><td>'.$value['name'].'</td>'.
    					'<td>'.$value['mail'].'</td>'.
    					'<td>'.$value['adress'].'</td>'.
    					'<td>'.$value['city'].'</td>'.
    					'<td>'.$value['work'].'</td>'.
    					'<td><form method="post"><button type="submit" class="btn btn-info"  name="add" value="'.$value['id'].'">Ajouter</button></form></td>'.
    					'<td><form method="post"><button type="submit" class="btn btn-warning" name="delete" value="'.$value['id'].'">Supprimer</button></form></td></tr>';
    			}
    		}else{
    			echo '<tr><td colspan="8" style="color:DarkGrey;font-weight:bold;text-align:center">'.
    			'<span class="glyphicon glyphicon-info-sign" aria-hidden="true" style="color:blue;margin-right:px"></span>'.
    			'aucuns nouveaux utilisateurs</td></tr>';
    		}
        echo '</tbody></table>';
      }

    }

  }
   function getNotification(){
	   return $this->notification;
   }
   function getAlert(){
	  return $this->alert;
  }
}
?>
