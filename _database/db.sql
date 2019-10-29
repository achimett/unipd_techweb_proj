--Droppa db gia esiste

Drop database if exists Doit;

--Crea db

Create database Doit;

--Passa al db creato

Use Doit;

-- Disabilita check su vincoli di integrità referenziale

SET FOREIGN_KEY_CHECKS=0;

-- Ripulisce, eliminando le tabelle qualora esistesserò già

Drop table if exists Utente , Post , Commento , Img ;

CREATE TABLE Utente(
                    ID  INT auto_increment PRIMARY KEY,
                    Email VARCHAR(50) NOT NULL,
                    Password VARCHAR(30) NOT NULL,
                    Nome VARCHAR(30) NOT NULL,
       	            Cognome VARCHAR(30) NOT NULL,
	                DataNascita DATE NOT NULL,
	                CF VARCHAR(16) NOT NULL,
	                Bio TEXT NOT NULL,
	                Img_path VARCHAR(256) not null DEFAULT 'Immagini/user/default.jpg'
	                );
	                
CREATE TABLE Post(
                    ID  INT auto_increment PRIMARY KEY,
                    Titolo VARCHAR(50) NOT NULL,
                    ID_Autore INT NOT NULL,
                    Data TIMESTAMP not null,
                    Text TEXT not null,
                    Img_path VARCHAR(256) not null DEFAULT 'Immagini/post/default.jpg',
                    Img_closed_path VARCHAR(256) not null DEFAULT 'Immagini/post/default_closed.jpg',
                    LAT DECIMAL(10,7),
                    LON DECIMAL(10,7),
                    Chiuso BOOLEAN not null default 0,
                    FOREIGN KEY (ID_Autore) REFERENCES Utente(ID)
	                );	                
                   
CREATE TABLE Commento(
                    ID  INT auto_increment PRIMARY KEY,
                    ID_Autore INT NOT NULL,
                    ID_Post INT NOT NULL,
                    Data TIMESTAMP not null,
                    Text TEXT not null,
                    FOREIGN KEY (ID_Autore) REFERENCES Utente(ID),
                    FOREIGN KEY (ID_Post) REFERENCES Post(ID)
	                );	
CREATE TABLE Img(
                 ID  INT auto_increment PRIMARY KEY,
                 ID_Autore INT NOT NULL,
                 ID_Post INT NOT NULL,
                 Data TIMESTAMP not null,
                 Img_path VARCHAR(256) not null DEFAULT 'Immagini/post/default.jpg',
                 FOREIGN KEY (ID_Autore) REFERENCES Utente(ID),
                 FOREIGN KEY (ID_Post) REFERENCES Post(ID)
	                );
                
-- Riabilita check

SET FOREIGN_KEY_CHECKS=1;
                   
                    
