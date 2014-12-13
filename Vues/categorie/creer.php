<h1>Créer une catégorie</h1>

<form name="categorie" id="categorie" method="post" action="/categorie/creer">
  <div id="corpForm">
    <p>
      <label for="titre" title="Veuillez saisir un titre">Catégorie</label>
      <input type="text" name="titre" id="titre" title="Veuillez saisir un titre" required/>
    </p>
  </div>

  <div id="piedForm">
    <input type="submit" name="valid" id="valid" value="Créer" title="Cliquez sur ce bouton pour creer la catégorie" />
  </div>
</form>
