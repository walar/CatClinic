<?php
    $O_categorie = $A_vue['categorie'];
?>
<h1>Supprimer la catégorie "<?php echo $O_categorie->donneTitre(); ?>"</h1>
<form name="categorie"
      id="categorie"
      method="post"
      action="/categorie/suppr/<?php echo $O_categorie->donneIdentifiant(); ?>">
    <input type="hidden" name="_method" value="DELETE" />
    <div id="corpForm">
        <p>
            Êtes-vous sur de vouloir supprimer la catégorie "<?php echo $O_categorie->donneTitre(); ?>" ? <br />
            <strong>Attention: Cela supprimera tous les articles liés à cette catégorie !</strong>
        </p>
    </div>

    <div id="piedForm">
        <a href="/categorie/liste">Retour</a>

        <input type="submit" name="Supprimer" id="supprimer" value="Supprimer" title="Cliquez sur ce bouton pour supprimer la catégorie" />
    </div>
</form>
