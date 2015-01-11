<?php

final class Auteur
{
  private $_I_identifiant;
  private $_S_nom;
  private $_S_prenom;
  private $_S_mail;

  // getters
  public function changeIdentifiant($I_identifiant)
  {
    $this->_I_identifiant = $I_identifiant;
  }

  public function changeNom($S_nom)
  {
    $this->_S_nom = $S_nom;
  }

  public function changePrenom($S_prenom)
  {
    $this->_S_prenom = $S_prenom;
  }

  public function changeMail($S_mail)
  {
    $this->_S_mail = $S_mail;
  }

  // setters
  public function donneIdentifiant()
  {
    return $this->_I_identifiant;
  }

  public function donneNom()
  {
    return $this->_S_nom;
  }

  public function donnePrenom()
  {
    return $this->_S_prenom;
  }

  public function donneNomComplet()
  {
    return $this->_S_prenom . ' ' . $this->_S_nom;
  }

  public function donneMail()
  {
    return $this->_S_mail;
  }
}
