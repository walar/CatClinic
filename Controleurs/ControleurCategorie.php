<?php

final class ControleurCategorie
{

  public function defautAction()
  {
    BoiteAOutils::redirigerVers('categorie/liste');
  }

  public function listeAction()
  {
    $this->paginerAction();
  }

  public function paginerAction(Array $A_parametres = null)
  {
    $I_page = isset($A_parametres[0]) ? $A_parametres[0] : 1;
    $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());

    $O_listeur = new ListeurCategorie($O_categorieMapper);
    $O_paginateur = new Paginateur($O_listeur);
    $O_paginateur->changeLimite(Constantes::NB_MAX_CATEGORIES_PAR_PAGE);

    // on doit afficher puis installer la pagination
    $A_categories = $O_paginateur->recupererPage($I_page);

    $A_pagination = $O_paginateur->paginer();

    // voir ce qu'on met dans categories !
    Vue::montrer ('categorie/liste', array('categories' => $A_categories, 'pagination' => $A_pagination));
  }

  public function supprAction(Array $A_parametres)
  {
    $I_identifiantCategorie = $A_parametres[0];

    $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
    $O_categorie = $O_categorieMapper->trouverParIdentifiant($I_identifiantCategorie);
    $O_categorieMapper->supprimer($O_categorie);

    BoiteAOutils::redirigerVers('categorie/liste');
  }

  public function editAction(Array $A_parametres)
  {
    $I_identifiantCategorie = $A_parametres[0];

    if (!$I_identifiantCategorie)
    {
      // l'identifiant est absent, inutile de continuer !
      // on renvoit vers la liste des categories
      BoiteAOutils::redirigerVers('categorie/liste');
    }
    else
    {
      // l'identifiant donné correspond t-il à une entrée en base ?

      try
      {
          $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
          $O_categorie = $O_categorieMapper->trouverParIdentifiant($I_identifiantCategorie);
      }
      catch (Exception $O_exception)
      {
          // L'identifiant passé ne correspond à rien...
          BoiteAOutils::redirigerVers('categorie/liste');
      }

      // Si l'on est ici c'est qu'on a tout ce qu'il nous faut (une ctégorie !)
      // Nous la passons à la vue correspondante
      Vue::montrer('categorie/edit', array('categorie' => $O_categorie));
    }
  }

  public function miseajourAction(Array $A_parametres)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $I_identifiantCategorie = $A_parametres[0];
      $S_titre = $_POST['titre'];
      // TODO: vérifications sur l'input, même si PDO nettoie derrière

      $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
      $O_categorie = $O_categorieMapper->trouverParIdentifiant($I_identifiantCategorie);

      if ($S_titre != $O_categorie->donneTitre()) {
          $O_categorie->changeTitre($S_titre);
          $O_categorieMapper->actualiser($O_categorie);
      }

      // on redirige vers la liste !
      BoiteAOutils::redirigerVers('categorie/liste');
    }
  }

  public function creerAction(Array $A_parametres)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
      $S_titre = $_POST['titre'];
      // TODO: vérifications sur l'input, même si PDO nettoie derrière

      $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
      $O_categorie = new Categorie();
      $O_categorie->changeTitre($S_titre);

      $O_categorieMapper->creer($O_categorie);

      // on redirige vers la liste !
      BoiteAOutils::redirigerVers('categorie/liste');
    }

    Vue::montrer('categorie/creer');
  }
}
