<?php
class Db
{
  private $_db;
  private static $instance = null;
  public function __construct()
  {
    try
    {
      $this->_db = new PDO('mysql:host=localhost;dbname=bet;charset=utf8', 'redacteur', 'helb');
      $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    }catch(PDOxception $e)
    {
      die('Erreur de connexion à la base de données : '.$e->getMessage());
    }
  }

  public static function getInstance(){
    if (is_null(self::$instance))
    {
      self::$instance = new Db();
    }
    return self::$instance;
  }

  function test_user($log, $pwd)
  {
    $sql = "SELECT * from users where name=:login and password=:pass and accepted=:accept";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':login'=>$log, ':pass'=>$pwd, ':accept'=>1));
    $nombre = $stmt->rowcount();

		$id=null;
		if($nombre == 1)
		{
			$result = $stmt->fetch();
			$id = $result->id;
		}
		return $id;
  }

  function getUserByName($name)
  {
    $sql = "SELECT * FROM users where name like :name";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(":name"=>$name));
    $num= $stmt->rowcount();

    return $num;
  }

  function getUserByMail($mail)
  {
    $sql = "SELECT * FROM users where mail like :mail";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(":mail"=>$mail));
    $num= $stmt->rowcount();
	  $id = null;
  	if($num > 0){
  		$result = $stmt->fetch();
  		$id = $result->id;
  	}
    return $id;
  }

  function getCredit($id)
  {
    $sql = "SELECT * FROM users where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(":id"=>$id));
    $num= $stmt->rowcount();
    $credit=0;
    if($num > 0){
      $result = $stmt->fetch();
      $credit = $result->credit;
    }

    return $credit;
  }

  function PendingUsers()
  {
    //1 accepté, 0 pas accepté
    $sql = "SELECT * FROM users where accepted=:num";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(":num"=>0));
    $row= $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }

  function addPendingUser($id)
  {
    $sql= "UPDATE users SET accepted=1 where id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id));
  }

  function deletePendingUser($id)
  {
    $sql= "DELETE FROM users WHERE id=:id";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id));
  }

  function addUser($name, $password, $mail, $birth, $adress, $city, $work ,$accept)
  {
    $sql ='INSERT INTO users (name, password, mail, birth, adress, city, work, accepted) VALUES(:nom, :pwd,:mail,:birth, :adress, :city, :work, :accept)';
    $stmt = $this->_db->prepare($sql);
    $stmt->bindParam(':nom', $name,PDO::PARAM_STR,50);
    $stmt->bindParam(':pwd', $password,PDO::PARAM_STR,100);
    $stmt->bindParam(':mail', $mail,PDO::PARAM_STR,100);
    $stmt->bindParam(':birth', $birth,PDO::PARAM_STR);
    $stmt->bindParam(':adress', $adress,PDO::PARAM_STR);
    $stmt->bindParam(':city', $city,PDO::PARAM_STR);
    $stmt->bindParam(':work', $work,PDO::PARAM_STR);
    $stmt->bindParam(':accept', $accept,PDO::PARAM_INT);
    $stmt->execute();
  }

  function changePass($id, $pwd){
	  $sql = "UPDATE users SET password=:pwd WHERE id=:ID";
	  $stmt = $this->_db->prepare($sql);
	  $stmt->execute(array(':pwd'=>$pwd,':ID'=>$id));
  }

  function checkEmail($email, $pwd)
  {
    $sql = 'SELECT * FROM users WHERE mail=:mail and password=:pass';
    $stmt=$this->_db->prepare($sql);
    $stmt->execute(array(':mail'=>$email, ':pass'=>$pwd));
    $num=$stmt->rowcount();
	  $id = null;
    if($num > 0)
    {
      $result=$stmt->fetch();
      $id = $result->id;
    }


    return $id;
  }

  function addCredit($id, $email, $credit)
  {
    $sql = 'UPDATE users set credit = credit + :credit WHERE id=:id and mail=:mail';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':credit'=>$credit, ':id'=>$id, ':mail'=>$email));
  }

  function getTeams()
  {
    $sql = "SELECT * FROM nba";
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }

  function getCote($team)
  {
    $sql ='SELECT * FROM nba WHERE nom=:nom';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':nom'=>$team));
    $num=$stmt->rowcount();
    $cote = null;
    if($num > 0)
    {
      $result=$stmt->fetch();
      $cote = $result->cote;
    }

    return $cote;
  }

  function addMatch($teamd, $teame, $h, $m, $cote1, $cote2,$mise)
  {
    $time=$h.':'.$m.':00';
    $d = date('Y-m-d');
    $sql = 'INSERT INTO matchs (date,heure,domicile,coted,exterieur,cotee,Mise)VALUES (:d, :h,:team1,:cote1,:team2,:cote2,:mise)';
    $stmt = $this->_db->prepare($sql);
    $stmt->bindParam(':d', $d,PDO::PARAM_STR);
    $stmt->bindParam(':h', $time,PDO::PARAM_STR);
    $stmt->bindParam(':team1', $teamd,PDO::PARAM_STR,150);
    $stmt->bindParam(':cote1', $cote1,PDO::PARAM_STR);
    $stmt->bindParam(':team2', $teame,PDO::PARAM_STR,150);
    $stmt->bindParam(':cote2', $cote2,PDO::PARAM_STR);
    $stmt->bindParam(':mise', $mise,PDO::PARAM_INT);
    $stmt->execute();
  }

  function addscore($scored,$scoree,$id)
  {
    $sql = 'UPDATE matchs set pointd = pointd + :scored, pointe = pointe + :scoree WHERE id=:id ';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':scored'=>$scored,':scoree'=>$scoree, ':id'=>$id));
  }
  function addtime($time,$id)
  {
    $sql='UPDATE match set temps = temps + :temps WHERE id=:id';
    $stmt= $this->_db->prepare($sql);
    $stmt->execute(array(':temps'=>$time,':id'=>$id));
  }

  function getMatches()
  {
    $sql = 'SELECT * FROM matchs';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();
    $row= $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }

  function startMatch($id)
  {
    $sql = 'UPDATE matchs set status=1 WHERE id=:id';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id));
  }

  function getAllStartedMatch()
  {
    $sql = 'SELECT * FROM matchs WHERE status=1';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute();
    $row= $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }

  function getScore($id)
  {
    $sql = 'SELECT pointd,pointe FROM matchs WHERE id=:id';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id));
    $row= $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }

  function stopMatch($id)
  {
    $sql = 'UPDATE matchs set status=2 WHERE id=:id';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id));
  }

  function deleteMatch($id)
  {
    $sql = 'DELETE from match WHERE id=:id';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id));
  }

  function updateDb($id)
  {
    $sql ='SELECT * from matchs WHERE id=:id';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id));
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $winner = '';
    if($row[0]['pointd'] > $row[0]['pointe'])
    {
      $winner = $row[0]['domicile'];
    }else
    {
      $winner = $row[0]['exterieur'];
    }
    $sql = 'UPDATE pari SET etat=:etat,gagnant=:g WHERE idMatch=:idm';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':etat'=>1,':g'=>$winner,':idm'=>$id));
  }
  function verifyBet($idmatch, $iduser)
  {
    $sql = 'SELECT * FROM pari WHERE idMatch=:idm AND idUser=:idu';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':idm'=>$idmatch,':idu'=>$iduser));
    $num = $stmt->rowcount();
    $exist = 0;
    if($num > 0)
    {
      $exist = 1;
    }

    return $exist;
  }

  function addBet($user, $match, $team, $cote, $sum,$equipes)
  {
    $sql = 'INSERT INTO pari (idUser,idMatch,team,cote,sum,equipes)VALUES(:user, :match,:team,:cote,:sum,:equipes)';
    $stmt = $this->_db->prepare($sql);
    $stmt->bindParam(':user', $user,PDO::PARAM_INT);
    $stmt->bindParam(':match', $match,PDO::PARAM_INT);
    $stmt->bindParam(':team', $team,PDO::PARAM_STR,150);
    $stmt->bindParam(':cote', $cote,PDO::PARAM_STR);
    $stmt->bindParam(':sum', $sum,PDO::PARAM_INT);
    $stmt->bindParam(':equipes', $equipes,PDO::PARAM_STR,150);
    $stmt->execute();
  }

  function updateCredit($credit, $id)
  {
    $sql = 'UPDATE users set credit = credit + :credit WHERE id=:id ';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':credit'=>$credit, ':id'=>$id));
  }

  function hasBeenPayed($id)
  {
    $sql = 'UPDATE pari set Payer:=:p WHERE id=:id';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':p'=>1,':id'=>$id));
  }

  function getBetByUser($id)
  {
    $sql ='SELECT * from pari WHERE idUser=:id and etat=:etat';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id,':etat'=>0));
    $row= $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }

  function getOldBet($id)
  {
    $sql ='SELECT * from pari WHERE idUser=:id and etat=:etat';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id,':etat'=>1));
    $row= $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }

  function getTeamsFromMatch($id)
  {
    $sql ='SELECT domicile,exterieur from matchs WHERE id=:id';
    $stmt = $this->_db->prepare($sql);
    $stmt->execute(array(':id'=>$id));
    $row= $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $row;
  }
}
?>
