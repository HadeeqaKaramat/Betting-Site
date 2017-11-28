<?php
session_start();
require_once('models/DB.class.php');
$changeAll = 'no';
if(isset($_SESSION['id']))
{
	if($_SESSION['id'] == 1)
	{
		function game( $score1, $score2)
		{

			$r=rand(0,2);
			if($r==0){
			  $score1 = rand(1,3);
			}else{
			  $score2 = rand(1,3);

		  }
		  $tab[0] = $score1;
		  $tab[1] = $score2;
		  return $tab;
		}


		function Matchtime($time)
		{
		  //recuperer le temps dans la bd
		}
		$row = Db::getInstance()->getAllStartedMatch();
		$var = 'score';
		foreach ($row as $value)
		{
		  $scores = Db::getInstance()->getScore($value['id']);
		  $tab = array(0,0);
		  $tab = game($scores[0]['pointd'], $scores[0]['pointe']);
		  Db::getInstance()->addscore($tab[0],$tab[1], $value['id']);
		  //Db::getInstance()->addtime(1,$value['id']);
		  $scored = $tab[0] + $scores[0]['pointd'];
		  $scoree = $tab[1] + $scores[0]['pointe'];
		  $scores = $scored.'-'.$scoree;
		  $js = '<script type="text/javascript">'
			  .'var id = "<?php echo $value[\'id\']; ?>";'
			  .'document.getElementById(\'score\' + id).innerHTML = "?php echo $scores; ?>";'
		      .'</script>';
		  $changeAll='yes';
		}
		echo $var;
	}
	else
	{
		$row = Db::getInstance()->getAllStartedMatch();
		if(!empty($row)){
			$changeAll = 'yes';
		}
	}

}else{
	$row = Db::getInstance()->getAllStartedMatch();
	if(!empty($row)){
		$changeAll = 'yes';
	}
}

echo $changeAll;


?>
