<?php


class ValidateurAuteur extends Validateur
{
  public function __construct(Auteur $O_auteur)
  {
    parent::__construct($O_auteur);
  }

  protected function verifier($O_auteur)
  {
    $this->verifierString('nom', $O_auteur->donneNom());
    $this->verifierString('prenom', $O_auteur->donneprenom());

    if ($this->verifierString('mail', $O_auteur->donneMail()))
    {
      try
      {
        $O_auteurMapper = FabriqueDeMappers::fabriquer('auteur', Connexion::recupererInstance());
        $O_auteur = $O_auteurMapper->trouverParMail($O_auteur->donneMail());

        // si aucune exception n'est levée c'est qu'il existe déjà une catégorie avec ce même mail
        $this->changeValide('mail', false);
        $this->ajouteErreur('mail', 'Un auteur avec le même mail éxiste déjà.');
      }
      catch (Exception $O_exception)
      {
        $this->changeValide('mail', true);
      }
    }
  }
}
