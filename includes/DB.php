<?php
/* CLASSE MOCK PER DB */
class DB extends mysqli{
	
	private $imgDir = '../img/up/';
	private $namePattern = '/^[a-zA-Z ]{2,}$/' ;
	private $mailPattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/' ;
	private $passPattern = '/^(?=.*[0-9])(?=.*[A-Z]).{8,}$/' ; // Almeno 8 caratteri con almeno una maiuscola e un numero
	private $cfPattern = '/^[a-zA-Z]{6}[0-9]{2}[abcdehlmprstABCDEHLMPRST]{1}[0-9]{2}([a-zA-Z]{1}[0-9]{3})[a-zA-Z]{1}$/' ;
	private $cellPattern = '/^[0-9]{9,12}$/';
	
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
		if (strlen($email) > 50) {echo "mail tropppo lunga";}
		if (!preg_match($mailPattern,$mail)) {echo "$mail is not a valid mail";}
		if (!preg_match($passPattern,$password)) {echo "$password is not a valid pass";}
		If ($password !== $conf_password) {echo "le pass non coincidono";}
		if (!preg_match($namePattern, $nome)) {echo "nome non valido";};
		if (!preg_match($nomePattern, $cognome)) {echo "cognome non valido";};
		if (strlen($cf) !== 16) {echo 'Cf non valdio';} 
		if (strlen($bio) > 65535) {echo "bio too long";}
		if (strlen($bio) === 0) {echo "no bio??";}
		if ($_FILES['file']['size'] > 3000000) {echo 'immagine troppo grande';}
		if (!exif_imagetype($img)) {echo 'invalid image';} // verifica se è un immagine
		if (!preg_match($cellPatter,$telefono)) {echo "numero non valido"; return null;}
		
		
		$hash = hash_file('sha256', $img);
		
		if (!move_uploaded_file($img, $imgDir.$hash)) {echo 'can\'t move file';}
		
		if($id===0)
		{
			
		}
		else
		{
			
		}
	
		
	}
}
?>
