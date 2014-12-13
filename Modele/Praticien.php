<?php

final class Praticien extends ObjetMetier
{
    private $_I_identifiant;
        
    private $_S_nom;

    private $_S_prenom;

    // Mes mutateurs (setters)
    public function changeIdentifiant ($identifiant)
    {
        $this->_I_identifiant = $identifiant;
    }

    public function changeNom ($nom)
    {
        $this->_S_nom = $nom;
    }

    public function changePrenom ($prenom)
    {
        $this->_S_prenom = $prenom;
    }

    // Mes accesseurs (getters)
    public function donneIdentifiant ()
    {
        return $this->_I_identifiant;
    }

    public function donneNom ()
    {
        return $this->_S_nom;
    }

    public function donnePrenom ()
    {
        return $this->_S_prenom;
    }
}