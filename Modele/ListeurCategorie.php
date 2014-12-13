<?php

// Cette classe sert pour l'instant à lister des utilisateurs

class ListeurCategorie extends Listeur implements ListeurInterface
{
    public function __construct($O_mapper) {
        parent::__construct($O_mapper);
    }

    public function lister ($I_debut = null, $I_fin = null)
    {
        return $this->_O_mapper->trouverParIntervalle($I_debut, $I_fin);
    }

    public function recupererCible()
    {
        return $this->_O_mapper->recupererCible();
    }
}
