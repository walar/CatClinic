<?php
/*
  utilisé pour afficher le formulaire de création ou d'édition d'une catégorie
*/

$S_nom = '';
$S_prenom = '';
$S_mail = '';

if (isset($A_vue['validateur']))
{
  $O_validateur = $A_vue['validateur'];

  $S_nom = $O_validateur->donneParam('nom');
  $S_prenom = $O_validateur->donneParam('prenom');
  $S_mail = $O_validateur->donneParam('mail');
}
else if (isset($A_vue['auteur']))
{
  $O_auteur = $A_vue['auteur'];

  $S_nom = $O_auteur->donneNom();
  $S_prenom = $O_auteur->donnePrenom();
  $S_mail = $O_auteur->donneMail();
}

?>

<p>
  <?php
    $B_erreur = isset($O_validateur) && !$O_validateur->estValide('nom');
  ?>
  <label for="nom" title="Veuillez saisir un nom" class="<?php echo $B_erreur?'error':''; ?>">Nom
  <input type="text" name="nom" id="nom"
          title="Veuillez saisir un nom"
          value="<?php echo $S_nom; ?>"
          required />
  </label>
  <?php if ($B_erreur): ?>
    <small class="error">
      <?php echo $O_validateur->donneErreur("nom") ?>
    </small>
  <?php endif; ?>
</p>

<p>
  <?php
    $B_erreur = isset($O_validateur) && !$O_validateur->estValide('prenom');
  ?>
  <label for="prenom" title="Veuillez saisir un prenom" class="<?php echo $B_erreur?'error':''; ?>">Prenom
  <input type="text" name="prenom" id="prenom"
          title="Veuillez saisir un prenom"
          value="<?php echo $S_prenom; ?>"
          required />
  </label>
  <?php if ($B_erreur): ?>
    <small class="error">
      <?php echo $O_validateur->donneErreur("prenom") ?>
    </small>
  <?php endif; ?>
</p>

<p>
  <?php
    $B_erreur = isset($O_validateur) && !$O_validateur->estValide('mail');
  ?>
  <label for="mail" title="Veuillez saisir un mail" class="<?php echo $B_erreur?'error':''; ?>">Mail
  <input type="email" name="mail" id="mail"
          title="Veuillez saisir un mail"
          value="<?php echo $S_mail; ?>"
          required />
  </label>
  <?php if ($B_erreur): ?>
    <small class="error">
      <?php echo $O_validateur->donneErreur("mail") ?>
    </small>
  <?php endif; ?>
</p>
