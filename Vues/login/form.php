<h1>Cat Clinic - Connexion</h1>

<?php
    // l'authentification de l'utilisateur a pu échouer et néanmoins positionner l'identifiant de l'utilisateur
    // il ira dans l'attribut "value" de notre zone de texte
    $S_identifiant = BoiteAOutils::recupererDepuisSession('login');
?>

<form action="/login/validation" method="post">
    <p class="medium-6 medium-offset-3 large-4 large-offset-4">
        <label for="login">Identifiant: 
            <input type="text" name="login" id="login" value="<?php echo $S_identifiant; ?>" />
        </label>
    </p>
    <p class="medium-6 medium-offset-3 large-4 large-offset-4">
        <label for="motdepasse">Mot de passe:
            <input type="password" name="motdepasse" id="motdepasse" />
        </label>
    </p>
    <p class="medium-2 medium-offset-5">
        <input id="submit" type="submit" value="Connexion" class="button radius expand" />
    </p>
</form>

 