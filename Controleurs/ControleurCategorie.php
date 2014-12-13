<?php

final class ControleurCategorie
{
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
}
