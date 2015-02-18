<?php
  /*
    Utiliser pour afficher la pagination
  */
?>

<?php if (isset($A_vue['pagination'])): ?>
  <div class="pagination-centered">
    <ul class="pagination" role="menubar" aria-label="Pagination">

      <?php foreach ($A_vue['pagination'] as $I_numeroPage => $S_lien): ?>
          <?php if (isset($S_lien)): ?>
            <?php
              if ($B_estTrie)
              {
                $S_lien .= '/' . $S_tri;
              }
            ?>
            <li><a href="/<?php echo $S_lien; ?>"><?php echo $I_numeroPage; ?></a></li>
          <?php else: ?>
            <li class="current"><a href="#top"><?php echo $I_numeroPage; ?></a></li>
          <?php endif; ?>
      <?php endforeach; ?>

     </ul>
  </div>
<?php endif; ?>
