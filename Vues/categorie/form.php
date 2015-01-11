<?php
/*
  utilisé pour afficher le formulaire de création ou d'édition d'une catégorie
*/

$S_titre = '';

if (isset($A_vue['validateur']))
{
  $O_validateur = $A_vue['validateur'];

  $S_titre = $O_validateur->donneParam('titre');
}
else if (isset($A_vue['categorie']))
{
  $O_categorie = $A_vue['categorie'];

  $S_titre = $O_categorie->donneTitre();
}

?>

<p>
  <?php
    $B_erreur = isset($O_validateur) && !$O_validateur->estValide('titre');
  ?>

  <label for="titre" title="Veuillez saisir un titre" class="<?php echo $B_erreur?'error':''; ?>">Catégorie
  <input type="text" name="titre" id="titre"
          title="Veuillez saisir un titre"
          value="<?php echo $S_titre; ?>"
          required />
  </label>
  <?php if ($B_erreur): ?>
    <small class="error">
      <?php echo $O_validateur->donneErreur("titre") ?>
    </small>
  <?php endif; ?>
</p>
