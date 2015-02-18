<?php
$S_erreur = BoiteAOutils::recupererDepuisSession('erreur', true); // on veut la détruire après affichage, d'où le true
?>

<?php if (isset($S_erreur)): ?>
  <div data-alert class="alert-box alert radius">
    <?php echo $S_erreur; ?>
    <a href="#" class="close">&times;</a>
  </div>
<?php endif; ?>
