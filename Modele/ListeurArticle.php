<?php

// Cette classe sert pour l'instant à lister des utilisateurs

final class ListeurArticle extends ListeurTriable implements ListeurInterface
{
  public function __construct($O_mapper) {
    parent::__construct($O_mapper);

    $this->changeAttributTri('categorie');
  }

  public function lister ($I_debut = null, $I_fin = null)
  {
    return $this->_O_mapper->trouverParIntervalle($I_debut, $I_fin,
                                                  $this->donneAttributTri(),
                                                  $this->donneOrdreTri());
  }

  public function recupererCible()
  {
    return $this->_O_mapper->recupererCible();
  }

  public function estUnAttributDeTri($S_attribut)
  {
    return in_array($S_attribut, ['id', 'titre', 'date', 'categorie', 'auteur', 'enligne']);
  }
}
