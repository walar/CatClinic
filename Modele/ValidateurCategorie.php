<?php


class ValidateurCategorie extends Validateur
{
  public function __construct(Categorie $O_categorie, array $A_params)
  {
    parent::__construct($O_categorie, $A_params);
  }

  protected function verifier($O_categorie)
  {
    $S_titre = $this->donneParam('titre');

    if ($this->verifierString('titre') && $S_titre != $O_categorie->donneTitre() )
    {
      try
      {
        $O_categorieMapper = FabriqueDeMappers::fabriquer('categorie', Connexion::recupererInstance());
        $O_categorie = $O_categorieMapper->trouverParTitre($S_titre);

        // si aucune exception n'est levée c'est qu'il existe déjà une catégorie avec ce même titre
        $this->changeValide('titre', false);
        $this->ajouteErreur('titre', 'Une catégorie avec le même titre existe déjà.');
      }
      catch (Exception $O_exception)
      {
        // Le titre de la catégorie n'existe pas donc c'est ok
        $O_categorie->changeTitre($S_titre);
      }
    }
  }
}
