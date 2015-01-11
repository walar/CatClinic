<?php
    $O_auteur = $A_vue['auteur'];
?>
<h1>Supprimer l'auteur "<?php echo $O_auteur->donneNomComplet(); ?>"</h1>
<form name="auteur"
      id="auteur"
      method="post"
      action="/auteur/suppr/<?php echo $O_auteur->donneIdentifiant(); ?>">
    <input type="hidden" name="_method" value="DELETE" />
    <div id="corpForm">
        <p>
            Êtes-vous sur de vouloir supprimer l'auteur "<?php echo $O_auteur->donneNomComplet(); ?>" ? <br />
            <strong>Attention: Cela supprimera tous les articles liés à cet auteur !</strong>
        </p>
    </div>

    <div id="piedForm">
        <a href="/auteur/liste">Retour</a>

        <input type="submit" name="Supprimer" id="supprimer" value="Supprimer" title="Cliquez sur ce bouton pour supprimer l'auteur" />
    </div>
</form>
