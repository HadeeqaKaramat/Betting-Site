<form class="center_form2" method="get" action="">
    <div class="form-group row">
      <div class="col-xs-12">
        <input class="form-control" type="email" placeholder="example@mail.com" name="mail">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-12">
        <input class="form-control" type="tel" placeholder="0123456789" name="tel">
      </div>
    </div>

    <div class="form-group row">
      <div class="col-xs-12">
        <input class="form-control" type="text" placeholder="Adresse" name="adress">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-12">
        <input class="form-control" type="text" placeholder="Ville" name="city">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-12">
        <select name="work" class="form-control">
            <option value="0" selected disabled>Profession</option>
            <option value="independant">Indépendant</option>
            <option value="employé">Employé</option>
            <option value="sans emploi">Sans Emploi</option>
        </select>
      </div>
    </div>
    <button type="submit" name="send" value="modify" class="btn btn-danger">Enregistrer </button>
  </form>
