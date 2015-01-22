<?php

// Cette classe sert à lister des catégories

final class ListeurCategorie extends ListeurTriable implements ListeurInterface
{
  public function __construct($O_mapper)
  {
    parent::__construct($O_mapper);

    $this->changeAttributTri('titre');
  }

  public function estUnAttributDeTri($S_attribut)
  {
    return in_array($S_attribut, ['id', 'titre']);
  }
}
