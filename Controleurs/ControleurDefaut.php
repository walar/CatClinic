<?php

final class ControleurDefaut
{
    public function defautAction()
    {
        if (!Authentification::estConnecte()) {
            BoiteAOutils::redirigerVers('login');
        }
        else {
            // l'utilisateur est connecte
            // c'est soit un admin
            // soit un proprietaire
            // soit un client "normal"...l'affichage va donc varier

            $O_utilisateur = BoiteAOutils::recupererDepuisSession('utilisateur');

            if (!$O_utilisateur->estAdministrateur ()) {
                // un proprietaire doit voir les visites de son chat s'afficher
                if ($O_utilisateur->estProprietaire())
                {
                    $O_chat = $O_utilisateur->donneProprietaire()->donneChat();
                    $I_identifiantChat = $O_chat->donneIdentifiant();

                    $O_visiteMapper = FabriqueDeMappers::fabriquer('visite', Connexion::recupererInstance());
                    $A_visites = $O_visiteMapper->trouverParIdentifiantChat ($I_identifiantChat);

                    Vue::montrer('visites/liste', array('visites' => $A_visites, 'chat' => $O_chat));
                } else
                {
                    Vue::montrer('client/accueil');
                }
            } else {
                // un admin doit avoir la liste des utilisateurs du site
                // je les récupère tous...
                $O_utilisateurMapper = FabriqueDeMappers::fabriquer('utilisateur', Connexion::recupererInstance());
                $O_listeurUtilisateur = new Listeur($O_utilisateurMapper);

                $O_paginateur = new Paginateur($O_listeurUtilisateur);

                $O_paginateur->changeLimite(Constantes::NB_MAX_UTILISATEURS_PAR_PAGE);

                // on doit afficher puis installer la pagination
                $A_utilisateurs = $O_paginateur->recupererPage(1);

                $A_pagination = $O_paginateur->paginer();

                Vue::montrer ('utilisateur/liste', array('utilisateurs' => $A_utilisateurs, 'pagination' => $A_pagination));
            }
        }
    }
}
