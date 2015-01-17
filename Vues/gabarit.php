<!DOCTYPE html>

<?php
$S_ressourcePath = "/Ressources/Public";
?>
<!--
  Grâce à modernizr, la classe "no-js" nous permet de détecter si javascript est activé
-->
<html class="no-js" lang="fr">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>Cat Clinic - Console de gestion</title>

  <link rel="stylesheet" type="text/css" href="<?php echo $S_ressourcePath; ?>/css/app.css" />

  <script src="<?php echo $S_ressourcePath; ?>/vendor/modernizr/modernizr.js"></script>
</head>

<body id="top">
  <header>
    <?php Vue::montrer('standard/entete'); ?>
  </header>

  <main class="row">
    <?php Vue::montrer('standard/erreurs'); ?>

    <div class="small-12 columns">
      <?php echo $A_vue['body']; ?>
    </div>
  </main>

  <footer>
    <?php Vue::montrer('standard/pied'); ?>
  </footer>

  <script type="text/javascript" src="<?php echo $S_ressourcePath; ?>/vendor/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $S_ressourcePath; ?>/vendor/tinymce/tinymce.js"></script>
  <script type="text/javascript" src="<?php echo $S_ressourcePath; ?>/vendor/foundation/js/foundation.js"></script>
  <script type="text/javascript" src="<?php echo $S_ressourcePath; ?>/js/app.js"></script>
</body>

</html>
