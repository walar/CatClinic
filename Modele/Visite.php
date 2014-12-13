<?php

final class Visite  extends ObjetMetier
{
    private $_I_identifiant;

    private $_F_prix;

    private $_O_date;

    private $_S_observations;

    private $_O_praticien;

    private $_O_chat;

    // Mes mutateurs (setters)
    public function changeIdentifiant ($identifiant)
    {
        $this->_I_identifiant = $identifiant;
    }

    public function changePrix ($prix)
    {
        $this->_F_prix = $prix;
    }

    public function changeDate (DateTime $date)
    {
        $this->_O_date = $date;
    }

    public function changeObservations ($observations)
    {
        $this->_S_observations = $observations;
    }

    public function changePraticien (Praticien $O_praticien)
    {
        $this->_O_praticien = $O_praticien;
    }

    public function changeChat (Chat $O_chat)
    {
        $this->_O_chat = $O_chat;
    }

    // Mes accesseurs (getters)

    public function donneIdentifiant ()
    {
        return $this->_I_identifiant;
    }

    public function donnePrix ()
    {
        return $this->_F_prix;
    }

    public function donneDate ()
    {
        return $this->_O_date->format(Constantes::DATE_FORMAT);
    }

    public function donneObservations ()
    {
        return $this->_S_observations;
    }

    public function donnePraticien ()
    {
        return $this->_O_praticien;
    }

    public function donneChat ()
    {
        return $this->_O_chat;
    }
}