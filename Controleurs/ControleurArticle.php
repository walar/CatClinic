<?php

final class ControleurArticle
{
  // retourne l'article correspondant à l'indentifiant
  //   ou 'false' si aucun article n'a pu être récuperé
  private function _donneArticleParIdentifiant($I_identifiant)
  {
    if (!$I_identifiant)
    {
      return false;
    }

    // l'identifiant donné correspond t-il à une entrée en base ?
    try
    {
      $O_mapper = FabriqueDeMappers::fabriquer('article', Connexion::recupererInstance());
      $O_article = $O_mapper->trouverParIdentifiant($I_identifiant);
    }
    catch (Exception $O_exception)
    {
      // L'identifiant passé ne correspond à rien...
      return false;
    }

    return $O_article;
  }

  private function _donneToutesLesCategories()
  {
    $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
    $O_categorieListeur = new ListeurCategorie($O_categorieMapper);
    return $A_categories = $O_categorieListeur->lister();
  }

  private function _donneTousLesAuteurs()
  {
    $O_auteurMapper = FabriqueDeMappers::fabriquer('auteur', Connexion::recupererInstance());
    $O_auteurListeur = new ListeurAuteur($O_auteurMapper);
    return $A_categories = $O_auteurListeur->lister();
  }

  public function defautAction()
  {
    BoiteAOutils::redirigerVers('article/liste');
  }

  public function listeAction()
  {
    if (BoiteAOutils::donneMethodeRequete() === 'POST')
    {
      if (isset($_POST['nb_article_par_page']))
      {
        $I_articleParPage = intval($_POST['nb_article_par_page']);

        if ($I_articleParPage > 0)
        {
          BoiteAOutils::rangerDansSession('nb_article_par_page', $I_articleParPage);
        }
      }

      /*
       on redirige vers la liste
      */
       BoiteAOutils::redirigerVers('article/liste');
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

    $O_mapper = FabriqueDeMappers::fabriquer('article', Connexion::recupererInstance());

    $O_listeur = new ListeurArticle($O_mapper);

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
      $I_limit = BoiteAOutils::recupererDepuisSession('nb_article_par_page');

      if (is_null($I_limit))
      {
        $I_limit = Constantes::NB_DEFAULT_ARTICLES_PAR_PAGE;
      }

      $O_paginateur->changeLimite($I_limit);

      $A_articles = $O_paginateur->recupererPage($I_page);

      $A_pagination = $O_paginateur->paginer();

      $A_parametresVue['articles'] = $A_articles;
      $A_parametresVue['pagination'] = $A_pagination;
      $A_parametresVue['nb_article_par_page'] = $I_limit;
      $A_parametresVue['entite_par_page'] = explode(',', Constantes::ENTITE_PAR_PAGE);

      Vue::montrer ('article/liste', $A_parametresVue);
    }

    public function supprAction(Array $A_parametres)
    {
      $I_identifiant = $A_parametres[0];

      $O_article = $this->_donneArticleParIdentifiant($I_identifiant);

      if (false === $O_article)
      {
      // impossible de récupérer une catégorie

        BoiteAOutils::redirigerVers('article/liste');
      }
      else if (BoiteAOutils::donneMethodeRequete() === 'DELETE')
      {
      // on supprime l'article de la bdd

        $O_mapper = FabriqueDeMappers::fabriquer('article', Connexion::recupererInstance());
        $O_mapper->supprimer($O_article);

      // on redirige vers la liste !
        BoiteAOutils::redirigerVers('article/liste');
      }
      else
      {
      // on affiche le formulaire

        Vue::montrer('article/suppr', array('article' => $O_article));
      }
    }

    public function editAction(Array $A_parametres)
    {
      $I_identifiant = $A_parametres[0];

      $O_article = $this->_donneArticleParIdentifiant($I_identifiant);

      if (false === $O_article)
      {
      // impossible de récupérer une catégorie

        BoiteAOutils::redirigerVers('article/liste');
      }
      else if (BoiteAOutils::donneMethodeRequete() === 'PUT')
      {
        // on modifie la catégorie en bdd
        $A_params = array();
        $A_params['titre'] = $_POST['titre'];
        $A_params['contenu'] = $_POST['contenu'];
        $A_params['categorie'] = $_POST['categorie'];
        $A_params['auteur'] = $_POST['auteur'];

        $O_validateur = new ValidateurArticle($O_article, $A_params);

        if ($O_validateur->estValide())
        {
          $O_mapper = FabriqueDeMappers::fabriquer('article', Connexion::recupererInstance());
          $O_mapper->actualiser($O_article);

          // on redirige vers la liste !
          BoiteAOutils::redirigerVers('article/liste');
        }
        else
        {
          Vue::montrer('article/edit', array(
                        'article' => $O_article,
                        'validateur' => $O_validateur,
                        'categories' => $this->_donneToutesLesCategories(),
                        'auteurs' => $this->_donneTousLesAuteurs()
          ));
        }
      }
      else
      {
        // on affiche notre formulaire
        Vue::montrer('article/edit', array(
                      'article' => $O_article,
                      'categories' => $this->_donneToutesLesCategories(),
                      'auteurs' => $this->_donneTousLesAuteurs()
        ));
      }
    }

    public function creerAction(Array $A_parametres)
    {
      if (BoiteAOutils::donneMethodeRequete() === 'POST')
      {
        // on créer la catégorie en bdd
        $A_params = array();
        $A_params['titre'] = $_POST['titre'];
        $A_params['contenu'] = $_POST['contenu'];
        $A_params['categorie'] = $_POST['categorie'];
        $A_params['auteur'] = $_POST['auteur'];

        $O_article = new Article();

        $O_validateur = new ValidateurArticle($O_article, $A_params);

        if ($O_validateur->estValide())
        {
          $O_mapper = FabriqueDeMappers::fabriquer('article', Connexion::recupererInstance());
          $O_mapper->creer($O_article);

          // on redirige vers la liste !
          BoiteAOutils::redirigerVers('article/liste');
        }
        else
        {
          Vue::montrer('article/creer', array(
                        'validateur' => $O_validateur,
                        'categories' => $this->_donneToutesLesCategories(),
                        'auteurs' => $this->_donneTousLesAuteurs()
          ));
        }
      }
      else
      {
      // on affiche notre formulaire

        Vue::montrer('article/creer', array(
                      'categories' => $this->_donneToutesLesCategories(),
                      'auteurs' => $this->_donneTousLesAuteurs()
        ));
      }
    }
  }
