<?php

final class Chat extends ObjetMetier
{
    private $_I_identifiant;

    private $_I_age;

    private $_S_tatouage;

    private $_S_nom;

    // Mes mutateurs (setters)
    public function changeIdentifiant ($identifiant)
    {
        $this->_I_identifiant = $identifiant;
    }

    public function changeAge ($age)
    {
        $this->_I_age = $age;
    }

    public function changeNom ($nom)
    {
        $this->_S_nom = $nom;
    }

    public function changeTatouage ($tatouage)
    {
        $this->_S_tatouage = $tatouage;
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

    public function donneAge ()
    {
        return $this->_I_age;
    }

    public function donneTatouage ()
    {
        return $this->_S_tatouage;
    }
}