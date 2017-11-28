<?php
class MatchController{
  private $notification='';
  private $alert='';
  public function __construct(){

  }

  public function run()
  {
	if(!empty($_GET))
    {
        $row = Db::getInstance()->getTeams();
        $team ='<table class="table table-hover table-stipped" ><thead><tr><td colspan="9">'
              .'<h4>Les équipes :</h4></td></tr></thead>';
        if(!empty($row))
        {
          $team .= '<tbody>';
          $team .= $this->createForm($row);
          $team .= $this->createForm($row);
          $team .= $this->createForm($row);
          $team .= $this->createForm($row);
          $team .= $this->createForm($row);
          $team .= '</tbody></table>';
        }else
        {
          $team .= '<tbody><tr>aucunes équipes.</tr></tbody></table>';
        }
        echo $team;
      if(!empty($_POST))
      {
        if($_POST['teamd'] != $_POST['teame'] && isset($_POST['created']) && isset($_POST['mise']))
        {
          if($_POST['mise'] > 0)
		  {
			  $coted = Db::getInstance()->getCote($_POST['teamd']);
			  $cotee = Db::getInstance()->getCote($_POST['teame']);
			  Db::getInstance()->addMatch($_POST['teamd'], $_POST['teame'],$_POST['hour'],$_POST['min'], $coted, $cotee,$_POST['mise']);
			  $this->notification = 'Un nouveau match a été ajouté';
			  $this->alert ="alert alert-success";
		  }else
		  {
			  $this->notification = 'Veuillez ajouter une mise supérieur à 0';
			  $this->alert ="alert alert-warning";
		  }
		  
        }else
        {
          $this->notification = 'Veuillez choisir deux équipes différentes';
          $this->alert ="alert alert-warning";
        }
      }
    }
  }

  function createForm($row)
  {
      $t = '<tr><form method="POST" action=""><tr><td>Domicile:</td>'.
      '<td><select name="teamd" class="form-control">'
      . $this->selectOptions($row)
      . '</select></td><td>Extérieur:</td><td>'
      .'<select name="teame" class="form-control">'
      . $this->selectOptions($row)
      .'</select></td><td>Heure:</td>'
      .'<td>'.$this->selectTime('hour',24).'</td><td>'.$this->selectTime('min',60).'</td>'
      .'<td>Mise :<input type="number" name="mise" placeholer="mise minimale"/></td>'
      .'<td colspan="7"><input type="submit" name="created" value="Ajouter match" class="btn btn-danger"/></td></tr></form>';

      return $t;
  }
  function selectOptions($row)
  {
    $t = '';
    foreach ($row as $value) {
      $t .='<option value="'.$value['nom'].'">'.$value['nom'].'</option>';
    }
    return $t;
  }

  function selectTime($name, $max)
  {
    $t = '<select name="'.$name.'" class="form-control">';
    $t .='<option value="00" selected>00</option>';
    for ($i=1; $i < $max; $i++) {
      if($i<10){
        $t .='<option value="0'.$i.'">0'.$i.'</option>';
      }else{
        $t .='<option value="'.$i.'">'.$i.'</option>';
      }

    }
    $t .= '</select>';
    return $t;

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
