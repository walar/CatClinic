<?php

final class Categorie
{
  private $_I_identifiant;
  private $_S_titre;

  // getters
  public function changeIdentifiant($I_identifiant)
  {
    $this->_I_identifiant = $I_identifiant;
  }

  public function changeTitre($S_titre)
  {
    $this->_S_titre = $S_titre;
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
