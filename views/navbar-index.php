<nav class="navbar navbar-inverse navbar-fixed-to-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="index.php" style="display: center"><img class="img-circle" align="left" style="max-width:20%; max-height:20%;"  src="basketball.png">
      <h2 style="color:white">B<span style="color:#cc0000">bet</span></h2></a>
    </div>
	<!--Modal connexion-->
	<div class="modal fade" id="connexionModal" tabindex="-1" role="dialog" aria-labelledby="connexionModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" id="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
            <p class="alert alert-danger" id="error">Login et/ou mot de passe erroné(s)</p>
            <p class="alert alert-danger" id="incomplete">Veuillez remplir touts les champs</p>
						<div class="form-group">
						  <input type="text" class="form-control" name="login" id="login" placeholder="Login"/>
						</div>
						<div class="form-group">
						  <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Mot de Passe"/>
						</div>
						<button class="btn btn-danger" name="send" id="connect" value="connect">Se connecter</button>
				</div>
			</div>
		</div>
	</div>
  <!--Modal inscription-->
	<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" id="close2" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
          <div id="error_list">
            <p class="alert alert-danger" id="register_incomplete">Veuillez remplir touts les champs</p>
			<p class="alert alert-danger" id="wrong_data"></p>
			<p class="alert alert-success" id="wait">Votre compte a été crée</p>
          </div>
            <div class="form-group row">
                <div class="col-xs-12">
                  <input class="form-control" type="text" placeholder="Nom d'utilisateur"  id="user">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-xs-12">
                  <input class="form-control" type="password" placeholder="Mot de passe" id="pass">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-xs-12">
                  <input class="form-control" type="password" placeholder="Retaper le mot de passe" id="pass2">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-xs-12">
                  <input class="form-control" type="email" placeholder="example@mail.com" id="mail">
                </div>
              </div>


              <div class="form-group row">
                <div class="col-xs-4">
                  <?php
                  $maxYear = date('Y') - 60;
                  $minYear = date('Y') - 18;
                  echo '<select name="year" id="year" class="form-control">';
                  echo '<option value="" selected disabled>Année</option>';
                  for ($i=$minYear; $i > $maxYear ; $i--) {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                  echo '</select></div>';
                  echo '<div class="col-xs-4"><select name="month" id="month" class="form-control">';
                  echo '<option value="" selected disabled>Mois</option>';
                  for ($i=1; $i <= 12; $i++) {
                    if($i<0){
                      echo '<option value="0'.$i.'">'.$i.'</option>';
                    }
                    else {
                      echo '<option value="'.$i.'">'.$i.'</option>';
                    }

                  }
                  echo '</select></div>';
                  echo '<div class="col-xs-4"><select name="day" id="day" class="form-control">';
                  echo '<option value="" selected disabled>Jour</option>';
                  for ($i=1; $i <= 31 ; $i++) {
                    if($i<0){
                      echo '<option value="0'.$i.'">'.$i.'</option>';
                    }
                    else {
                      echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                  }
                  echo '</select>';
                  ?>
                </div>
              </div>

              <div class="form-group row">
                <div class="col-xs-12">
                  <input class="form-control" type="text" placeholder="Adresse" id="adress">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-xs-12">
                  <input class="form-control" type="text" placeholder="Ville" id="city">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-xs-12">
                  <select name="work" id="work" class="form-control">
                      <option value="" selected disabled>Profession</option>
                      <option value="independant">Indépendant</option>
                      <option value="employé">Employé</option>
                      <option value="sans emploi">Sans Emploi</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-lg-12">
                  <input type="checkbox" id="terms">&nbsp; Je confirme avoir l’âge légal pour parier et
                    j’accepte les Termes et Conditions et la Politique de Confidentialité.</input>
                  </label>
                </div>
              </div>
              <div class="register">
                <button class="btn btn-danger" name="send" id="register">S'inscrire</button>
              </div>
				</div>
			</div>
		</div>
	</div>
  <!--modal charger credit-->
  <div class="modal fade" id="creditModal" tabindex="-1" role="dialog" aria-labelledby="creditModal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" id="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">
            <p class="alert alert-danger" id="credit_error"></p>
            <p class="alert alert-danger" id="credit_incomplete">Veuillez remplir touts les champs</p>
						<div class="form-group">
						  <input type="email" class="form-control" name="email" id='credit_mail' placeholder="Votre email">
						</div>
						<div class="form-group">
						  <input type="password" class="form-control" name="pwd" id="credit_pass" placeholder="Mot de Passe"/>
						</div>
            <div class="form-group">
						  <input type="number" class="form-control" name="credit" id='credit' placeholder="Le crédit à charger">
						</div>
						<button class="btn btn-danger" name="send" id="charge" value="connect">Se connecter</button>
				</div>
			</div>
		</div>
	</div>
	<!--elements du navbar-->
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav navbar-right">
    <?php if(isset($_SESSION['name']))
    {?>

	  <?php if($_SESSION['id']==1) {?>
        <li><a href="?send=addmatch" id="addMatch" >Ajouter des matchs</a></li>
        <li><a href="?send=new" id="newUsers" >Utilisateurs Potentiels</a></li>
		<?php }else {?>
        <li><a>Credit:<span class="" id="panier"><?php echo " ".$_SESSION['credit']."€"; ?></span></a></li>
    <?php }?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['name']; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php if($_SESSION['id']!=1) {?>
            <li><a href="?send=history">Historique</a></li>
            <li><a data-toggle="modal" data-target="#creditModal">Charger Credit</a></li>
            <?php }?>
            <li><a href="?send=newpwd">Changer de mot de passe</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Se deconnecter</a></li>
          </ul>
        </li>
	 <?php
      }
      else
      {?>
		<li><button class="btn navbar-btn btn-danger btn-connexion" data-toggle="modal" data-target="#connexionModal">Se connecter</button></li>
    <li>&nbsp;&nbsp;&nbsp;</li>
		<li><button class="btn navbar-btn btn-danger btn-connexion" data-toggle="modal" data-target="#registerModal">S'inscrire</button></li>
	  <?php } ?>
	</ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
  <div class="container">
