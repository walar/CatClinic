<?php

// La classe de base qui nous permet de valider (ou pas) les données récupérer des formulaires

abstract class Validateur
{
  protected $A_erreurs;
  protected $A_estValid;

  public function __construct($O_modele)
  {
    $this->A_erreurs = array();
    $this->A_estValid = array();

    $this->verifier($O_modele);
  }

  abstract protected function verifier($O_modele);

  protected function verifierString($S_nom, $S_valeur, $I_tailleMin=3, $I_tailleMax=255, $B_nullable = false)
  {
    $B_estValide = true;
    $S_erreurs = "";

    //$S_valeur = trim($S_valeur);

    if (!empty($S_valeur))
    {
      $I_taille = strlen(utf8_decode($S_valeur));

      if ($I_tailleMin > $I_taille || $I_taille > $I_tailleMax)
      {
        $S_erreurs .= "Doit être d'une longueur comprise entre $I_tailleMin et $I_tailleMax caractères.";

        $B_estValide = false;
      }
    }
    else if (!$B_nullable)
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
    $B_estValide = true;

    if (isset($S_nom))
    {
      $B_estValide = isset($this->A_estValide[$S_nom]) && $this->A_estValide[$S_nom];
    }
    else
    {
      foreach ($this->A_estValide as $B_valeur)
      {
        $B_estValide = $B_estValide && $B_valeur;
      }
    }

    return $B_estValide;
  }

  public function donneErreur($S_nom = null)
  {
    $S_erreurs = "";

    if (isset($S_nom))
    {
      $S_erreurs =  isset($this->A_erreurs[$S_nom])?$this->A_erreurs[$S_nom]:'Aucune erreur trouvée.';
    }
    else
    {
      foreach ($this->A_erreurs as $S_valeur)
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
      if (isset($this->A_erreurs[$S_nom]))
      {
        $this->A_erreurs[$S_nom] = $this->A_erreurs[$S_nom] . ' ' . $S_erreur;
      }
      else
      {
        $this->A_erreurs[$S_nom] = $S_erreur;
      }
    }
  }

  public function changeValide($S_nom, $B_estValide)
  {
    if (isset($S_nom))
    {
      $this->A_estValide[$S_nom] = $B_estValide;
    }
  }
}
