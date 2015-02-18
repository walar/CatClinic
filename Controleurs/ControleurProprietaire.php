<?php

final class ControleurProprietaire
{
	public function defautAction()
	{
		BoiteAOutils::redirigerVers('proprietaire/visites');
	}

	public function visitesAction(Array $A_parametres)
	{
		$O_utilisateur = BoiteAOutils::recupererDepuisSession('utilisateur');

		if (!$O_utilisateur->estProprietaire())
		{
			throw new ControleurException('L\'utilisateur "' . $O_utilisateur->donneLogin() . '" n\'est pas un propriétaire');
		}

		$O_proprietaire = $O_utilisateur->donneProprietaire();

		$A_chats = $O_proprietaire->donneChats();

		$O_visiteMapper = FabriqueDeMappers::fabriquer('visite', Connexion::recupererInstance());

		$A_toutesLesVisites = array();
		foreach ($A_chats as $O_chat) 
		{   
			$I_identifiantChat = $O_chat->donneIdentifiant();
			try
			{
				$A_toutesLesVisites[] = $O_visiteMapper->trouverParIdentifiantChat ($I_identifiantChat);
			}
			catch (Exception $e)
			{

			}
		}

		Vue::montrer('visites/liste', array(
			'proprietaire' => $O_proprietaire, 
			'toutesLesVisites' => $A_toutesLesVisites, 
			'chats' => $A_chats
		));
	}

}