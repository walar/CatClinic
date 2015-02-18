<?php
  $S_REQUEST_URI = $_SERVER['REQUEST_URI'];

  if (Authentification::estConnecte())
  {
    $A_liens = array();

    if (Authentification::estAdministrateur())
    {
      $A_liens['/utilisateur'] = 'Utilisateurs';
      $A_liens['/article'] = 'Articles';
      $A_liens['/auteur'] = 'Auteurs';
      $A_liens['/categorie'] = 'Catégories';
    }
    else if (BoiteAOutils::recupererDepuisSession('utilisateur')->estProprietaire())
    {
      $A_liens['/proprietaire/visites'] = 'Mes chats';
    }
  }
?>

<nav class="top-bar" data-topbar role="navigation">
  <ul class="title-area">
    <li class="name">
      <h1><a href="/">Cat Clinic</a></h1>
    </li>
     <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
  </ul>

  <section class="top-bar-section">
    <!-- Right Nav Section -->
    <ul class="right">
      <li class="has-form">
        <?php if (Authentification::estConnecte()): ?>
          <a href="/logout" class="button radius">Deconnexion <strong><?php echo BoiteAOutils::recupererDepuisSession('utilisateur')->donneLogin(); ?></strong></a>
        <?php else: ?>
          <a href="/login" class="button radius">Connexion</a>
        <?php endif; ?>
      </li>
    </ul>

    <!-- Left Nav Section -->
    <?php if (isset($A_liens)): ?>
      <ul class="left">
        <?php foreach ($A_liens as $S_lien => $S_titre): ?>
          <?php if ($S_REQUEST_URI == $S_lien || (strlen($S_lien) > 1 && stripos($S_REQUEST_URI, $S_lien) !== false)): ?>
            <li class="active">
          <?php else: ?>
            <li>
          <?php endif; ?>
            <a href="<?php echo $S_lien; ?>"><?php echo $S_titre; ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>
</nav>
