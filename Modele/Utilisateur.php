<?php

final class Utilisateur extends ObjetMetier
{
    private $_I_identifiant;

    private $_S_login;

    private $_S_motPasse;

    private $_I_admin;

    private $_O_proprietaire = null;

    // Mes mutateurs (setters)
    public function changeIdentifiant ($identifiant)
    {
        $this->_I_identifiant = $identifiant;
    }

    public function changeLogin ($login)
    {
        $this->_S_login = $login;
    }

    public function changeMotDePasse ($motPasse)
    {
        $this->_S_motPasse = $motPasse;
    }

    public function changeAdmin ($admin)
    {
        $this->_I_admin = $admin;
    }

    public function changeProprietaire (Proprietaire $O_proprietaire = null)
    {
        $this->_O_proprietaire = $O_proprietaire;
    }

    // Mes accesseurs (getters)

    public function donneIdentifiant ()
    {
        return $this->_I_identifiant;
    }

    public function donneMotDePasse ()
    {
        return $this->_S_motPasse;
    }

    public function donneLogin ()
    {
        return $this->_S_login;
    }

    public function estAdministrateur ()
    {
        return (1 == $this->_I_admin);
    }

    public function estProprietaire ()
    {
        return !is_null($this->_O_proprietaire);
    }

    public function donneProprietaire ()
    {
        return $this->_O_proprietaire;
    }
}