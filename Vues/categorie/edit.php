<?php
    $O_categorie = $A_vue['categorie'];
?>

<h1>Editer la catégorie "<?php echo $O_categorie->donneTitre(); ?>"</h1>

<form name="categorie" id="categorie" method="post"
        action="/categorie/edit/<?php echo $O_categorie->donneIdentifiant(); ?>">

  <input type="hidden" name="_method" value="PUT" />

  <div id="corpForm">
    <p>
      <label for="titre" title="Veuillez saisir un titre">Catégorie</label>
      <input type="text" name="titre" id="titre" title="Veuillez saisir un titre"
              value="<?php echo $O_categorie->donneTitre(); ?>" required />
    </p>
  </div>

  <div id="piedForm">
    <input type="submit" name="valid" id="valid" value="Mettre à jour" title="Cliquez sur ce bouton pour modifier la catégorie" />
  </div>

</form>
