<?php

// La classe de base qui nous permet de valider (ou pas) les données récupérer des formulaires

abstract class Validateur
{
  protected $_A_erreurs;
  protected $_A_estValid;
  protected $_A_params;

  public function __construct($O_modele, array $A_params)
  {
    $this->_A_erreurs = array();
    $this->_A_estValid = array();
    $this->_A_params = array();

    foreach ($A_params as $S_cle => $M_valeur)
    {
      $this->_A_params[$S_cle] = trim($M_valeur);
    }

    $this->verifier($O_modele);
  }

  abstract protected function verifier($O_modele);

  protected function verifierEntier($S_nom, $B_nullable = false)
  {
    $B_estValide = true;
    $S_erreurs = "";

    // TODO

    $this->changeValide($S_nom, $B_estValide);
    $this->ajouteErreur($S_nom, $S_erreurs);

    return $B_estValide;
  }

  protected function verifierString($S_nom, $I_tailleMin=3)
  {
    $B_estValide = true;
    $S_erreurs = "";

    $S_valeur = $this->_A_params[$S_nom];

    if (!empty($S_valeur))
    {
      $I_taille = strlen(utf8_decode($S_valeur));

      if ($I_tailleMin > $I_taille)
      {
        $S_erreurs .= "Doit être d'au moins $I_tailleMin caractères.";

        $B_estValide = false;
      }
    }
    else if ($I_tailleMin > 0)
    {
      $S_erreurs .= 'Doit contenir une valeur.';

      $B_estValide = false;
    }

    $this->changeValide($S_nom, $B_estValide);
    $this->ajouteErreur($S_nom, $S_erreurs);

    return $B_estValide;
  }

  /*
   *
   */
  public function estValide($S_nom = null)
  {
    $B_estValide = false;

    if (isset($S_nom))
    {
      $B_estValide = isset($this->_A_estValide[$S_nom]) && $this->_A_estValide[$S_nom];
    }
    else
    {
      $B_estValide = true;

      foreach ($this->_A_estValide as $B_valeur)
      {
        $B_estValide = $B_estValide && $B_valeur;
      }
    }

    return $B_estValide;
  }

  public function donneParam($S_nom)
  {
    $M_param = null;

    if (isset($S_nom) && isset($this->_A_params[$S_nom]))
    {
      $M_param = $this->_A_params[$S_nom];
    }

    return $M_param;
  }

  public function donneErreur($S_nom = null)
  {
    $S_erreurs = "";

    if (isset($S_nom))
    {
      $S_erreurs =  isset($this->_A_erreurs[$S_nom])?$this->_A_erreurs[$S_nom]:'Aucune erreur trouvée.';
    }
    else
    {
      foreach ($this->_A_erreurs as $S_valeur)
      {
        $S_erreurs .= $S_valeur;
      }
    }

    return $S_erreurs;
  }

  public function ajouteErreur($S_nom, $S_erreur)
  {
    if (isset($S_nom))
    {
      if (isset($this->_A_erreurs[$S_nom]))
      {
        $this->_A_erreurs[$S_nom] = $this->_A_erreurs[$S_nom] . ' ' . $S_erreur;
      }
      else
      {
        $this->_A_erreurs[$S_nom] = $S_erreur;
      }
    }
  }

  public function changeValide($S_nom, $B_estValide)
  {
    if (isset($S_nom))
    {
      $this->_A_estValide[$S_nom] = $B_estValide;
    }
  }
}
