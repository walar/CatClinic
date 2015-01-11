<?php
/*
  utilisé pour afficher le formulaire de création ou d'édition d'une catégorie
*/

$A_auteurs = $A_vue['auteurs'];
$A_categories = $A_vue['categories'];

$S_titre = '';
$I_idAuteur = -1;
$I_idCategorie = -1;
$S_contenu = '';

if (isset($A_vue['validateur']))
{
  $O_validateur = $A_vue['validateur'];

  $S_titre = $O_validateur->donneParam('titre');
  $I_idAuteur = $O_validateur->donneParam('auteur');
  $I_idCategorie = $O_validateur->donneParam('categorie');
  $S_contenu = $O_validateur->donneParam('contenu');
}
else if (isset($A_vue['article']))
{
  $O_article = $A_vue['article'];

  $S_titre = $O_article->donneTitre();
  $I_idAuteur = $O_article->donneAuteur() ? $O_article->donneAuteur()->donneIdentifiant() : -1;
  $I_idCategorie = $O_article->donneCategorie() ? $O_article->donneCategorie()->donneIdentifiant() : -1;
  $S_contenu = $O_article->donneContenu();
}

?>

<!-- titre -->
<p>
  <?php
    $B_erreur = isset($O_validateur) && !$O_validateur->estValide('titre');
  ?>
  <label for="titre" title="Veuillez saisir un titre" class="<?php echo $B_erreur?'error':''; ?>">Titre
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

<!-- auteur -->
<p>
  <?php
    $B_erreur = isset($O_validateur) && !$O_validateur->estValide('auteur');
  ?>
  <label for="auteur" title="Veuillez choisir un auteur" class="<?php echo $B_erreur?'error':''; ?>">Auteur
    <select name="auteur" id="auteur" required>
      <?php foreach ($A_auteurs as $O_auteur): ?>
        <?php
          $I_idAuteurCourant = $O_auteur->donneIdentifiant();
          $S_valeur = $O_auteur->donneNomComplet();
          $B_selected = $I_idAuteurCourant == $I_idAuteur;
        ?>
        <option value="<?php echo $I_idAuteurCourant; ?>" <?php if ($B_selected) echo 'selected'; ?>>
          <?php echo $S_valeur; ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>
  <?php if ($B_erreur): ?>
    <small class="error">
      <?php echo $O_validateur->donneErreur("auteur") ?>
    </small>
  <?php endif; ?>
</p>

<!-- categorie -->
<p>
  <?php
    $B_erreur = isset($O_validateur) && !$O_validateur->estValide('categorie');
  ?>
  <label for="categorie" title="Veuillez choisir une catégorie" class="<?php echo $B_erreur?'error':''; ?>">Catégorie
    <select name="categorie" id="categorie" required>
      <?php foreach ($A_categories as $O_categorie): ?>
        <?php
          $I_idCategorieCourante = $O_categorie->donneIdentifiant();
          $S_valeur = $O_categorie->donneTitre();
          $B_selected = $I_idCategorieCourante == $I_idCategorie;
        ?>
        <option value="<?php echo $I_idCategorieCourante; ?>" <?php if ($B_selected) echo 'selected'; ?>>
          <?php echo $S_valeur; ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>
  <?php if ($B_erreur): ?>
    <small class="error">
      <?php echo $O_validateur->donneErreur("categorie") ?>
    </small>
  <?php endif; ?>
</p>

<!-- contenu -->
<p>
  <?php
    $B_erreur = isset($O_validateur) && !$O_validateur->estValide('contenu');
  ?>
  <label for="contenu" title="Veuillez saisir un contenu" class="<?php echo $B_erreur?'error':''; ?>">Contenu
    <textarea name="contenu" id="contenu" title="Veuillez saisir le contenu de l'article" rows="10" cols="50"><?php echo $S_contenu; ?></textarea>
  </label>
  <?php if ($B_erreur): ?>
    <small class="error">
      <?php echo $O_validateur->donneErreur("contenu") ?>
    </small>
  <?php endif; ?>
</p>
