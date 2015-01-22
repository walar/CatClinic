<?php

// Cette classe sert pour l'instant à lister des utilisateurs

final class ListeurAuteur extends ListeurTriable implements ListeurInterface
{
  public function __construct($O_mapper) {
    parent::__construct($O_mapper);

    $this->changeAttributTri('nom');
  }

  public function estUnAttributDeTri($S_attribut)
  {
    return in_array($S_attribut, ['id', 'nom', 'prenom', 'mail']);
  }
}
