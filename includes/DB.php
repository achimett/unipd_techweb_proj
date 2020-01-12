<?php
/* CLASSE MOCK PER DB */
class DB extends mysqli{
	
	private $imgDir = '../img/upload/';
	private $namePattern = '/^[a-zA-Z ]{2,}$/' ;
	private $mailPattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/' ;
	private $passPattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,}$/' ; // Almeno 8 caratteri con almeno una maiuscola e un numero
	private $cfPattern = '/^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$/' ;
	private $cellPattern = '/^[0-9]{7,12}$/';
	
	public function __construct($host="localhost", $user="user", $pass="password", $db="doit") 
	{
        parent::__construct($host, $user, $pass, $db);
		
		if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
	}
	
	public function getUser($id = NULL) 
	{
		$query = $this->prepare("SELECT nome,cognome,img_path FROM `utente` WHERE id=?");
		$query->bind_param("i", $id);
		$query->execute();
		$result = $query->get_result();
		
		/*preparo la query, la eseguo e ottengo i risultati*/
	
		if($result->num_rows === 0) return NULL; /*check sul risultato ritornato*/
		
		$usr = $result->fetch_assoc(); /*traformo il risultato della query in un array associativo*/
		
		/*foreach($usr as $key => $value)
		{echo "\n".$key."  ".$usr["$key"];} */ /*ciclo per il debug*/
		
		return $usr;
		
    }
	
	public function getProfilo($id = NULL) 
	{
		$query = $this->prepare("SELECT email,nome,cognome,telefono,datanascita,cf,bio,img_path FROM `utente` WHERE id=?");
		$query->bind_param("i", $id);
		$query->execute();
		$result = $query->get_result();
		
		/*preparo la query, la eseguo e ottengo i risultati*/
	
		if($result->num_rows === 0) return NULL; /*check sul risultato ritornato*/
		
		$usr = $result->fetch_assoc(); /*traformo il risultato della query in un array associativo*/
		
		/*foreach($usr as $key => $value)
		{echo "\n".$key."  ".$usr["$key"];} */ /*ciclo per il debug*/
		
		return $usr;
		
    }
	
	public function setProfilo($id, $email, $password, $conf_password, $nome, $cognome, $datanascita, $cf, $bio, $img, $telefono)
	{
		
		$error = array();
		
		if (strlen($email) > 50) {$error[] = "mail tropppo lunga";}
		if (!preg_match($mailPattern,$mail)) {$error[] = "mail in formato errato";}
		if (!preg_match($passPattern,$password)) {$error[] = "password in formato errato";}
		If ($password !== $conf_password) {$error[] = "le password non coincidono";}
		if (!preg_match($namePattern, $nome)) {$error[] = "nome non valido";};
		if (!preg_match($nomePattern, $cognome)) {$error[] = "cognome non valido";};
		if (strlen($cf) !== 16) {$error[] = 'cf non valdio';} 
		if (strlen($bio) > 65535) {$error[] = "biografia troppo lunga";}
		if (strlen($bio) === 0) {$error[] = "nessuno biografia";}
		if ($_FILES['file']['size'] > 3000000) {$error[] = 'immagine troppo grande';}
		if (!exif_imagetype($img)) {$error[] = 'fomrato immagine errato';} // verifica se è un immagine
		if (!preg_match($cellPatter,$telefono)) {$error[] = "numero non valido";}
		
		if(count($error)) {return $error;} //se non ho passato alcuni check ritorno l'array con gli errori
		
		$hash = hash_file('sha256', $img);
		$hashed_pass = hash('sha256', $password);
		
		
		
		if (!move_uploaded_file($img, $imgDir.$hash)) {$error[] = "impossibile spostare l'immagine"; return $error;}
		
		if($id==0)
		{
			$query = $this->prepare("INSERT INTO utente(email,password,nome,cognome,telefono,datanascita,cf,bio,img_path) VALUES (?,?,?,?,?,?,?,?,?)");
			$query->bind_param("sssssssss", $email, $hashed_pass, $nome, $cognome, $datanascita, $cf, $bio, $img, $telefono);
			
			if($query->execute()) {return $this->insert_id;}
			else {return NULL;}
		}
		else
		{
			$query = $this->prepare("UPDATE utente SET email = ?,password = ?,nome = ?,cognome = ?,telefono = ?,datanascita = ?,cf = ?,bio = ?,img_path = ?  WHERE id=?");
			$query->bind_param("sssssssssi", $email, $hashed_pass, $nome, $cognome, $datanascita, $cf, $bio, $img, $telefono,$id);
			
			if($query->execute()) {return $id;}
			else {return NULL;}
			
		}
	
		
	}
	
	public function deleteProfilo($id)
	{	
		$clean_id = $this->real_escape_string($id);
		$delete = 'SET FOREIGN_KEY_CHECKS=0;'; 
		$delete.= "DELETE FROM utente WHERE id=$clean_id;";
		$delete.= "DELETE FROM post WHERE id_autore=$clean_id;";
		$delete.= "DELETE FROM partecipazione WHERE id_utente=$clean_id;";
		$delete.= 'SET FOREIGN_KEY_CHECKS=1;';
		
		return $this->multi_query($delete);
		
	
		
	}
}
?>
