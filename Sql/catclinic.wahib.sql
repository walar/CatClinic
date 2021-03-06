use catclinic;

create table if not exists auteur (
  id smallint unsigned not null auto_increment,
  nom varchar(64) not null,
  prenom varchar(64) not null,
  mail varchar(128) not null,

  primary key(id),
  unique(mail)
) Engine= InnoDb;

create table if not exists categorie (
  id smallint unsigned not null auto_increment,
  titre varchar(30) not null,

  primary key(id),
  unique(titre)
) Engine= InnoDb;

create table if not exists article (
  id smallint unsigned not null auto_increment,
  titre varchar(255) not null,
  contenu text,
  en_ligne tinyint unsigned not null default 0,
  creation_ts timestamp not null default current_timestamp,

  id_categorie smallint unsigned not null,
  id_auteur smallint unsigned not null,

  primary key(id),
  unique(titre)
) Engine= InnoDb;

alter table article add constraint FK_article_categorie foreign key (id_categorie) references categorie(id) ON DELETE CASCADE;
alter table article add constraint FK_article_auteur foreign key (id_auteur) references auteur(id) ON DELETE CASCADE;
