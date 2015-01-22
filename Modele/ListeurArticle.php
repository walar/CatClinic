<?php

// Cette classe sert pour l'instant à lister des utilisateurs

final class ListeurArticle extends ListeurTriable implements ListeurInterface
{
  public function __construct($O_mapper) {
    parent::__construct($O_mapper);

    $this->changeAttributTri('categorie');
  }

  public function estUnAttributDeTri($S_attribut)
  {
    return in_array($S_attribut, ['id', 'titre', 'date', 'categorie', 'auteur', 'enligne']);
  }
}
