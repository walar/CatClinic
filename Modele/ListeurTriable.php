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

  // getters
  public function donneAttributTri()
  {
    return $this->_S_attributTri;
  }

  public function donneOrdreTri()
  {
    return $this->_S_ordreTri;
  }

  abstract public function estUnAttributDeTri($S_attribut);

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
