<?php
    $O_article = $A_vue['article'];
?>

<h1>Editer l'article "<?php echo $O_article->donneTitre(); ?>"</h1>

<form name="article" id="article" method="post"
        action="/article/edit/<?php echo $O_article->donneIdentifiant(); ?>">

  <input type="hidden" name="_method" value="PUT" />

  <?php include 'form.php'; ?>

  <input type="submit" name="valid" id="valid" value="Mettre à jour" title="Cliquez sur ce bouton pour modifier l'article" class="button radius" />

</form>
