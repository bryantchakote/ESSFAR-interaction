#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


CREATE DATABASE ESSFAR_interaction;
USE ESSFAR_interaction;


#------------------------------------------------------------
# Table: UEs
#------------------------------------------------------------

CREATE TABLE UEs(
        UE_id  TINYINT NOT NULL AUTO_INCREMENT ,
        UE_nom VARCHAR (50) NOT NULL
	,CONSTRAINT UEs_AK UNIQUE (UE_nom)
    ,CONSTRAINT UEs_PK PRIMARY KEY (UE_id)
)ENGINE = MyISAM;


#------------------------------------------------------------
# Table: niveaux
#------------------------------------------------------------

CREATE TABLE niveaux(
        niv_id    TINYINT NOT NULL AUTO_INCREMENT ,
        niv_nom   VARCHAR (50) NOT NULL ,
        niv_alias VARCHAR (10) NOT NULL
	,CONSTRAINT niveaux_AK_nom UNIQUE (niv_nom)
    ,CONSTRAINT niveaux_AK_alias UNIQUE (niv_alias)
    ,CONSTRAINT niveaux_PK PRIMARY KEY (niv_id)
)ENGINE = MyISAM;


#------------------------------------------------------------
# Table: etudiants
#------------------------------------------------------------

CREATE TABLE etudiants(
        et_id        SMALLINT NOT NULL AUTO_INCREMENT ,
        et_matricule BIGINT NOT NULL ,
        et_nom       VARCHAR (50) NOT NULL ,
        et_prenom    VARCHAR (50) ,
        et_sexe      VARCHAR (1) NOT NULL ,
        et_email     VARCHAR (70) NOT NULL ,
        et_mdp       VARCHAR (70) NOT NULL ,
        niv_id       TINYINT
	,CONSTRAINT etudiants_AK_mat UNIQUE (et_matricule)
    ,CONSTRAINT etudiants_AK_mail UNIQUE (et_email)
	,CONSTRAINT etudiants_PK PRIMARY KEY (et_id)
    ,CONSTRAINT etudiants_niveaux_FK FOREIGN KEY (niv_id) REFERENCES niveaux(niv_id) ON DELETE SET NULL ON UPDATE CASCADE
)ENGINE = InnoDB;


#------------------------------------------------------------
# Table: enseignants
#------------------------------------------------------------

CREATE TABLE enseignants(
        ens_id     SMALLINT NOT NULL AUTO_INCREMENT ,
        ens_nom    VARCHAR (50) NOT NULL ,
        ens_prenom VARCHAR (50) ,
        ens_sexe   VARCHAR (1) NOT NULL ,
        ens_email  VARCHAR (70) NOT NULL ,
        ens_mdp    VARCHAR (16) NOT NULL
	,CONSTRAINT enseignants_AK UNIQUE (ens_email)
	,CONSTRAINT enseignants_PK PRIMARY KEY (ens_id)
)ENGINE = MyISAM;


#------------------------------------------------------------
# Table: administrateurs
#------------------------------------------------------------

CREATE TABLE administrateurs(
        admin_id     TINYINT NOT NULL AUTO_INCREMENT ,
        admin_nom    VARCHAR (50) NOT NULL ,
        admin_prenom VARCHAR (50) ,
        admin_sexe   VARCHAR (1) NOT NULL ,
        admin_email  VARCHAR (70) NOT NULL ,
        admin_mdp    VARCHAR (16) NOT NULL
	,CONSTRAINT administrateurs_AK UNIQUE (admin_email)
	,CONSTRAINT administrateurs_PK PRIMARY KEY (admin_id)
)ENGINE = MyISAM;


#------------------------------------------------------------
# Table: questions
#------------------------------------------------------------

CREATE TABLE questions(
        quest_id      INT NOT NULL AUTO_INCREMENT ,
        quest_libelle TEXT (500) NOT NULL ,
        quest_date    DATE NOT NULL ,
        quest_heure   TIME NOT NULL ,
        ans_libelle   TEXT (500) NOT NULL DEFAULT '',
        ans_date      DATE ,
        ans_heure     TIME ,
        et_id         SMALLINT NOT NULL ,
        ens_id        SMALLINT NOT NULL ,
        UE_id         TINYINT NOT NULL
	,CONSTRAINT questions_PK PRIMARY KEY (quest_id)
    ,CONSTRAINT questions_etudiants_FK FOREIGN KEY (et_id) REFERENCES etudiants(et_id) ON DELETE CASCADE ON UPDATE CASCADE
	,CONSTRAINT questions_enseignants_FK FOREIGN KEY (ens_id) REFERENCES enseignants(ens_id) ON DELETE CASCADE ON UPDATE CASCADE
	,CONSTRAINT questions_UEs_FK FOREIGN KEY (UE_id) REFERENCES UEs(UE_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB;


#------------------------------------------------------------
# Table: enseigne
#------------------------------------------------------------

CREATE TABLE enseigne(
        ens_id SMALLINT NOT NULL ,
        UE_id  TINYINT NOT NULL
        ,CONSTRAINT enseigne_PK PRIMARY KEY (ens_id, UE_id)
        ,CONSTRAINT enseigne_enseignants_FK FOREIGN KEY (ens_id) REFERENCES enseignants(ens_id) ON DELETE CASCADE ON UPDATE CASCADE
		,CONSTRAINT enseigne_UEs_FK FOREIGN KEY (UE_id) REFERENCES UEs(UE_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB;


#------------------------------------------------------------
# Table: appartient
#------------------------------------------------------------

CREATE TABLE appartient(
        UE_id  TINYINT NOT NULL ,
        niv_id TINYINT NOT NULL
        ,CONSTRAINT appartient_PK PRIMARY KEY (UE_id, niv_id)
        ,CONSTRAINT appartient_UEs_FK FOREIGN KEY (UE_id) REFERENCES UEs(UE_id) ON DELETE CASCADE ON UPDATE CASCADE
		,CONSTRAINT appartient_niveaux_FK FOREIGN KEY (niv_id) REFERENCES niveaux(niv_id) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE = InnoDB;

