<div class="panel-group">
  <div class="row">
    <div class="col-lg-5 col-md-5 col-sm-5">
    <div class="panel panel-info">
      <div class="panel-heading">Pertes/Gains</div>
      <div class="panel-body">
        <?php $table = '<table class="table table-hover"><thead><tr><th>Match</th>'
                    .'<th>Equipe</th><th>Pari</th><th>Résultat</th></tr></thead><tbdoy>';
              $row = Db::getInstance()->getOldBet($_SESSION['id']);

              foreach ($row as $value)
              {
                $table .= '<tr><td>'.$value['equipes']
                       .'</td><td>'.$value['team'].'</td><td>'.$value['sum'].'</td><td>';
                if($value['team'] == $value['gagnant'])
                {
                  if($value['Payer'] == 0)
                  {
                    $prix = $value['sum']*$value['cote'];
                    Db::getInstance()->updateCredit($prix,$_SESSION['id']);
                    Db::getInstance()->hasBeenPayed($value['id']);
                    ?>
                    <script type="text/javascript">
                      location.reload();
                    </script>
                    <?php
                  }
                  $table .=$value['sum']*$value['cote'];
                }
                else
                {
                  $table .='Perte';
                  Db::getInstance()->hasBeenPayed($value['id']);
                }
                $table .= '</td></tr>';
              }
              $table .='</tbody></table>';
              echo $table;
        ?>
      </div>
    </div>
    </div>

    <div class="col-lg-7 col-md-7 col-sm-7">
    <div class="panel panel-info">
      <div class="panel-heading">Paris en cours</div>
      <div class="panel-body">
        <?php $table = '<table class="table table-hover"><thead><tr><th>Match</th>'
                    .'<th>Equipe</th><th>Pari</th></tr></thead><tbdoy>';
              $row = Db::getInstance()->getBetByUser($_SESSION['id']);
              if(!empty($row))
              {
                foreach ($row as $value)
                {
                  $table .= '<tr><td>';
                  $table .= $value['equipes']
                         .'</td><td>'.$value['team'].'</td><td>'.$value['sum'].'</td></tr>';
                }
              }
              else
              {
                $table .='<tr><td colspan="3">Aucuns paris en cours</td></tr>';
              }

              $table .='</tbody></table>';
              echo $table;
        ?>
      </div>
    </div>
    </div>
  </div>
</div>
