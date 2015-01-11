<?php
    $O_article = $A_vue['article'];
?>

<h1>Editer l'article "<?php echo $O_article->donneTitre(); ?>"</h1>

<form name="article" id="article" method="post"
        action="/article/edit/<?php echo $O_article->donneIdentifiant(); ?>">

  <input type="hidden" name="_method" value="PUT" />

  <div id="corpForm">
    <?php include 'form.php'; ?>
  </div>

  <div id="piedForm">
    <input type="submit" name="valid" id="valid" value="Mettre à jour" title="Cliquez sur ce bouton pour modifier l'article" />
  </div>

</form>
