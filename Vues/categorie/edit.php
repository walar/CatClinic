<?php
    $O_categorie = $A_vue['categorie'];
?>

<h1>Editer la catégorie "<?php echo $O_categorie->donneTitre(); ?>"</h1>

<form name="categorie" id="categorie" method="post"
        action="/categorie/edit/<?php echo $O_categorie->donneIdentifiant(); ?>">

  <input type="hidden" name="_method" value="PUT" />

  <div id="corpForm">
    <?php include 'form.php'; ?>
  </div>

  <div id="piedForm">
    <input type="submit" name="valid" id="valid" value="Mettre à jour" title="Cliquez sur ce bouton pour modifier la catégorie" />
  </div>

</form>
