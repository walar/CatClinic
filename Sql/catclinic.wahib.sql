use catclinic;

create table if not exists auteur (
  id smallint unsigned not null auto_increment,
  nom varchar(30) not null,
  prenom varchar(30) not null,

  primary key(id)
) Engine= InnoDb;

create table if not exists categorie (
  id smallint unsigned not null auto_increment,
  titre varchar(30) not null,

  primary key(id)
) Engine= InnoDb;

alter table categorie add unique (titre);

create table if not exists article (
  id smallint unsigned not null auto_increment,
  titre varchar(30) not null,
  contenu text not null,
  en_ligne tinyint unsigned not null default 0,
  creation_ts timestamp not null default current_timestamp,

  id_categorie smallint unsigned not null,
  id_auteur smallint unsigned not null,

  primary key(id)
) Engine= InnoDb;

alter table article add unique (titre);
alter table article add constraint FK_article_categorie foreign key (id_categorie) references categorie(id) ON DELETE CASCADE;
alter table article add constraint FK_article_auteur foreign key (id_auteur) references auteur(id) ON DELETE CASCADE;
