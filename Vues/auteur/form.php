<?php
/*
  utilisé pour afficher le formulaire de création ou d'édition d'une catégorie
*/
if (isset($A_vue['auteur']))
{
  $O_auteur = $A_vue['auteur'];
}

if (isset($A_vue['validateur']))
{
  $O_validateur = $A_vue['validateur'];
}

?>

<p>
  <?php
    $S_nom = isset($O_auteur)?$O_auteur->donneNom():'';
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
    $S_prenom = isset($O_auteur)?$O_auteur->donnePrenom():'';
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
    $S_mail = isset($O_auteur)?$O_auteur->donneMail():'';
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
