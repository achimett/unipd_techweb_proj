<?php
class DB extends mysqli{

	private $imgDir = 'img/upload/';
	private $namePattern = "/^[a-zA-Z \\'\\s\é\è\ò\à\ù\ì]{2,30}$/" ;
	private $mailPattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/' ;
	private $passPattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,}$/' ; // Almeno 8 caratteri con almeno una maiuscola e un numero
	private $cfPattern = '/^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$/' ;
	private $cellPattern = '/^[0-9]{7,12}$/';
	private $max_img_size = 3000000; // 3MB
	private $perm_img_format = array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG);

	//public function __construct($host="localhost:8889", $user="root", $pass="root", $db="doit")
	public function __construct($host="localhost", $user="dbrescia", $pass="kainoolay9ojaeQu", $db="dbrescia")
	//public function __construct($host="localhost", $user="root", $pass="", $db="doit")
	{
        parent::__construct($host, $user, $pass, $db);

		if (mysqli_connect_error()) {
           	 die();
        	}
	}


	public function empty() {
		$sql = "SET FOREIGN_KEY_CHECKS = 0;DELETE FROM commento;ALTER TABLE doit.commento AUTO_INCREMENT = 1;DELETE FROM partecipazione;ALTER TABLE doit.partecipazione AUTO_INCREMENT = 1;DELETE FROM post;ALTER TABLE doit.post AUTO_INCREMENT = 1;DELETE FROM utente;ALTER TABLE doit.utente AUTO_INCREMENT = 1;SET FOREIGN_KEY_CHECKS = 1";
		$query = explode(';', $sql);
		foreach ($query as $q) {
			$this->query($q);
		}
	}

	public function addUserUser() {
		$password = hash('sha256', 'user');
		$query = "INSERT INTO utente(email, password, nome, cognome, telefono, datanascita, cf, bio) VALUES ('user', '$password', 'Utente', 'Generico', '333333333', '1999-11-11', 'MMTBBS70T51C217U', 'La mia Biografia')";
		$this->query($query);
	}

	public function validateDate($date, $format = 'Y-m-d H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}

	public function getUser($id = NULL)
	{
		$sql = "SELECT nome,cognome,img_path FROM `utente` WHERE id=?";
		$query = $this->prepare($sql);
		$query->bind_param("i", $id);
		$query->execute();
		$result = $query->get_result();

		/*preparo la query, la eseguo e ottengo i risultati*/

		if($result->num_rows === 0) return NULL; /*check sul risultato ritornato*/

		$usr = $result->fetch_assoc(); /*traformo il risultato della query in un array associativo*/

		/*foreach($usr as $key => $value)
		{echo "\n".$key."  ".$usr["$key"];} */ /*ciclo per il debug*/

		$query->close();
		$result->free();

		return $usr;

    }

	public function getProfilo($id = NULL)
	{
		$sql = "SELECT email,nome,cognome,telefono,DATE_FORMAT(datanascita,'%d/%m/%Y') as datanascita,cf,bio,img_path FROM `utente` WHERE id=?";
		$query = $this->prepare($sql);
		$query->bind_param("i", $id);
		$query->execute();
		$result = $query->get_result();

		/*preparo la query, la eseguo e ottengo i risultati*/

		if($result->num_rows === 0) return NULL; /*check sul risultato ritornato*/

		$usr = $result->fetch_assoc(); /*traformo il risultato della query in un array associativo*/

		/*foreach($usr as $key => $value)
		{echo "\n".$key."  ".$usr["$key"];} */ /*ciclo per il debug*/

		$query->close();
		$result->free();

		return $usr;

    }

	public function setProfilo($id, $email, $password, $conf_password, $nome, $cognome, $datanascita, $cf, $bio, $img, $telefono)
	{


		$error = array();

		if (strlen($email) > 50) {$error[] = "Mail tropppo lunga (Max: 50 caratteri)";}
		if (!preg_match($this->mailPattern,$email)) {$error[] = "Mail in formato errato";}

		if (!preg_match($this->passPattern,$password))
		{
			if(!$id || ($id && !empty($password)))
			{$error[] = "Password in formato errato, la password deve essere rispettare i seguenti requisiti: deve essere di almeno 8 caratteri con almeno una maiuscola e un numero";}
		}

		If ($password !== $conf_password) {$error[] = "Le password non coincidono";}
		if (!preg_match($this->namePattern, $nome)) {$error[] = "Nome non valido, non sono concesse lettere accentate (min: 2 caratteri, max: 30 caratteri)";};
		if (!preg_match($this->namePattern, $cognome)) {$error[] = "Cognome non valido, non sono concesse lettere accentate (min: 2 caratteri, max: 30 caratteri)";}
		if (!$this->validateDate($datanascita , "d/m/Y")){$error[] = "Data non valida, (formato data: dd/mm/aaaa)";}
		if (strlen($cf) !== 16) {$error[] = 'Codice fiscale non valido';}
		if (strlen($bio) > 65535) {$error[] = "Biografia troppo lunga (max: 65535 caratteri)";}
		if (strlen($bio) === 0) {$error[] = "Biografia mancante, inserire una biografia";}
		if (!preg_match($this->cellPattern,$telefono)) {$error[] = "Numero di telefono non valido, inserire solo numeri (min: 7 numeri, max: 12 numeri)";}
		if (!$id && $er = $this->alreadyReg($email,$cf))
		{
			foreach($er as $e)
			{$error[] = $e;}
		}

		$date = str_replace('/', '-', $datanascita);
		$datanascita = date('Y-m-d', strtotime($date));

		$date_now = date("Y-m-d");

		if($datanascita > $date_now) {$error[] = "Devi mettere una data passata";}
		//else if((int)($date_now - $datanascita) < 3) {$error[] = "Sei un prodigio per essere un bebè";}
		//else if((int)($date_now - $datanascita) < 13) {$error[] = "Apprezziamo la buona voltà ma sei troppo giovane per iscriverti a questo sito :(";}

		$hashed_pass = hash('sha256', $password);

		$img_path = '';

		if(!empty($img))
		{
			$img_format = exif_imagetype($img);
			if(!in_array($img_format , $this->perm_img_format)) {$error[] = 'Formato immagine errato, inserire un immagine in formato PNG o JPEG';} 	 // verifica se è un immagine
			if (filesize($img) > $this->max_img_size) {$error[] = 'Immagine troppo grande (max: 3MB)';}
			$hash = hash_file('sha256', $img);
			if (!move_uploaded_file($img, $this->imgDir.$hash)) {$error[] = "Impossibile spostare l'immagine";}
			$img_path = $this->imgDir.$hash;
			$this->crop($img_path,1);
		}

		if(count($error)) {return $error;}

		$bio=htmlentities($bio);

		if($id==0) //new profilo
		{
			if(!empty($img_path)) //aggiorno l'immagine
			{
				$register = "INSERT INTO utente(email,password,nome,cognome,telefono,datanascita,cf,bio,img_path) VALUES (?,?,?,?,?,?,?,?,?)";

				$query = $this->prepare($register);
				$query->bind_param("sssssssss", $email, $hashed_pass, $nome, $cognome,$telefono, $datanascita, $cf, $bio, $img_path);

				if($query->execute())
				{
					$new_id = $this->insert_id;
					$_SESSION['user_id']= $new_id;
					$query->close();
					return $new_id;
				}
				else {return NULL;}
			}
			else //new con immagine di default
			{
				$register = "INSERT INTO utente(email,password,nome,cognome,telefono,datanascita,cf,bio) VALUES (?,?,?,?,?,?,?,?)";

				$query = $this->prepare($register);
				$query->bind_param("ssssssss", $email, $hashed_pass, $nome, $cognome,$telefono, $datanascita, $cf, $bio);

				if($query->execute())
				{
					$new_id = $this->insert_id;
					$_SESSION['user_id']= $new_id;
					$query->close();
					return $new_id;
				}
				else {return NULL;}
			}
		}
		else //edit profilo
		{
			if(empty($password)) //non reimposta
			{
					if(!empty($img_path)) //aggiorno l'immagine
					{
						$update = "UPDATE utente SET email = ?,nome = ?,cognome = ?,telefono = ?,datanascita = ?,cf = ?,bio = ?,img_path = ?  WHERE id=?";

						$query = $this->prepare($update);
						$query->bind_param("ssssssssi", $email,$nome, $cognome,$telefono, $datanascita, $cf, $bio, $img_path,$id);

						if($query->execute()) {$query->close(); return $id;}
						else {return NULL;}
					}
					else //lascio img vecchia
					{
						$update = "UPDATE utente SET email = ?,nome = ?,cognome = ?,telefono = ?,datanascita = ?,cf = ?,bio = ? WHERE id=?";

						$query = $this->prepare($update);
						$query->bind_param("sssssssi", $email, $nome, $cognome,$telefono, $datanascita, $cf, $bio,$id);

						if($query->execute()) {$query->close(); return $id;}
						else {return NULL;}
					}
			}
			else //reimposta pass
			{
				if(!empty($img_path)) //aggiorno l'immagine
					{
						$update = "UPDATE utente SET email = ?,password = ?,nome = ?,cognome = ?,telefono = ?,datanascita = ?,cf = ?,bio = ?,img_path = ?  WHERE id=?";

						$query = $this->prepare($update);
						$query->bind_param("sssssssssi", $email, $hashed_pass, $nome, $cognome,$telefono, $datanascita, $cf, $bio, $img_path,$id);

						if($query->execute()) {$query->close(); return $id;}
						else {return NULL;}
					}
				else //lascio img vecchia
					{
						$update = "UPDATE utente SET email = ?,password = ?,nome = ?,cognome = ?,telefono = ?,datanascita = ?,cf = ?,bio = ? WHERE id=?";

						$query = $this->prepare($update);
						$query->bind_param("ssssssssi", $email, $hashed_pass, $nome, $cognome,$telefono, $datanascita, $cf, $bio,$id);

						if($query->execute()) {$query->close(); return $id;}
						else {return NULL;}
					}
			}

		}
	}

	public function deleteProfilo($id)
	{
		$sql  = "DELETE pa FROM partecipazione pa JOIN post po ON pa.id_post = po.id WHERE pa.id_utente = ? OR po.id_autore = ?;";
		$sql2 = "DELETE co FROM commento co JOIN post po ON co.id_post = po.id WHERE po.id_autore = ? OR co.id_autore = ?";
		$sql3 = "DELETE FROM post WHERE id_autore = ? ;";
		$sql4 = "DELETE FROM utente WHERE id = ? ;";


		$query =  $this->prepare($sql);
		$query2 = $this->prepare($sql2);
		$query3 = $this->prepare($sql3);
		$query4 = $this->prepare($sql4);

		$query->bind_param("ii", $id, $id);
		$query2->bind_param("ii", $id, $id);
		$query3->bind_param("i", $id);
		$query4->bind_param("i", $id);


		if(!$query->execute())
		{
			return NULL;
		}
		$query->close();

		if(!$query2->execute())
		{
			return NULL;
		}
		$query2->close();

		if(!$query3->execute())
		{
			return NULL;
		}
		$query3->close();

		if($query4->execute())
		{
			$res = $this->affected_rows;
			$query4->close();
			return (bool)$res;
		}
		return NULL;
	}

	public function login($username, $password)
	{
		$hashed_pass = hash('sha256', $password);

		$sql = "SELECT id FROM `utente` WHERE email = ? AND password = ? LIMIT 1;";
		$query = $this->prepare($sql);
		$query->bind_param("ss", $username,$hashed_pass);
		if(!$query->execute()) {return NULL;}
		$result = $query->get_result();

		if($result->num_rows === 0) return FALSE;

		$row = $result->fetch_assoc();

		$query->close();
		$result->free();

		$_SESSION['user_id'] = $row['id'];
		return TRUE;

	}

	public function logout()
	{
		unset($_SESSION['user_id']);
	}

	public function getPost($id)
	{
		$sql = "SELECT  p.id,p.titolo,p.id_autore,u.nome,u.cognome, DATE_FORMAT(data,'%d/%m/%Y') AS data, DATE_FORMAT(data,'%H:%i') AS ora,p.descrizione,p.img_path,p.provincia,p.luogo,p.chiuso, (SELECT COUNT(*) FROM post p JOIN partecipazione pa ON p.id = pa.id_post WHERE p.id = ?)  as nvolontari  FROM post p JOIN utente u ON p.id_autore = u.id WHERE p.id = ?";
		$query = $this->prepare($sql);
		$query->bind_param("ii", $id, $id);
		$query->execute();
		$result = $query->get_result();

		$post = $result->fetch_assoc();

		if($post['id'] === NULL) {return NULL;}

		$query->close();
		$result->free();

		return $post;
	}

	public function deletePost($id)
	{

		$sql = "DELETE FROM partecipazione WHERE id_post= ? ;";
		$sql2 = "DELETE FROM commento WHERE id_post= ?";
		$sql3 = "DELETE FROM post WHERE id= ?;";

		$query = $this->prepare($sql);
		$query2 = $this->prepare($sql2);
		$query3 = $this->prepare($sql3);

		$query->bind_param("i", $id);
		$query2->bind_param("i", $id);
		$query3->bind_param("i", $id);


		if(!$query->execute())
		{
			$query->close();
			return NULL;
		}

		if(!$query2->execute())
		{
			$query2->close();
			return NULL;
		}

		$query->close();

		if($query3->execute())
		{
			$res = $this->affected_rows;
			$query3->close();
			return (bool)$res;
		}
	}

	public function setPost($id, $titolo, $id_autore, $data, $ora, $descrizione, $img, $luogo, $provincia)
	{
		$error = array();



		if (strlen($titolo) === 0) {$error[] = "Titolo mancante, inserire un titolo";}
		if (strlen($titolo) > 100) {$error[] = "Titolo troppo lungo (max: 100 caratteri)";}
		if (!$this->validateDate($data , "d/m/Y")){$error[] = "Data non valida, (formato data: dd/mm/aaaa)";};
		if (!$this->validateDate($ora , "H:i")){$error[] = "Ora non valida, (formato ora: hh:mm)";};
		if (strlen($descrizione) === 0) {$error[] = "Descrizione mancante, inserire una descrizione";}
		if (strlen($descrizione) > 1000) {$error[] = "Descrizione troppo lunga (max: 1000 caratteri)";}
		if (strlen($luogo) === 0) {$error[] = "Luogo mancante, inserire un luogo";}
		if (strlen($luogo) > 150) {$error[] = "Luogo troppo lungo (max: 150 caratteri)";}
		if (strlen($provincia) === 0) {$error[] = "Provincia mancante, inserire una provincia";}
		if (strlen($provincia) > 50) {$error[] = "Provincia troppo lunga (max: 50 caratteri)";}

		$date = str_replace('/', '-', $data);
		$date = date('Y-m-d', strtotime($date));
		$dataora = $date." ".$ora;

		$date_now = date("Y-m-d H:i");

		if($dataora < $date_now) {$error[] = "Devi mettere una data futura";}

		$img_path = '';

		if(!empty($img))
		{
			$img_format = exif_imagetype($img);
			if(!in_array($img_format , $this->perm_img_format)) {$error[] = 'Formato immagine errato, inserire un immagine in formato PNG o JPEG';} // verifica se è un immagine
			if (filesize($img) > $this->max_img_size) {$error[] = 'Immagine troppo grande (max: 3MB)';}

			$hash = hash_file('sha256', $img);
			if (!move_uploaded_file($img, $this->imgDir.$hash)) {$error[] = "Impossibile spostare l'immagine";}
			$img_path = $this->imgDir.$hash;
			$this->crop($img_path,2);
		}

		if(count($error)) {return $error;} //se non ho passato alcuni check ritorno l'array con gli errori

		$titolo = htmlentities($titolo); //pulizia input
		$descrizione = htmlentities($descrizione);
		$luogo = htmlentities($luogo);
		$provincia = htmlentities($provincia);

		if($id==0) //nuovo post
		{

			if(!empty($img_path)) //con immagine
			{
				$insert = "INSERT INTO post(titolo,id_autore,data,descrizione,img_path,luogo,provincia) VALUES (?,?,?,?,?,?,?)";
				$query = $this->prepare($insert);
				$query->bind_param("sisssss", $titolo, $id_autore, $dataora, $descrizione, $img_path, $luogo, $provincia);
				if($query->execute())
					{
						$new_id = $this->insert_id;
						$query->close();
						return $new_id;
					}
				else {return NULL;}
			}
			else //senza img
			{
				$insert = "INSERT INTO post(titolo,id_autore,data,descrizione,luogo,provincia) VALUES (?,?,?,?,?,?)";
				$query = $this->prepare($insert);
				$query->bind_param("sissss", $titolo, $id_autore, $dataora, $descrizione,$luogo, $provincia);
				if($query->execute())
					{
						$new_id = $this->insert_id;
						$query->close();
						return $new_id;
					}
				else {return NULL;}
			}
		}
		else //edit post
		{
			if(!empty($img_path)) //con immagine
			{
				$update = "UPDATE post SET titolo = ?,id_autore = ?,data = ?,descrizione = ?,img_path = ?,luogo = ?,provincia = ? WHERE ID =?;";
				$query = $this->prepare($update);
				$query->bind_param("sisssssi", $titolo, $id_autore, $dataora, $descrizione, $img_path, $luogo, $provincia, $id);
				if($query->execute())
					{
						$query->close();
						return $id;
					}
				else {return NULL;}
			}
			else //senza img
			{
				$update = "UPDATE post SET titolo = ?,id_autore = ?,data = ?,descrizione = ?,luogo = ?,provincia = ? WHERE ID =?;";
				$query = $this->prepare($update);
				$query->bind_param("sissssi", $titolo, $id_autore, $dataora, $descrizione,$luogo, $provincia, $id);

				if($query->execute())
					{
						$query->close();
						return $id;
					}
				else {return NULL;}
			}
		}
	}
	public function abbandona($id_post, $id_utente)
	{
		$sql = "DELETE FROM partecipazione WHERE id_post = ? AND id_utente = ?;";
		$query = $this->prepare($sql);
		$query->bind_param("ii", $id_post,$id_utente);

		if($query->execute())
		{
			$res = $this->affected_rows;
			$query->close();
			return (bool)$res;
		}

		return NULL;
	}

	public function partecipa($id_post, $id_utente)
	{
		$sql = "INSERT INTO partecipazione(id_post,id_utente) VALUES (?,?);";
		$query = $this->prepare($sql);
		$query->bind_param("ii", $id_post,$id_utente);

		if($query->execute())
		{
			$res = $this->affected_rows;
			$query->close();
			return (bool)$res;
		}

		return NULL;
	}

	public function apri($id_post)
	{
		$sql = "UPDATE post SET chiuso = 0 WHERE id = ?;";
		$query = $this->prepare($sql);
		$query->bind_param("i", $id_post);

		if($query->execute())
		{
			$res = $this->affected_rows;
			$query->close();
			return (bool)$res;
		}

		return NULL;
	}


	public function chiudi($id_post)
	{
		$sql = "UPDATE post SET chiuso = 1 WHERE id = ?;";
		$query = $this->prepare($sql);
		$query->bind_param("i", $id_post);

		if($query->execute())
		{
			$res = $this->affected_rows;
			$query->close();
			return (bool)$res;
		}

		return NULL;
	}


	public function isChiuso($id_post)
	{
		$sql = "SELECT chiuso FROM post WHERE id = ? AND chiuso = 1;";
		$query = $this->prepare($sql);
		$query->bind_param("i", $id_post);

		if($query->execute())
		{
			$isChiuso = $query->get_result()->num_rows;
			$query->close();
			return (bool)$isChiuso;
		}

		return NULL;
	}

	public function isPartecipante($id_post, $id_utente)
	{
		$sql = "SELECT id FROM partecipazione WHERE id_post = ? AND id_utente = ?;";
		$query = $this->prepare($sql);
		$query->bind_param("ii", $id_post,$id_utente);

		if($query->execute())
		{
			$isPartecipante = $query->get_result()->num_rows;
			$query->close();
			return (bool)$isPartecipante;
		}

		return NULL;
	}
	public function isAutore($id_post, $id_utente)
	{
		$sql = "SELECT chiuso FROM post WHERE id = ? AND id_autore = ?;";
		$query = $this->prepare($sql);
		$query->bind_param("ii", $id_post,$id_utente);

		if($query->execute())
		{
			$isAutore = $query->get_result()->num_rows;
			$query->close();
			return (bool)$isAutore;
		}

		return NULL;
	}

	public function postExist($id)
	{
		$sql = "SELECT chiuso FROM post WHERE id = ?;";
		$query = $this->prepare($sql);
		$query->bind_param("i", $id);

		if($query->execute())
		{
			$exist = $query->get_result()->num_rows;
			$query->close();
			return (bool)$exist;
		}

		return NULL;
	}

	public function deleteCommento($id)
	{
		$sql = "DELETE FROM commento WHERE id = ?;";
		$query = $this->prepare($sql);
		$query->bind_param("i", $id);

		if($query->execute())
		{
			$res=$this->affected_rows;
			$query->close();
			return (bool)$res;
		}

		return NULL;
	}

	public function getCommenti($id)
	{

		$sql = "SELECT c.id, c.id_autore,u.nome,u.cognome,CONCAT(DATE_FORMAT(data,'%d/%m/%Y'),' ', DATE_FORMAT(data,'%H:%i:%s')) AS data,";
		$sql.= "c.text,u.img_path AS img_user_path,c.img_path FROM commento c JOIN utente u ON c.id_autore = u.id WHERE c.id_post = ?;";
		$query = $this->prepare($sql);
		$query->bind_param("i", $id);

		if($query->execute())
		{
			$result = $query->get_result();
			$postSocial = array();

			 while ($row = $result->fetch_assoc())
			{
				$postSocial[] = $row;
			}

			$query->close();
			$result->free();
			return $postSocial;

		}

		return NULL;
	}

	public function getProfiloTable($id, $status = 0)
	{
		$sql = "SELECT id, titolo,DATE_FORMAT(data,'%d/%m/%Y') AS data, chiuso FROM post WHERE id_autore = ? ";

		if($status > 0 ) {
			$sql .= "AND chiuso = 0";
		} else if($status < 0) {
			$sql .= "AND chiuso = 1";
		}

		$query = $this->prepare($sql);
		$query->bind_param("i", $id);

		if($query->execute())
		{
			$result = $query->get_result();
			$profTable = array();

			while ($row = $result->fetch_assoc())
			{
				$profTable[] = $row;
			}

			$query->close();
			$result->free();


			$sql1 = "SELECT po.id, po.titolo,DATE_FORMAT(po.data,'%d/%m/%Y') AS data, po.chiuso FROM partecipazione pa JOIN post po ON pa.id_post = po.id WHERE pa.id_utente = ? ";

			if($status > 0) {$sql1 .= "AND po.chiuso = 0";}
			if($status < 0) {$sql1 .= "AND po.chiuso = 1";}

			$query1 = $this->prepare($sql1);
			$query1->bind_param("i", $id);

			if($query1->execute())
			{
				$result1 = $query1->get_result();

				 while ($row = $result1->fetch_assoc())
				{
					$profTable[] = $row;
				}

				$query1->close();
				$result1->free();
				return $profTable;
			}
		}

		return NULL;
	}

	public function getVolontari($id)
	{
		$sql = "SELECT u.id,u.nome,u.cognome, u.img_path FROM partecipazione p JOIN utente u ON p.id_utente = u.id WHERE p.id_post = ?";

		$query = $this->prepare($sql);
		$query->bind_param("i", $id);

		if($query->execute())
		{
			$result = $query->get_result();
			$volontari = array();

			 while ($row = $result->fetch_assoc())
			{
				$volontari[] = $row;
			}

			$query->close();
			$result->free();
			return $volontari;

		}

		return NULL;
	}

	public function newCommento($id, $user_id, $messaggio, $foto)
	{
		$error = array();
		$immagine = NULL;

		if(empty($messaggio) && empty($foto)) {return "Parametri non validi";}

		if(!empty($foto))
		{
			$img_format = exif_imagetype($foto);

			if (filesize($foto) > $this->max_img_size) {$error[] = 'Immagine troppo grande (max: 3MB)';}
			if(!in_array($img_format , $this->perm_img_format)) {$error[] = 'Formato immagine errato, inserire un immagine in formato PNG o JPEG';}

			if(count($error)) {return $error;}

			$hash = hash_file('sha256', $foto);



			if (!move_uploaded_file($foto, $this->imgDir.$hash)) {$error[] = "Impossibile spostare l'immagine"; return $error;}

			$immagine = $this->imgDir.$hash;
			$this->crop($immagine,2);

		}

		$messaggio = htmlentities($messaggio);
			$sql = "INSERT INTO commento(id_autore,id_post,text,img_path) VALUES(?, ?, ? ,?);";

			$query = $this->prepare($sql);

			$query->bind_param('iiss',$user_id,$id,$messaggio,$immagine);

			if($query->execute())
			{
				$new_id = $this->insert_id;
				$query->close();
				return $new_id;
			}
			else {return NULL;}
	}

	public function getPostcard($page, $postcard_per_page, &$page_count, $filter = NULL)
	{
		$sql = "SELECT po.id,po.titolo,DATE_FORMAT(po.data,'%d/%m/%Y') AS data,po.provincia,po.luogo, po.img_path, COUNT(pa.id) AS nvolontari, po.descrizione FROM post po LEFT JOIN partecipazione pa ON po.id = pa.id_post GROUP BY po.id";

		if(!empty($filter)) {$sql .= " HAVING po.provincia LIKE '%".$this->real_escape_string($filter)."%'";}

		$sql .= " ORDER BY po.id DESC";

		if($result = $this->query($sql))
		{
			$card = array();

			while ($row = $result->fetch_assoc())
			{
				if(strlen($row['descrizione']) > 100)
				{
					$row['descrizione'] = substr($row['descrizione'], 0, 100) . '...';
				}

					$card[] = $row;

			}

			$page_count = ceil($result->num_rows/$postcard_per_page);

			$selcard = array_slice($card, ($page-1)*$postcard_per_page, $postcard_per_page);

			$result->free();

			return $selcard;

		}

		return NULL;
	}

	public function alreadyReg($mail , $cf)
	{
		$error = array();

		$sql = "SELECT id FROM utente WHERE email = ?;";
		$query = $this->prepare($sql);
		$query->bind_param("s", $mail);

		if($query->execute())
		{
			if($query->get_result()->num_rows)
			{
				$query->close();
				$error[] = "Mail già presente";
			}


		}
		else
		{
			$error[] = "Impossibile contattare il db per verificare l'unicità dell'account";
		}

		$sql1 = "SELECT id FROM utente WHERE cf = ?;";
		$query = $this->prepare($sql1);
		$query->bind_param("s", $cf);

		if($query->execute())
		{
			if($query->get_result()->num_rows)
			{
				$query->close();
				$error[] = "Codice fiscale già presente";
			}


		}
		else
		{
			$error[] = "Impossibile contattare il db per verificare l'unicità dell'account";
		}

		if(count($error)) {return $error;}

		return FALSE;
	}

	public function crop($img,$rap=1)
	{
		$im = imagecreatefromstring(file_get_contents($img));

		$size = min(imagesx($im), imagesy($im));

		$x = imagesx($im);

		$y = imagesy($im);

		$media = ($x - $y) / 2;
		$media2 = ($y - $x)/ 2;

		if($media > $media2)
		{
		$crop_img = imagecrop($im, ['x' => $media, 'y' => ($y-($size/$rap))/2, 'width' => $size, 'height' => $size/$rap]);
		}
		else
		{
		$crop_img = imagecrop($im, ['x' => 0, 'y' => ($y-($size/$rap))/2, 'width' => $size, 'height' => $size/$rap]);
		}
		imagepng($crop_img, $img);


		}
}
?>
