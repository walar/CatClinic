<h1>Créer une catégorie</h1>
<form name="categorie"
      id="categorie"
      method="post"
      action="/categorie/creer"
      onsubmit="return validateForm(this)">
    <div id="corpForm">
        <p>
            <label for="titre" title="Veuillez saisir un titre" class="oblig">* Titre :</label>
            <input type="text" name="titre" id="titre" title="Veuillez saisir un titre" tabindex="1"
                   onfocus="this.className='focus';"
                   onblur="this.className='normal';"
                   onchange="javascript:this.value=this.value.toLowerCase();" />
            <span class="legende">ex : 'catégorie1'</span>
        </p>
        <br />
        <em>* Champs obligatoires</em>
    </div>
    <div id="piedForm">
        <input type="submit" name="valid" id="valid" value="Mettre à jour" title="Cliquez sur ce bouton pour creer la catégorie" tabindex="9" />
    </div>
</form>
