<?php

final class Categorie
{
  private $_I_identifiant;
  private $_S_titre;

  // getters
  public function changeIdentifiant($identifiant)
  {
    $this->_I_identifiant = $identifiant;
  }

  public function changeTitre($titre)
  {
    $this->_S_titre = $titre;
  }

  // setters
  public function donneIdentifiant()
  {
    return $this->_I_identifiant;
  }

  public function donneTitre()
  {
    return $this->_S_titre;
  }
}
