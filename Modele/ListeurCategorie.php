<?php

// Cette classe sert pour l'instant à lister des utilisateurs

final class ListeurCategorie extends Listeur implements ListeurInterface
{
    private $S_attributTri;
    private $S_ordreTri;

    public function __construct($O_mapper) {
        parent::__construct($O_mapper);

        $this->S_attributTri = 'titre';
        $this->S_ordreTri = 'asc';
    }

    public function lister ($I_debut = null, $I_fin = null)
    {
        return $this->_O_mapper->trouverParIntervalle($I_debut, $I_fin, $this->S_attributTri, $this->S_ordreTri);
    }

    public function recupererCible()
    {
        return $this->_O_mapper->recupererCible();
    }


    // getters
    public function donneAttributTri()
    {
        return $this->S_attributTri;
    }

    public function donneOrdreTri()
    {
        return $this->S_ordreTri;
    }

    // setters
    public function changeAttributTri($S_attribut)
    {
        if (in_array($S_attribut, ['id', 'titre']))
        {
            $this->S_attributTri = $S_attribut;

            return $this->S_attributTri;
        }

        return false;
    }

    public function changeOrdreTri($S_ordre)
    {
        if (in_array($S_ordre, ['asc', 'desc']))
        {
            $this->S_ordreTri = $S_ordre;

            return $this->S_ordreTri;
        }

        return false;
    }
}
