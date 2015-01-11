use catclinic;

insert into auteur(prenom, nom, mail) values ('Yves-André', 'Sahmer', 'yves-andre@catclinic.tld');
insert into auteur(prenom, nom, mail) values ('Sacha', 'De Gouttière', 'sasha@catclinic.tld');
insert into auteur(prenom, nom, mail) values ('Jérôme', 'Létenor-Végienne', 'jerome@catclinic.tld');
insert into auteur(prenom, nom, mail) values ('Rama', 'Matou-Diallo', 'rama@catclinic.tld');


insert into categorie(titre) values ('Actualités');
insert into categorie(titre) values ('Adoptions');
insert into categorie(titre) values ('Chat pratique');
insert into categorie(titre) values ('Votre clinique');


insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Dépistage des affections oculaires', 1, 1, '2013-12-01 08:00:00');
insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Titouille (F) recherche une famille', 2, 2, '2013-12-02 09:00:00');
insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Tigrou (M) cherche un foyer', 2, 2, '2013-12-03 10:00:00');
insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Fripouille (F) cherche un foyer', 2, 2, '2013-12-03 11:00:00');
insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Les kystes chez le chat', 3, 3, '2013-12-02 12:00:00');
insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Quelle croquettes pour les chatons ?', 3, 3, '2013-12-03 13:00:00');
insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Les maladies du coeur chez le Maine Coon', 3, 3, '2013-12-04 14:00:00');
insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Mon chat griffe mon mobilier: que faire ?', 3, 3, '2013-12-05 15:00:00');
insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Un arbre à griffer géant livré chez Cat Clinic !', 1, 4, '2013-12-04 16:00:00');
insert into article(titre, id_auteur, id_categorie, creation_ts) values ('Une nouvelle salle d\'opération en 2015', 4, 4, '2013-12-02 17:00:00');
