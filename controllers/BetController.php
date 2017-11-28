<?php
class BetController
{
  private $notification='';
  private $alert='';
  public function __construct(){

  }

  public function run()
  {
		if(isset($_POST['sum']) && isset($_POST['teams']))
		{
		  if(empty($_POST['sum'])){
			$this->notification = 'remplissez tout les champs';
			$this->alert = 'alert alert-danger';
		  }else if($_POST['sum'] > $_SESSION['credit'] || $_POST['sum'] < $_POST['Misemin'])
		  {
			$this->notification = 'Vous devez parier au moins la mise minimale et votre pari ne peut pas dépasser votre crédit';
			$this->alert = 'alert alert-danger';
		  }
		  else if($_POST['sum'] <= $_SESSION['credit'] && $_POST['sum'] >= $_POST['Misemin'])
		  {
			$cote = Db::getInstance()->getCote($_POST['teams']);
			$rep = Db::getInstance()->getTeamsFromMatch($_POST['matchId']);
			$equipes = $rep[0]['domicile'].'-'.$rep['exterieur'];
			Db::getInstance()->addBet($_SESSION['id'], $_POST['matchId'], $_POST['teams'], $cote, $_POST['sum'],$equipes);
			$bet = $_POST['sum'] * -1;
			Db::getInstance()->updateCredit($bet, $_SESSION['id']);
		  }
		}

		if(isset($_POST['startMatch']))
		{
		  Db::getInstance()->startMatch($_POST['matchId']);
		}

		if(isset($_POST['stopMatch']))
		{
		  Db::getInstance()->stopMatch($_POST['matchId']);
		  Db::getInstance()->updateDb($_POST['matchId']);
		}

		if(isset($_POST['deleteMatch']))
		{
		  Db::getInstance()->deleteMatch($_POST['matchId']);
		}

		$row = Db::getInstance()->getMatches();

		$table = '<table class="table table-hover"><thead><tr><th>Date</th><th>Heure de début</th>'
				.'<th>Equipes</th><th>Cote</th><th>Cote</th><th>Score</th><th></th></tr></thead><tbody>';
		if(!empty($row)){
		  /*$this->notification = 'Il y a des matchs';
		  $this->alert ="alert alert-success";*/
		  foreach ($row as $value)
		  {

			$table .= '<tr><td>'.$value['date'].'</td>'
					.'<td>'.$value['heure'].'</td>'
					.'<td>'.$value['domicile'].'-'.$value['exterieur'].'</td>'
					.'<td>'.$value['coted'].'</td>'
					.'<td>'.$value['cotee'].'</td>'
					.'<td id="score'.$value['id'].'">'.$value['pointd'].'-'.$value['pointe'].'</td>';
					
			//Parier
			if(isset($_SESSION['id']) && $_SESSION['id'] > 1 && $value['status'] < 2){
			  $table .='<td><form method="POST" action=""><select name="teams" id="teams"><option value="'.$value['domicile'].'">'.$value['domicile'].'</option><option value="'.$value['exterieur'].'">'.$value['exterieur'].'</option></select>'
					 .'<input type="number" id="sum" name="sum" placeholder="Mise min:'.$value['Mise'].'"/><input type="hidden" id="Misemin" name="Misemin" value="'.$value['Mise'].'" />'
					 .'<input type="hidden" id="matchId" name="matchId" value="'.$value['id'].'" /><input type="submit" name="bet" value="Parier" class="btn btn-danger"/></form></td>';
			}
			//Demarrer match
			if(isset($_SESSION['id']) && $_SESSION['id'] == 1 && $value['status'] == 0)
			{
			  $table .='<td><form method="POST" action=""><input type="hidden" id="matchId" name="matchId" value="'.$value['id'].'" />'
					 .'<input type="submit" name="startMatch" value="Go" class="btn btn-danger"/></form></td>';
			}
			//Arrêter match
			if(isset($_SESSION['id']) && $_SESSION['id'] == 1 && $value['status'] == 1)
			{
			  $table .='<td><form method="POST" action=""><input type="hidden" id="matchId" name="matchId" value="'.$value['id'].'" />'
					 .'<input type="submit" name="stopMatch" value="Stop" class="btn btn-danger"/></form></td>';
			}
			//Supprimer match
			if(isset($_SESSION['id']) && $_SESSION['id'] == 1 && $value['status'] == 2)
			{
			  $table .='<td><form method="POST" action=""><input type="hidden" id="matchId" name="matchId" value="'.$value['id'].'" />'
					 .'<input type="submit" name="deleteMatch" value="Delete" class="btn btn-danger"/></form></td>';
			}else if($value['status'] == 2){
			  $table .='<td>Match terminé</td>';
			}
			$table .= '</tr>';
		  }
		}else{
		  /*$this->notification = 'Il n\'y a pas des matchs';
		  $this->alert ="alert alert-warning";*/
		  $table .='<tr>Aucuns matchs</tr>';
		}
		$table .= '</tbody></table>';
		echo $table;
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
