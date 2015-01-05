<?php


class ValidateurCategorie extends Validateur
{
  public function __construct(Categorie $O_categorie)
  {
    parent::__construct($O_categorie);
  }

  protected function verifier($O_categorie)
  {
    if ($this->verifierString('titre', $O_categorie->donneTitre()))
    {
      try
      {
        $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
        $O_categorie = $O_categorieMapper->trouverParTitre($O_categorie->donneTitre());

        // si aucune exception n'est levée c'est qu'il existe déjà une catégorie avec ce même titre
        $this->changeValide('titre', false);
        $this->ajouteErreur('titre', 'Une catégorie avec le même titre éxiste déjà.');
      }
      catch (Exception $O_exception)
      {
        // Le titre de la catégorie n'existe pas donc c'est ok
        $this->changeValide('titre', true);
      }
    }
  }
}
