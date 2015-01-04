<?php
/*
  utilisé pour afficher le formulaire de création ou d'édition d'une catégorie
*/
?>

<p>
  <label for="titre" title="Veuillez saisir un titre">Catégorie</label>
  <input type="text" name="titre" id="titre"
          title="Veuillez saisir un titre"
          value="<?php echo isset($O_categorie)?$O_categorie->donneTitre():''; ?>"
          required />
</p>
