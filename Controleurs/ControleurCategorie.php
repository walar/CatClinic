<?php

final class ControleurCategorie
{
  // retourne la catégorie correspondant à l'indentifiant
  //   ou 'false' si aucune catégorie n'a pu être récuperée
  private function donneCategorieParIdentifiant($I_identifiantCategorie)
  {
    if (!$I_identifiantCategorie)
    {
      return false;
    }

    // l'identifiant donné correspond t-il à une entrée en base ?
    try
    {
        $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
        $O_categorie = $O_categorieMapper->trouverParIdentifiant($I_identifiantCategorie);
    }
    catch (Exception $O_exception)
    {
        // L'identifiant passé ne correspond à rien...
        return false;
    }

    return $O_categorie;
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

    $O_categorie = $this->donneCategorieParIdentifiant($I_identifiantCategorie);

    if (false === $O_categorie)
    {
      // impossible de récupérer une catégorie

      BoiteAOutils::redirigerVers('categorie/liste');
    }
    else if (BoiteAOutils::donneMethodeRequete() === 'DELETE')
    {
      // on supprime la catégorie de la bdd

      $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
      $O_categorieMapper->supprimer($O_categorie);

      // on redirige vers la liste !
      BoiteAOutils::redirigerVers('categorie/liste');
    }
    else
    {
      // on affiche le formulaire

      Vue::montrer('categorie/suppr', array('categorie' => $O_categorie));
    }
  }

  public function editAction(Array $A_parametres)
  {
    $I_identifiantCategorie = $A_parametres[0];

    $O_categorie = $this->donneCategorieParIdentifiant($I_identifiantCategorie);

    if (false === $O_categorie)
    {
      // impossible de récupérer une catégorie

      BoiteAOutils::redirigerVers('categorie/liste');
    }
    else if (BoiteAOutils::donneMethodeRequete() === 'PUT')
    {
      // on modifie la catégorie en bdd

      $S_titre = $_POST['titre'];
      // TODO: vérifications sur l'input, même si PDO nettoie derrière

      if ($S_titre !== $O_categorie->donneTitre())
      {
          $O_categorie->changeTitre($S_titre);

          $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
          $O_categorieMapper->actualiser($O_categorie);
      }

      // on redirige vers la liste !
      BoiteAOutils::redirigerVers('categorie/liste');
    }
    else
    {
      // on affiche notre formulaire

      Vue::montrer('categorie/edit', array('categorie' => $O_categorie));
    }
  }

  public function creerAction(Array $A_parametres)
  {
    if (BoiteAOutils::donneMethodeRequete() === 'POST')
    {
      // on créer la catégorie en bdd

      $S_titre = $_POST['titre'];
      // TODO: vérifications sur l'input, même si PDO nettoie derrière

      $O_categorie = new Categorie();
      $O_categorie->changeTitre($S_titre);

      $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
      $O_categorieMapper->creer($O_categorie);

      // on redirige vers la liste !
      BoiteAOutils::redirigerVers('categorie/liste');
    }
    else
    {
      // on affiche notre formulaire

      Vue::montrer('categorie/creer');
    }
  }
}
