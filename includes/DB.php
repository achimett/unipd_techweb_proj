<?php
/* CLASSE MOCK PER DB */
class DB extends mysqli{
	
	private $imgDir = '../img/upload/';
	private $namePattern = '/^[a-zA-Z ]{2,30}$/' ;
	private $mailPattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/' ;
	private $passPattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,}$/' ; // Almeno 8 caratteri con almeno una maiuscola e un numero
	private $cfPattern = '/^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$/' ;
	private $cellPattern = '/^[0-9]{7,12}$/';
	private $max_img_size = 3000000; // 3MB
	private $perm_img_format = array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP);
	
	
	public function __construct($host="localhost", $user="root", $pass="", $db="doit") 
	{
        parent::__construct($host, $user, $pass, $db);
		
		if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
	}
	
	function validateDate($date, $format = 'Y-m-d H:i:s')
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
		$sql = "SELECT email,nome,cognome,telefono,datanascita,cf,bio,img_path FROM `utente` WHERE id=?";
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
		$img_format = exif_imagetype($img);
		
		if (strlen($email) > 50) {$error[] = "mail tropppo lunga";}
		if (!preg_match($this->mailPattern,$mail)) {$error[] = "mail in formato errato";}
		if (!preg_match($this->passPattern,$password)) {$error[] = "password in formato errato";}
		If ($password !== $conf_password) {$error[] = "le password non coincidono";}
		if (!preg_match($this->namePattern, $nome)) {$error[] = "nome non valido";};
		if (!preg_match($nomePattern, $cognome)) {$error[] = "cognome non valido";}
		if (!checkdate($data , "d/m/Y")){$error[] = "data non valida";}
		if (!checkdate($data , "H:i:s")){$error[] = "ora non valida";}
		if (strlen($cf) !== 16) {$error[] = 'cf non valdio';} 
		if (strlen($bio) > 65535) {$error[] = "biografia troppo lunga";}
		if (strlen($bio) === 0) {$error[] = "nessuno biografia";}
		if (filesize($img) > $this->max_img_size) {$error[] = 'immagine troppo grande';}
		if(!in_array($img_format , $this->perm_img_format)) {$error[] = 'formato immagine errato';} // verifica se è un immagine
		if (!preg_match($cellPatter,$telefono)) {$error[] = "numero non valido";}
		
		if(count($error)) {return $error;} //se non ho passato alcuni check ritorno l'array con gli errori
		
		$date = str_replace('/', '-', $datanascita);
		$datanascita = date('Y-m-d', strtotime($date));
		
		$hash = hash_file('sha256', $img);
		$hashed_pass = hash('sha256', $password);
		
		
		
		if (!move_uploaded_file($img, $this->imgDir.$hash)) {$error[] = "impossibile spostare l'immagine"; return $error;}
		
		if($id==0)
		{
			$register = "INSERT INTO utente(email,password,nome,cognome,telefono,datanascita,cf,bio,img_path) VALUES (?,?,?,?,?,?,?,?,?)";
			
			$query = $this->prepare($register);
			$query->bind_param("sssssssss", $email, $hashed_pass, $nome, $cognome, $datanascita, $cf, $bio, $this->imgDir.$hash, $telefono);
			
			if($query->execute()) 
			{
				$new_id = $this->insert_id; 
				$_SESSION['user_id']= $new_id; 
				$query->close();
				return $new_id;
			}
			else {return NULL;}
		}
		else
		{
			$update = "UPDATE utente SET email = ?,password = ?,nome = ?,cognome = ?,telefono = ?,datanascita = ?,cf = ?,bio = ?,img_path = ?  WHERE id=?";
			
			$query = $this->prepare($update);
			$query->bind_param("sssssssssi", $email, $hashed_pass, $nome, $cognome, $datanascita, $cf, $bio, $this->imgDir.$hash, $telefono,$id);
			
			if($query->execute()) {$query.close(); return $id;}
			else {return NULL;}
			
		}
	
		
	}
	
	public function deleteProfilo($id)
	{	
		$sql  = "DELETE pa FROM partecipazione pa JOIN post po ON pa.id_post = po.id WHERE pa.id_utente = ? OR po.id_autore = ?;";
		$sql2 = "DELETE FROM post WHERE id_autore= ?;";
		$sql3 = "DELETE FROM utente WHERE id= ? ;";

		
		$query =  $this->prepare($sql);
		$query2 = $this->prepare($sql2);
		$query3 = $this->prepare($sql3);
		
		$query->bind_param("ii", $id, $id);
		$query2->bind_param("i", $id);
		$query3->bind_param("i", $id);
		
		
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
		
		if($query3->execute())
		{
			$res = $this->affected_rows;
			$query3->close();
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
	
	 public function getPost($id = NULL) 
	{
		$sql = "SELECT  p.id,p.titolo,p.id_autore, DATE_FORMAT(data,'%d/%m/%Y') AS data, DATE_FORMAT(data,'%H:%i:%s') AS ora,p.descrizione,p.img_path,p.provincia,p.luogo,p.chiuso, COUNT(*) as nvolontari FROM post p JOIN partecipazione pa ON p.id = pa.id_post WHERE p.id = ? ";
		$query = $this->prepare($sql);
		$query->bind_param("i", $id);
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
		$sql2 = "DELETE FROM post WHERE id= ?;";
		
		$query = $this->prepare($sql);
		$query2 = $this->prepare($sql2);
		
		$query->bind_param("i", $id);
		$query2->bind_param("i", $id);
		
		
		if(!$query->execute())
		{
			$query->close();
			return NULL;
		}
		
		$query->close();
		
		if($query2->execute())
		{
			$res = $this->affected_rows;
			$query2->close();
			return (bool)$res;
		}
	}
	
	public function setPost($id, $titolo, $id_autore, $data, $ora, $descrizione, $img, $luogo, $provincia)
	{
		$error = array();
		
		$img_format = exif_imagetype($img);
		
		if (strlen($titolo) === 0) {$error[] = "Titolo mancante";}
		if (strlen($titolo) > 100) {$error[] = "Titolo troppo lungo";}
		if (!checkdate($data , "d/m/Y")){$error[] = "data non valida";};
		if (!checkdate($ora , "H:i:s")){$error[] = "ora non valida";};
		if (strlen($descrizione) === 0) {$error[] = "Descrizione vuota";}
		if (strlen($descrizione) > 65535) {$error[] = "Descrizione troppo lunga";}
		if (strlen($titolo) === 0) {$error[] = "Luogo mancante";}
		if (strlen($titolo) > 150) {$error[] = "Luogo troppo lungo";}
		if (strlen($titolo) === 0) {$error[] = "Provincia mancante";}
		if (strlen($titolo) > 50) {$error[] = "Provincia troppo lunga";}  
		
		
		//50 PER UNA PROVINCIA NON è TROPPO ??????
		
		$date = str_replace('/', '-', $data);
		$date = date('Y-m-d', strtotime($date));
		$dataora = $date." ".$ora;
		
		if (filesize($img) > $this->max_img_size) {$error[] = 'immagine troppo grande';}
		if(!in_array($img_format , $this->perm_img_format)) {$error[] = 'formato immagine errato';} // verifica se è un immagine

		if(count($error)) {return $error;} //se non ho passato alcuni check ritorno l'array con gli errori
		
		$hash = hash_file('sha256', $img);

		if (!move_uploaded_file($img, $this->imgDir.$hash)) {$error[] = "impossibile spostare l'immagine"; return $error;}
		
		if($id==0)
		{	
			$insert = "INSERT INTO post(titolo,id_autore,data,descrizione,img_path,luogo,provincia) VALUES (?,?,?,?,?,?,?,?,?)";
			$query = $this->prepare($insert);
			$query->bind_param("sisssss", $titolo, $autore, $dataora, $descrizione, $this->imgDir.$hash, $luogo, $provincia);
			if($query->execute()) 
				{
					$new_id = $this->insert_id; 
					$query->close();
					return $new_id;
				}
			else {return NULL;}
		}
		else
		{
			$update = "UPDATE post SET titolo = ?,id_autore = ?,data = ?,descrizione = ?,img_path = ?,luogo = ?,provincia = ?) WHERE ID =?;";
			$query = $this->prepare($update);
			$query->bind_param("sisssssi", $titolo, $autore, $dataora, $descrizione, $img_path, $luogo, $provincia, $id);
			if($query->execute()) 
				{
					$query->close();
					return $id;
				}
			else {return NULL;}
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
		$sql = "SELECT chiuso FROM post WHERE id = ?;";
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
		$sql.= "c.text,c.img_path AS img_user_path,c.img_path FROM commento c JOIN utente u ON c.id_autore = u.id WHERE c.id_post = ?;"; 
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
		$sql = "SELECT id, titolo, CONCAT(DATE_FORMAT(data,'%d/%m/%Y'),' ', DATE_FORMAT(data,'%H:%i:%s')) AS data, chiuso FROM post WHERE id_autore = ? ";
		
		if($status ===  1 ) {$sql .= "AND chiuso = 0";}
		if($status === -1 ) {$sql .= "AND chiuso = 1";}
		
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
			return $profTable;
		
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
		
		if(empty($messaggio) && empty($foto)) {return "Parametri invalidi";}
		
		if(!empty($foto))
		{
			$img_format = exif_imagetype($foto);
		
			if (filesize($foto) > $this->max_img_size) {$error[] = 'immagine troppo grande';}
			if(!in_array($img_format , $this->perm_img_format)) {$error[] = 'formato immagine errato';}
		
			if(count($error)) {return $error;}
				
			$hash = hash_file('sha256', $foto);
				
			if (!move_uploaded_file($foto, $this->imgDir.$hash)) {$error[] = "impossibile spostare l'immagine"; return $error;}
			
			$immagine = $this->imgDir.$hash;
		
		}	
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
	
	public function getPostcard($page, $postcard_per_page, &$page_count, $filter = NULL){}
}
?>
