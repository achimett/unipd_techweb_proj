<?php
/* CLASSE MOCK PER DB */
class DB extends mysqli{
	
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
		$query = $this->prepare("SELECT email,nome,cognome,datanascita,cf,bio,img_path FROM `utente` WHERE id=?");
		$query->bind_param("i", $id);
		$query->execute();
		$result = $query->get_result();
		
		/*preparo la query, la eseguo e ottengo i risultati*/
	
		if($result->num_rows === 0) exit('No rows'); /*check sul risultato ritornato*/
		
		$usr = $result->fetch_assoc(); /*traformo il risultato della query in un array associativo*/
		
		foreach($usr as $key => $value)
		{echo "\n".$key."  ".$usr["$key"];} /*ciclo per il debug*/
		
		returng $usr;
		
    }
}
?>
