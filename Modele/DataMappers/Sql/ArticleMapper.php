<?php


final class ArticleMapper extends SqlDataMapper
{
  public function __construct(Connexion $O_connexion)
  {
    parent::__construct(Constantes::TABLE_ARTICLE);
    $this->_S_classeMappee = 'Article';
    $this->_O_connexion = $O_connexion;
  }

  private function _donneRequete()
  {
    $S_requete = 'SELECT art.id, art.titre, art.contenu, art.en_ligne, art.creation_ts';
    $S_requete .= ', cat.id AS cat_id, cat.titre AS cat_titre';
    $S_requete .= ', aut.id AS aut_id, aut.nom AS aut_nom, aut.prenom AS aut_prenom, aut.mail AS aut_mail, CONCAT(aut.nom, " ", aut.prenom) AS aut_nom_prenom';

    $S_requete .= ' FROM ' . $this->_S_nomTable . ' AS art';
    $S_requete .= ' RIGHT OUTER JOIN ' . Constantes::TABLE_CATEGORIE . ' AS cat ' . 'ON art.id_categorie = cat.id';
    $S_requete .= ' RIGHT OUTER JOIN ' . Constantes::TABLE_AUTEUR . ' AS aut ' . 'ON art.id_auteur = aut.id';

    return $S_requete;
  }

  private function _transformeArticleBase($O_articleEnBase)
  {
    $O_categorie = new Categorie();
    $O_categorie->changeIdentifiant($O_articleEnBase->cat_id);
    $O_categorie->changeTitre($O_articleEnBase->cat_titre);

    $O_auteur = new Auteur();
    $O_auteur->changeIdentifiant($O_articleEnBase->aut_id);
    $O_auteur->changeNom($O_articleEnBase->aut_nom);
    $O_auteur->changePrenom($O_articleEnBase->aut_prenom);
    $O_auteur->changeMail($O_articleEnBase->aut_mail);

    $O_article = new $this->_S_classeMappee;
    $O_article->changeIdentifiant ($O_articleEnBase->id);
    $O_article->changeTitre ($O_articleEnBase->titre);
    $O_article->changeContenu ($O_articleEnBase->contenu);
    $O_article->changeEnLigne($O_articleEnBase->en_ligne == '1');
    $O_article->changeDateCreation(new DateTime($O_articleEnBase->creation_ts));
    $O_article->changeCategorie($O_categorie);
    $O_article->changeAuteur($O_auteur);

    return $O_article;
  }

  private function _transformeAttributTri($S_attributTri)
  {
    if ('categorie' == $S_attributTri)
    {
      $S_attributTriTemporaire = 'cat_titre';
    }
    else if ('auteur' == $S_attributTri)
    {
      $S_attributTriTemporaire = 'aut_nom_prenom';
    }
    else if ('date' == $S_attributTri)
    {
      $S_attributTriTemporaire = 'art.creation_ts';
    }
    else if ('enligne' == $S_attributTri)
    {
      $S_attributTriTemporaire = 'art.en_ligne';
    }
    else
    {
      $S_attributTriTemporaire = 'art.' . $S_attributTri;
    }

    return $S_attributTriTemporaire;
  }

  public function trouverParIntervalle ($I_debut, $I_fin, $S_attributTri, $S_ordreTri)
  {
    $S_requete = $this->_donneRequete();

    $S_requete .= ' ORDER BY ' . $this->_transformeAttributTri($S_attributTri) . ' ' . $S_ordreTri;

    if (!is_null($I_debut) && !is_null($I_fin))
    {
      $S_requete .= ' LIMIT ?, ?';
    }

    $A_paramsRequete = array(array($I_debut, Connexion::PARAM_ENTIER), array($I_fin, Connexion::PARAM_ENTIER));

    $A_articles = array ();

    foreach ($this->_O_connexion->projeter($S_requete, $A_paramsRequete) as $O_articleEnBase)
    {
      $A_articles[] = $this->_transformeArticleBase($O_articleEnBase);
    }

    return $A_articles;
  }

  public function trouverParIdentifiant ($I_identifiant)
  {
    if (isset($I_identifiant))
    {
      $S_requete = $this->_donneRequete() . ' WHERE art.id = ?';
      $A_paramsRequete = array($I_identifiant);

      if ($A_articles = $this->_O_connexion->projeter($S_requete, $A_paramsRequete))
      {
        $O_articleTemporaire = $A_articles[0];

        if (is_object($O_articleTemporaire))
        {
          if (class_exists($this->_S_classeMappee))
          {
            return $this->_transformeArticleBase($O_articleTemporaire);
          }
        }
        else
        {
          throw new Exception ("Une erreur s'est produite pour l'article d'identifiant '$I_identifiant'");
        }
      }
      else
      {
          // Je n'ai rien trouvé, je lève une exception pour le signaler au client de ma classe
        throw new Exception ("Il n'existe pas d'article pour l'identifiant '$I_identifiant'");
      }
    }
    else
    {
      throw new Exception ("L'identifiant d'un article ne peut être vide et doit être un entier");
    }
  }

  public function trouverParTitre ($S_titre)
  {
    if (isset($S_titre))
    {
      $S_requete = $this->_donneRequete() . ' WHERE art.titre = ?';
      $A_paramsRequete = array($S_titre);

      if ($A_articles = $this->_O_connexion->projeter($S_requete, $A_paramsRequete))
      {
        $O_articleTemporaire = $A_articles[0];

        if (is_object($O_articleTemporaire))
        {
          if (class_exists($this->_S_classeMappee))
          {
            return $this->_transformeArticleBase($O_articleTemporaire);
          }
        }
        else
        {
          throw new Exception ("Une erreur s'est produite pour l'article de titre '$S_titre'");
        }
      }
      else
      {
          // Je n'ai rien trouvé, je lève une exception pour le signaler au client de ma classe
        throw new Exception ("Il n'existe pas d'article pour le titre '$S_titre'");
      }
    }
    else
    {
      throw new Exception ("Le titre d'un article ne peut être vide et doit être un entier");
    }
  }

  public function creer (Article $O_article)
  {
    if (!($O_article->donneTitre() && $O_article->donneCategorie() && $O_article->donneAuteur()))
    {
      throw new Exception ("Impossible d'enregistrer l'article");
    }

    $S_titre = $O_article->donneTitre();
    $S_contenu = $O_article->donneContenu();
    $I_enligne = $O_article->estEnLigne() ? 1 : 0;
    $S_dateCreation = $O_article->donneDateCreationFormatee();
    $I_categorie = $O_article->donneCategorie()->donneIdentifiant();
    $I_auteur = $O_article->donneAuteur()->donneIdentifiant();

    $S_requete = "INSERT INTO " . $this->_S_nomTable . " (titre, contenu, en_ligne, creation_ts, id_categorie, id_auteur) VALUES (?, ?, ?, ?, ?, ?)";
    $A_paramsRequete = array($S_titre, $S_contenu, $I_enligne, $S_dateCreation, $I_categorie, $I_auteur);

        // j'insère en table et inserer me renvoie l'identifiant de mon nouvel enregistrement...je le stocke
    $O_article->changeIdentifiant($this->_O_connexion->inserer($S_requete, $A_paramsRequete));
  }

  public function actualiser (Article $O_article)
  {
    if (null !== $O_article->donneIdentifiant())
    {
      if (!($O_article->donneTitre() && $O_article->donneCategorie() && $O_article->donneAuteur()))
      {
        throw new Exception ("Impossible de mettre à jour l'article");
      }

      $I_identifiant = $O_article->donneIdentifiant();
      $S_titre = $O_article->donneTitre();
      $S_contenu = $O_article->donneContenu();
      $I_enligne = $O_article->estEnLigne() ? 1 : 0;
      $S_dateCreation = $O_article->donneDateCreationFormatee(false);
      $I_categorie = $O_article->donneCategorie()->donneIdentifiant();
      $I_auteur = $O_article->donneAuteur()->donneIdentifiant();

      $S_requete = "UPDATE " . $this->_S_nomTable . " SET titre = ?, contenu = ?, en_ligne = ?, creation_ts = ?, id_categorie = ?, id_auteur = ? WHERE id = ?";
      $A_paramsRequete = array($S_titre, $S_contenu, $I_enligne, $S_dateCreation, $I_categorie, $I_auteur, $I_identifiant);

      $this->_O_connexion->modifier($S_requete, $A_paramsRequete);

      return true;
    }

    return false;
  }

  public function supprimer (Article $O_article)
  {
    if (null !== $O_article->donneIdentifiant())
    {
      $S_requete   = "DELETE FROM " . $this->_S_nomTable . " WHERE id = ?";
      $A_paramsRequete = array($O_article->donneIdentifiant());

      if (false === $this->_O_connexion->modifier($S_requete, $A_paramsRequete))
      {
        throw new Exception ("Impossible d'effacer l'article d'identifiant " . $O_article->donneIdentifiant());
      }

      return true;
    }

    return false;
  }
}
