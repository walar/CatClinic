<?php


class ValidateurAuteur extends Validateur
{
  public function __construct(Auteur $O_auteur, array $A_params)
  {
    parent::__construct($O_auteur, $A_params);
  }

  protected function verifier($O_auteur)
  {
    // nom
    $S_nom = $this->donneParam('nom');

    if ($this->verifierString('nom') && $S_nom != $O_auteur->donneNom())
    {
      $O_auteur->changeNom($S_nom);
    }

    // prenom
    $S_prenom = $this->donneParam('prenom');

    if ($this->verifierString('prenom') && $S_prenom != $O_auteur->donnePrenom())
    {
      $O_auteur->changePrenom($S_prenom);
    }

    // mail
    $S_mail = $this->donneParam('mail');

    if ($this->verifierString('mail') && $S_mail != $O_auteur->donneMail())
    {
      try
      {
        $O_auteurMapper = FabriqueDeMappers::fabriquer('auteur', Connexion::recupererInstance());
        $O_auteur = $O_auteurMapper->trouverParMail($S_mail);

        // si aucune exception n'est levée c'est qu'il existe déjà un auteur avec ce même mail
        $this->changeValide('mail', false);
        $this->ajouteErreur('mail', 'Un auteur avec le même mail existe déjà.');
      }
      catch (Exception $O_exception)
      {
        // Ce mail n'existe pas donc c'est ok
        $O_auteur->changeMail($S_mail);
      }
    }
  }
}
