<?php


class ValidateurArticle extends Validateur
{
  public function __construct(Article $O_article, array $A_params)
  {
    parent::__construct($O_article, $A_params);
  }

  protected function verifier($O_article)
  {
    // contenu
    $S_contenu = $this->donneParam('contenu');

    if ($this->verifierString('contenu', 0) && $S_contenu != $O_article->donneContenu())
    {
      $O_article->changeContenu($S_contenu);
    }

    // en_ligne
    /* $B_enLigne = $this->donneParam('en_ligne') == '1';

    if ($B_enLigne != $O_article->estEnLigne())
    {
      $O_article->changeEnLigne($B_enLigne);
    } */

    // titre
    $S_titre = $this->donneParam('titre');

    if ($this->verifierString('titre') && $S_titre != $O_article->donneTitre())
    {
      try
      {
        $O_articleMapper = FabriqueDeMappers::fabriquer('article', Connexion::recupererInstance());
        $O_article = $O_articleMapper->trouverParTitre($S_titre);

        // si aucune exception n'est levée c'est qu'il existe déjà un article avec ce même titre
        $this->changeValide('titre', false);
        $this->ajouteErreur('titre', 'Un article avec le même titre existe déjà.');
      }
      catch (Exception $O_exception)
      {
        // Le titre n'existe pas donc c'est ok
        $O_article->changeTitre($S_titre);
      }
    }

    // categorie
    $I_idCategorie = intval($this->donneParam('categorie'));
    $O_categorieCourante = $O_article->donneCategorie();

    if ($this->verifierEntier('categorie') && (is_null($O_categorieCourante) || $I_idCategorie != $O_categorieCourante->donneIdentifiant()))
    {
      try
      {
        $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
        $O_categorie = $O_categorieMapper->trouverParIdentifiant($I_idCategorie);

        $O_article->changeCategorie($O_categorie);
      }
      catch (Exception $O_exception)
      {
        $this->changeValide('categorie', false);
        $this->ajouteErreur('categorie', 'La catégorie d\'identifiant "'. $I_idCategorie .'" n\'existe pas.');
      }
    }

    // auteur
    $I_idAuteur = intval($this->donneParam('auteur'));
    $O_auteurCourant = $O_article->donneAuteur();

    if ($this->verifierEntier('auteur') && (is_null($O_auteurCourant) || $I_idAuteur != $O_auteurCourant->donneIdentifiant()))
    {
      try
      {
        $O_auteurMapper = FabriqueDeMappers::fabriquer('auteur', Connexion::recupererInstance());
        $O_auteur = $O_auteurMapper->trouverParIdentifiant($I_idAuteur);

        $O_article->changeAuteur($O_auteur);
      }
      catch (Exception $O_exception)
      {
        $this->changeValide('auteur', false);
        $this->ajouteErreur('auteur', 'L\'auteur d\'identifiant "'. $I_idAuteur .'" n\'existe pas.');
      }
    }
  }

}
