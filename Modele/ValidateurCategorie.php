<?php


class ValidateurCategorie extends Validateur
{
  public function __construct(Categorie $O_categorie)
  {
    parent::__construct($O_categorie);
  }

  protected function verifier($O_categorie)
  {
    $this->verifierString('titre', $O_categorie->donneTitre());
  }
}
