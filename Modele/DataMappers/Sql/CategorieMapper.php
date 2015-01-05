<?php

final class CategorieMapper extends SqlDataMapper
{
    public function __construct(Connexion $O_connexion)
    {
        parent::__construct(Constantes::TABLE_CATEGORIE);
        $this->_S_classeMappee = 'Categorie';
        $this->_O_connexion = $O_connexion;
    }

     public function trouverParIntervalle ($I_debut, $I_fin, $S_attributTri, $S_ordreTri) {
        $S_requete = 'SELECT id, titre FROM ' . $this->_S_nomTable . " ORDER BY $S_attributTri $S_ordreTri";

        if (!is_null($I_debut) && !is_null($I_fin))
        {
            $S_requete .= ' LIMIT ?, ?';
        }

        $A_paramsRequete = array(array($I_debut, Connexion::PARAM_ENTIER), array($I_fin, Connexion::PARAM_ENTIER));

        $A_categories = array ();

        foreach ($this->_O_connexion->projeter($S_requete, $A_paramsRequete) as $O_categorieEnBase)
        {
            $O_categorie = new Categorie ();

            $O_categorie->changeIdentifiant($O_categorieEnBase->id);
            $O_categorie->changeTitre ($O_categorieEnBase->titre);

            $A_categories[] = $O_categorie;
        }

        return $A_categories;
    }

    public function trouverParIdentifiant ($I_identifiant)
    {
        if (isset($I_identifiant))
        {
            $S_requete    = "SELECT id, titre FROM " . $this->_S_nomTable .
                            " WHERE id = ?";
            $A_paramsRequete = array($I_identifiant);

            if ($A_categorie = $this->_O_connexion->projeter($S_requete, $A_paramsRequete))
            {
                $O_categorieTemporaire = $A_categorie[0];

                if (is_object($O_categorieTemporaire))
                {
                    if (class_exists($this->_S_classeMappee))
                    {
                        $O_categorie = new $this->_S_classeMappee;

                        $O_categorie->changeIdentifiant($O_categorieTemporaire->id);
                        $O_categorie->changeTitre($O_categorieTemporaire->titre);

                        return $O_categorie;
                    }
                }
                else
                {
                    throw new Exception ("Une erreur s'est produite pour la catégorie d'identifiant '$I_identifiant'");
                }
            }
            else
            {
                // Je n'ai rien trouvé, je lève une exception pour le signaler au client de ma classe
                throw new Exception ("Il n'existe pas de catégorie pour l'identifiant '$I_identifiant'");
            }
        }
        else
        {
            throw new Exception ("L'identifiant d'une catégorie ne peut être vide et doit être un entier");
        }
    }

    public function trouverParTitre($S_titre)
    {
        if (isset($S_titre))
        {
            $S_requete    = "SELECT id, titre FROM " . $this->_S_nomTable .
                            " WHERE titre = ?";
            $A_paramsRequete = array($S_titre);

            if ($A_categorie = $this->_O_connexion->projeter($S_requete, $A_paramsRequete))
            {
                $O_categorieTemporaire = $A_categorie[0];

                if (is_object($O_categorieTemporaire))
                {
                    if (class_exists($this->_S_classeMappee))
                    {
                        $O_categorie = new $this->_S_classeMappee;

                        $O_categorie->changeIdentifiant($O_categorieTemporaire->id);
                        $O_categorie->changeTitre($O_categorieTemporaire->titre);

                        return $O_categorie;
                    }
                }
                else
                {
                    throw new Exception ("Une erreur s'est produite pour la catégorie de titre '$S_titre'");
                }
            }
            else
            {
                // Je n'ai rien trouvé, je lève une exception pour le signaler au client de ma classe
                throw new Exception ("Il n'existe pas de catégorie pour le titre '$S_titre'");
            }
        }
        else
        {
            throw new Exception ("Le titre d'une catégorie ne peut être vide");
        }
    }

    public function creer (Categorie $O_categorie)
    {
        if (!$O_categorie->donneTitre())
        {
            throw new Exception ("Impossible d'enregistrer la catégorie");
        }

        $S_titre = $O_categorie->donneTitre();

        $S_requete = "INSERT INTO " . $this->_S_nomTable . " (titre) VALUES (?)";
        $A_paramsRequete = array($S_titre);

        // j'insère en table et inserer me renvoie l'identifiant de mon nouvel enregistrement...je le stocke
        $O_categorie->changeIdentifiant($this->_O_connexion->inserer($S_requete, $A_paramsRequete));
    }

    public function actualiser (Categorie $O_categorie)
    {
        if (null !== $O_categorie->donneIdentifiant())
        {
            if (!$O_categorie->donneTitre())
            {
                throw new Exception ("Impossible de mettre à jour la catégorie");
            }

            $S_titre = $O_categorie->donnetitre();
            $I_identifiant = $O_categorie->donneIdentifiant();

            $S_requete = "UPDATE " . $this->_S_nomTable . " SET titre = ? WHERE id = ?";
            $A_paramsRequete = array($S_titre, $I_identifiant);

            $this->_O_connexion->modifier($S_requete, $A_paramsRequete);

            return true;
        }

        return false;
    }

    public function supprimer (Categorie $O_categorie)
    {
        if (null !== $O_categorie->donneIdentifiant())
        {
            $S_requete   = "DELETE FROM " . $this->_S_nomTable . " WHERE id = ?";
            $A_paramsRequete = array($O_categorie->donneIdentifiant());

            if (false === $this->_O_connexion->modifier($S_requete, $A_paramsRequete))
            {
                throw new Exception ("Impossible d'effacer la catégorie d'identifiant " . $O_categorie->donneIdentifiant());
            }

            return true;
        }

        return false;
    }
}
