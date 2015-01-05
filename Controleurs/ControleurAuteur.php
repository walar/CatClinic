<?php

final class ControleurAuteur
{
  // retourne l'auteur correspondant à l'indentifiant
  //   ou 'false' si aucun auteur n'a pu être récuperé
  private function donneAuteurParIdentifiant($I_identifiantAuteur)
  {
    if (!$I_identifiantAuteur)
    {
      return false;
    }

    // l'identifiant donné correspond t-il à une entrée en base ?
    try
    {
      $O_auteurMapper = FabriqueDeMappers::fabriquer('auteur', Connexion::recupererInstance());
      $O_auteur = $O_auteurMapper->trouverParIdentifiant($I_identifiantAuteur);
    }
    catch (Exception $O_exception)
    {
        // L'identifiant passé ne correspond à rien...
      return false;
    }

    return $O_auteur;
  }

  public function defautAction()
  {
    BoiteAOutils::redirigerVers('auteur/liste');
  }

  public function listeAction()
  {
    if (BoiteAOutils::donneMethodeRequete() === 'POST')
    {
      if (isset($_POST['nb_auteur_par_page']))
      {
        $I_AuteurParPage = intval($_POST['nb_auteur_par_page']);

        if ($I_AuteurParPage > 0)
        {
          BoiteAOutils::rangerDansSession('nb_auteur_par_page', $I_AuteurParPage);
        }
      }

      /*
       on redirige vers la liste
      */
       BoiteAOutils::redirigerVers('auteur/liste');
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

    $O_auteurMapper = FabriqueDeMappers::fabriquer('auteur', Connexion::recupererInstance());

    $O_listeur = new ListeurAuteur($O_auteurMapper);

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
      $I_limit = BoiteAOutils::recupererDepuisSession('nb_auteur_par_page');

      if (is_null($I_limit))
      {
        $I_limit = Constantes::NB_DEFAULT_AUTEURS_PAR_PAGE;
      }

      $O_paginateur->changeLimite($I_limit);

      $A_auteurs = $O_paginateur->recupererPage($I_page);

      $A_pagination = $O_paginateur->paginer();

      $A_parametresVue['auteurs'] = $A_auteurs;
      $A_parametresVue['pagination'] = $A_pagination;
      $A_parametresVue['nb_auteur_par_page'] = $I_limit;
      $A_parametresVue['entite_par_page'] = explode(',', Constantes::ENTITE_PAR_PAGE);

      Vue::montrer ('auteur/liste', $A_parametresVue);
    }

    public function supprAction(Array $A_parametres)
    {
      $I_identifiantAuteur = $A_parametres[0];

      $O_auteur = $this->donneAuteurParIdentifiant($I_identifiantAuteur);

      if (false === $O_auteur)
      {
      // impossible de récupérer un auteur

        BoiteAOutils::redirigerVers('auteur/liste');
      }
      else if (BoiteAOutils::donneMethodeRequete() === 'DELETE')
      {
      // on supprime l'auteur de la bdd

        $O_auteurMapper = FabriqueDeMappers::fabriquer('auteur', Connexion::recupererInstance());
        $O_auteurMapper->supprimer($O_auteur);

      // on redirige vers la liste !
        BoiteAOutils::redirigerVers('auteur/liste');
      }
      else
      {
      // on affiche le formulaire

        Vue::montrer('auteur/suppr', array('auteur' => $O_auteur));
      }
    }

    public function editAction(Array $A_parametres)
    {
      $I_identifiantAuteur = $A_parametres[0];

      $O_auteur = $this->donneAuteurParIdentifiant($I_identifiantAuteur);

      if (false === $O_auteur)
      {
      // impossible de récupérer un auteur

        BoiteAOutils::redirigerVers('auteur/liste');
      }
      else if (BoiteAOutils::donneMethodeRequete() === 'PUT')
      {
        // on modifie la catégorie en bdd

        $S_nom = trim($_POST['nom']);
        $S_prenom = trim($_POST['prenom']);
        $S_mail = trim($_POST['mail']);

        if ($S_nom !== $O_auteur->donneNom() ||
            $S_prenom !== $O_auteur->donnePrenom() ||
            $S_mail !== $O_auteur->donneMail())
        {
          $O_auteur->changeNom($S_nom);
          $O_auteur->changePrenom($S_prenom);
          $O_auteur->changeMail($S_mail);

          $O_validateur = new ValidateurAuteur($O_auteur);

          if (!$O_validateur->estValide())
          {
            Vue::montrer('auteur/edit', array(
                         'auteur' => $O_auteur,
                         'validateur' => $O_validateur
            ));

            return;
          }

          $O_auteurMapper = FabriqueDeMappers::fabriquer('auteur', Connexion::recupererInstance());
          $O_auteurMapper->actualiser($O_auteur);
        }

        // on redirige vers la liste !
        BoiteAOutils::redirigerVers('auteur/liste');
      }
      else
      {
        // on affiche notre formulaire
        Vue::montrer('auteur/edit', array('auteur' => $O_auteur));
      }
    }

    public function creerAction(Array $A_parametres)
    {
      if (BoiteAOutils::donneMethodeRequete() === 'POST')
      {
        // on créer la catégorie en bdd
        $S_nom = trim($_POST['nom']);
        $S_prenom = trim($_POST['prenom']);
        $S_mail = trim($_POST['mail']);

        $O_auteur = new Auteur();
        $O_auteur->changeNom($S_nom);
        $O_auteur->changePrenom($S_prenom);
        $O_auteur->changeMail($S_mail);

        $O_validateur = new ValidateurAuteur($O_auteur);

        if (!$O_validateur->estValide())
        {
          Vue::montrer('auteur/creer', array(
                       'auteur' => $O_auteur,
                       'validateur' => $O_validateur
          ));

          return;
        }

        $O_auteurMapper = FabriqueDeMappers::fabriquer('auteur', Connexion::recupererInstance());
        $O_auteurMapper->creer($O_auteur);

        // on redirige vers la liste !
        BoiteAOutils::redirigerVers('auteur/liste');
      }
      else
      {
      // on affiche notre formulaire

        Vue::montrer('auteur/creer');
      }
    }
  }
