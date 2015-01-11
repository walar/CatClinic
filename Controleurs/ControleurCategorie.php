<?php

final class ControleurCategorie
{
  // retourne la catégorie correspondant à l'indentifiant
  //   ou 'false' si aucune catégorie n'a pu être récuperée
  private function _donneCategorieParIdentifiant($I_identifiantCategorie)
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

  public function defautAction()
  {
    BoiteAOutils::redirigerVers('categorie/liste');
  }

  public function listeAction()
  {
    if (BoiteAOutils::donneMethodeRequete() === 'POST')
    {
      if (isset($_POST['nb_categorie_par_page']))
      {
        $I_CatParPage = intval($_POST['nb_categorie_par_page']);

        if ($I_CatParPage > 0)
        {
          BoiteAOutils::rangerDansSession('nb_categorie_par_page', $I_CatParPage);
        }
      }

      /*
       on redirige vers la liste
      */
       BoiteAOutils::redirigerVers('categorie/liste');
     }
     else
     {
      $this->paginerAction();
    }
  }

  public function paginerAction(Array $A_parametres = null)
  {
    $I_page = isset($A_parametres[0]) ? $A_parametres[0] : 1;

    $A_parametresVue = array();

    $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());

    $O_listeur = new ListeurCategorie($O_categorieMapper);

    if (isset($A_parametres[1]) && !strncmp($A_parametres[1], 'tri-', 4))
    {
      /*
        ce parametre est sous la forme 'tri-$attribut-$ordre'
        avec '$ordre' optionnel (par defaut 'asc')
        donc on concatene '-defaut' pour être sure de recupérer une valeure pour l'ordre de tri
      */

        $S_tri = $A_parametres[1] . '-defaut';

        list( /* tri */, $S_attributTri, $S_ordreTri) = explode('-', $S_tri);

      /*
        Si l'attribut de tri a été changé on l'ajoute aux parametres de la vue
        pour pouvoir definir les nouvelles urls du paginateur
      */
        if (false !== $O_listeur->changeAttributTri($S_attributTri))
        {
          $A_parametresVue['tri'] = 'tri-' . $S_attributTri;

          if (false !== $O_listeur->changeOrdreTri($S_ordreTri))
          {
            $A_parametresVue['tri'] .= '-' . $S_ordreTri;
          }
        }
      }

      $O_paginateur = new Paginateur($O_listeur);
      $I_limit = BoiteAOutils::recupererDepuisSession('nb_categorie_par_page');

      if (is_null($I_limit))
      {
        $I_limit = Constantes::NB_DEFAULT_CATEGORIES_PAR_PAGE;
      }

      $O_paginateur->changeLimite($I_limit);

      $A_categories = $O_paginateur->recupererPage($I_page);

      $A_pagination = $O_paginateur->paginer();

      $A_parametresVue['categories'] = $A_categories;
      $A_parametresVue['pagination'] = $A_pagination;
      $A_parametresVue['nb_categorie_par_page'] = $I_limit;
      $A_parametresVue['entite_par_page'] = explode(',', Constantes::ENTITE_PAR_PAGE);

      Vue::montrer ('categorie/liste', $A_parametresVue);
    }

    public function supprAction(Array $A_parametres)
    {
      $I_identifiantCategorie = $A_parametres[0];

      $O_categorie = $this->_donneCategorieParIdentifiant($I_identifiantCategorie);

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

      $O_categorie = $this->_donneCategorieParIdentifiant($I_identifiantCategorie);

      if (false === $O_categorie)
      {
      // impossible de récupérer une catégorie

        BoiteAOutils::redirigerVers('categorie/liste');
      }
      else if (BoiteAOutils::donneMethodeRequete() === 'PUT')
      {
        // on modifie la catégorie en bdd
        $A_params = array();
        $A_params['titre'] = $_POST['titre'];

        $O_validateur = new ValidateurCategorie($O_categorie, $A_params);

        if ($O_validateur->estValide())
        {
          $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
          $O_categorieMapper->actualiser($O_categorie);

          // on redirige vers la liste !
          BoiteAOutils::redirigerVers('categorie/liste');
        }
        else
        {
          Vue::montrer('categorie/edit', array(
                       'categorie' => $O_categorie,
                       'validateur' => $O_validateur
                       ));
        }
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
        $A_params = array();
        $A_params['titre'] = $_POST['titre'];

        $O_categorie = new Categorie();

        $O_validateur = new ValidateurCategorie($O_categorie, $A_params);

        if ($O_validateur->estValide())
        {
          $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
          $O_categorieMapper->creer($O_categorie);

          // on redirige vers la liste !
          BoiteAOutils::redirigerVers('categorie/liste');
        }
        else
        {
          Vue::montrer('categorie/creer', array(
                       'validateur' => $O_validateur
                       ));
        }
      }
      else
      {
      // on affiche notre formulaire

        Vue::montrer('categorie/creer');
      }
    }
  }
