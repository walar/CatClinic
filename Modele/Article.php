<?php

final class Article
{
  private $_I_identifiant;
  private $_S_titre;
  private $_S_contenu;
  private $_B_enLigne;
  private $_O_dateCreation;

  private $_O_categorie = null;
  private $_O_auteur = null;

  // setters
  public function changeIdentifiant ($I_identifiant)
  {
    $this->_I_identifiant = $I_identifiant;
  }

  public function changeTitre ($S_titre)
  {
    $this->_S_titre = $S_titre;
  }

  public function changeContenu ($S_contenu)
  {
    $this->_S_contenu = $S_contenu;
  }

  public function changeEnLigne ($B_enLigne)
  {
    $this->_B_enLigne = $B_enLigne;
  }

  public function changeDateCreation (DateTime $O_dateCreation)
  {
    $this->_O_dateCreation = $O_dateCreation;
  }

  public function changeCategorie (Categorie $O_categorie)
  {
    $this->_O_categorie = $O_categorie;
  }

  public function changeAuteur (Auteur $O_auteur)
  {
    $this->_O_auteur = $O_auteur;
  }


  //getters
  public function donneIdentifiant ()
  {
    return $this->_I_identifiant;
  }

  public function donneTitre ()
  {
    return $this->_S_titre;
  }

  public function donneContenu ()
  {
    return $this->_S_contenu;
  }

  public function estEnLigne ()
  {
    return $this->_B_enLigne;
  }

  public function donneDateCreation ()
  {
    return $this->_O_dateCreation;
  }

  public function donneDateCreationFormatee ()
  {
    return $this->_O_dateCreation ? $this->_O_dateCreation->format(Constantes::DATE_FORMAT_SIMPLE) : null;
  }

  public function donneCategorie ()
  {
    return $this->_O_categorie;
  }

  public function donneAuteur ()
  {
    return $this->_O_auteur;
  }
}

