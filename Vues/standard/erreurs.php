<?php
$S_erreur = BoiteAOutils::recupererDepuisSession('erreur', false); // on veut la détruire après affichage, d'où le false
?>

<?php if (isset($S_erreur)): ?>
  <div data-alert class="alert-box alert">
    <?php echo $S_erreur; ?>
    <a href="#" class="close">&times;</a>
  </div>
<?php endif; ?>
