<?php
    $O_article = $A_vue['article'];
?>
<h1>Supprimer l'article "<?php echo $O_article->donneTitre(); ?>"</h1>
<form name="article"
      id="article"
      method="post"
      action="/article/suppr/<?php echo $O_article->donneIdentifiant(); ?>">
    <input type="hidden" name="_method" value="DELETE" />
    <div id="corpForm">
        <p>
            Êtes-vous sur de vouloir supprimer l'article "<?php echo $O_article->donneTitre(); ?>" ? <br />
        </p>
    </div>

    <div id="piedForm">
        <a href="/article/liste">Retour</a>

        <input type="submit" name="Supprimer" id="supprimer" value="Supprimer" title="Cliquez sur ce bouton pour supprimer l'article" />
    </div>
</form>
