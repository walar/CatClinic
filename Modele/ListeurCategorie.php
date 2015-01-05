<?php

// Cette classe sert à lister des catégories

final class ListeurCategorie extends ListeurTriable implements ListeurInterface
{
  public function __construct($O_mapper)
  {
    parent::__construct($O_mapper);

    $this->changeAttributTri('titre');
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
    return in_array($S_attribut, ['id', 'titre']);
  }
}
