<?php
    $O_auteur = $A_vue['auteur'];
?>

<h1>Editer l'auteur "<?php echo strtoupper($O_auteur->donneNom()) . ' ' . $O_auteur->donnePrenom(); ?>"</h1>

<form name="auteur" id="auteur" method="post"
        action="/auteur/edit/<?php echo $O_auteur->donneIdentifiant(); ?>">

  <input type="hidden" name="_method" value="PUT" />

  <div id="corpForm">
    <?php include 'form.php'; ?>
  </div>

  <div id="piedForm">
    <input type="submit" name="valid" id="valid" value="Mettre à jour" title="Cliquez sur ce bouton pour modifier l'auteur" />
  </div>

</form>
