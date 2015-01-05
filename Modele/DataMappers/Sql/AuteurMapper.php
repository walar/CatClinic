<?php

final class AuteurMapper extends SqlDataMapper
{
    public function __construct(Connexion $O_connexion)
    {
        parent::__construct(Constantes::TABLE_AUTEUR);
        $this->_S_classeMappee = 'Auteur';
        $this->_O_connexion = $O_connexion;
    }

     public function trouverParIntervalle ($I_debut, $I_fin, $S_attributTri, $S_ordreTri) {
        $S_requete = 'SELECT id, nom, prenom, mail FROM ' . $this->_S_nomTable . " ORDER BY $S_attributTri $S_ordreTri";

        if (!is_null($I_debut) && !is_null($I_fin))
        {
            $S_requete .= ' LIMIT ?, ?';
        }

        $A_paramsRequete = array(array($I_debut, Connexion::PARAM_ENTIER), array($I_fin, Connexion::PARAM_ENTIER));

        $A_auteurs = array ();

        foreach ($this->_O_connexion->projeter($S_requete, $A_paramsRequete) as $O_auteurEnBase)
        {
            $O_auteur = new Auteur ();

            $O_auteur->changeIdentifiant ($O_auteurEnBase->id);
            $O_auteur->changeNom ($O_auteurEnBase->nom);
            $O_auteur->changePrenom ($O_auteurEnBase->prenom);
            $O_auteur->changeMail ($O_auteurEnBase->mail);

            $A_auteurs[] = $O_auteur;
        }

        return $A_auteurs;
    }

    public function trouverParIdentifiant ($I_identifiant)
    {
        if (isset($I_identifiant))
        {
            $S_requete    = "SELECT id, nom, prenom, mail FROM " . $this->_S_nomTable .
                            " WHERE id = ?";
            $A_paramsRequete = array($I_identifiant);

            if ($A_auteur = $this->_O_connexion->projeter($S_requete, $A_paramsRequete))
            {
                $O_auteurTemporaire = $A_auteur[0];

                if (is_object($O_auteurTemporaire))
                {
                    if (class_exists($this->_S_classeMappee))
                    {
                        $O_auteur = new $this->_S_classeMappee;

                        $O_auteur->changeIdentifiant($O_auteurTemporaire->id);
                        $O_auteur->changeNom($O_auteurTemporaire->nom);
                        $O_auteur->changePrenom($O_auteurTemporaire->prenom);
                        $O_auteur->changeMail($O_auteurTemporaire->mail);

                        return $O_auteur;
                    }
                }
                else
                {
                    throw new Exception ("Une erreur s'est produite pour l'auteur d'identifiant '$I_identifiant'");
                }
            }
            else
            {
                // Je n'ai rien trouvé, je lève une exception pour le signaler au client de ma classe
                throw new Exception ("Il n'existe pas d'auteur pour l'identifiant '$I_identifiant'");
            }
        }
        else
        {
            throw new Exception ("L'identifiant d'un auteur ne peut être vide et doit être un entier");
        }
    }

    public function trouverParMail($S_mail)
    {
        if (isset($S_mail))
        {
            $S_requete    = "SELECT id, nom, prenom, mail FROM " . $this->_S_nomTable .
                            " WHERE mail = ?";
            $A_paramsRequete = array($S_mail);

            if ($A_auteur = $this->_O_connexion->projeter($S_requete, $A_paramsRequete))
            {
                $O_auteurTemporaire = $A_auteur[0];

                if (is_object($O_auteurTemporaire))
                {
                    if (class_exists($this->_S_classeMappee))
                    {
                        $O_auteur = new $this->_S_classeMappee;

                        $O_auteur->changeIdentifiant($O_auteurTemporaire->id);
                        $O_auteur->changeNom($O_auteurTemporaire->nom);
                        $O_auteur->changePrenom($O_auteurTemporaire->prenom);
                        $O_auteur->changeMail($O_auteurTemporaire->mail);

                        return $O_auteur;
                    }
                }
                else
                {
                    throw new Exception ("Une erreur s'est produite pour l'auteur avec le mail '$S_mail'");
                }
            }
            else
            {
                // Je n'ai rien trouvé, je lève une exception pour le signaler au client de ma classe
                throw new Exception ("Il n'existe pas d'auteur avec le mail '$S_mail'");
            }
        }
        else
        {
            throw new Exception ("Le mail d'un auteur ne peut être vide");
        }
    }

    public function creer (Auteur $O_auteur)
    {
        if (!($O_auteur->donneNom() && $O_auteur->donnePrenom() && $O_auteur->donneMail()))
        {
            throw new Exception ("Impossible d'enregistrer l'auteur");
        }

        $S_nom = $O_auteur->donneNom();
        $S_prenom = $O_auteur->donnePrenom();
        $S_mail = $O_auteur->donneMail();

        $S_requete = "INSERT INTO " . $this->_S_nomTable . " (nom, prenom, mail) VALUES (?, ?, ?)";
        $A_paramsRequete = array($S_nom, $S_prenom, $S_mail);

        // j'insère en table et inserer me renvoie l'identifiant de mon nouvel enregistrement...je le stocke
        $O_auteur->changeIdentifiant($this->_O_connexion->inserer($S_requete, $A_paramsRequete));
    }

    public function actualiser (Auteur $O_auteur)
    {
        if (null !== $O_auteur->donneIdentifiant())
        {
            if (!($O_auteur->donneNom() && $O_auteur->donnePrenom() && $O_auteur->donneMail()))
            {
                throw new Exception ("Impossible de mettre à jour l'auteur");
            }

            $S_nom = $O_auteur->donneNom();
            $S_prenom = $O_auteur->donnePrenom();
            $S_mail = $O_auteur->donneMail();
            $I_identifiant = $O_auteur->donneIdentifiant();

            $S_requete = "UPDATE " . $this->_S_nomTable . " SET nom = ?, prenom = ?, mail = ? WHERE id = ?";
            $A_paramsRequete = array($S_nom, $S_prenom, $S_mail, $I_identifiant);

            $this->_O_connexion->modifier($S_requete, $A_paramsRequete);

            return true;
        }

        return false;
    }

    public function supprimer (Auteur $O_auteur)
    {
        if (null !== $O_auteur->donneIdentifiant())
        {
            $S_requete   = "DELETE FROM " . $this->_S_nomTable . " WHERE id = ?";
            $A_paramsRequete = array($O_auteur->donneIdentifiant());

            if (false === $this->_O_connexion->modifier($S_requete, $A_paramsRequete))
            {
                throw new Exception ("Impossible d'effacer l'auteur d'identifiant " . $O_auteur->donneIdentifiant());
            }

            return true;
        }

        return false;
    }
}
