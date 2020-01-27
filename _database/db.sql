#DROP DATABASE IF EXISTS doit;

#CREATE DATABASE doit;

USE achimett;

SET FOREIGN_KEY_CHECKS = 0; -- Disabilita check su vincoli di integrità referenziale

DROP TABLE IF EXISTS utente, post, commento, partecipazione;

CREATE TABLE utente (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  email       VARCHAR(50) NOT NULL UNIQUE,
  password    VARCHAR(64) NOT NULL,
  nome        VARCHAR(30) NOT NULL,
  cognome     VARCHAR(30) NOT NULL,
  telefono	  VARCHAR(30) NOT NULL,
  datanascita DATE NOT NULL,
  cf          VARCHAR(16) NOT NULL UNIQUE,
  bio         TEXT NOT NULL,
  img_path    VARCHAR(256) NOT NULL DEFAULT 'img/utentenero_icon.png'
);

CREATE TABLE post (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  titolo      VARCHAR(100) NOT NULL,
  id_autore   INT NOT NULL,
  data        TIMESTAMP NOT NULL,
  descrizione TEXT NOT NULL,
  img_path    VARCHAR(256) NOT NULL DEFAULT 'img/default.jpg',
  provincia	  VARCHAR(50) NOT NULL,
  luogo		  VARCHAR(150) NOT NULL,
  chiuso      BOOLEAN NOT NULL DEFAULT 0,

  FOREIGN KEY (id_autore) REFERENCES utente(id)
);

CREATE TABLE commento (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  id_autore   INT NOT NULL,
  id_post     INT NOT NULL,
  data        TIMESTAMP NOT NULL,
  img_path    VARCHAR(256) DEFAULT NULL,
  text        TEXT NOT NULL,

  FOREIGN KEY (id_autore) REFERENCES utente(id),
  FOREIGN KEY (id_post) REFERENCES post(id)
);

CREATE TABLE  partecipazione (
	id          INT AUTO_INCREMENT PRIMARY KEY,
	id_post		  INT NOT NULL,
	id_utente   INT NOT NULL,

	FOREIGN KEY (id_utente) REFERENCES utente(id),
  FOREIGN KEY (id_post) REFERENCES post(id)
  CONSTRAINT Partecipazione_unica UNIQUE (id_post,id_utente)

);

#maybe i will add some index

SET FOREIGN_KEY_CHECKS = 1; -- Riabilita check
