<?php

abstract class ListeurTriable extends Listeur
{
  protected $_S_attributTri;
  protected $_S_ordreTri;

  public function __construct($O_mapper)
  {
    parent::__construct($O_mapper);

    $this->_S_attributTri = 'identifiant';
    $this->_S_ordreTri = 'asc';
  }

  abstract public function estUnAttributDeTri($S_attribut);

  public function lister ($I_debut = null, $I_fin = null)
  {
    return $this->_O_mapper->trouverParIntervalle($I_debut, $I_fin,
                                                  $this->donneAttributTri(),
                                                  $this->donneOrdreTri());
  }

  // getters
  public function donneAttributTri()
  {
    return $this->_S_attributTri;
  }

  public function donneOrdreTri()
  {
    return $this->_S_ordreTri;
  }

    // setters
  public function changeAttributTri($S_attribut)
  {
    if ($this->estUnAttributDeTri($S_attribut))
    {
      $this->_S_attributTri = $S_attribut;

      return $this->_S_attributTri;
    }

    return false;
  }

  public function changeOrdreTri($S_ordre)
  {
    if (in_array($S_ordre, ['asc', 'desc']))
    {
      $this->_S_ordreTri = $S_ordre;

      return $this->_S_ordreTri;
    }

    return false;
  }
}
