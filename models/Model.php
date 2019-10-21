<?php

abstract class Model
{
	private static $_bdd;

	private static function setBdd()
	{
		require_once('config/database.php'); 
		try
		{
			self::$_bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			self::$_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOExeption $e)
		{
			echo 'Connexion échouée : ' . $e->getMessage();
		}
	}

	protected function getBdd()
	{
		if (self::$_bdd == null)
			$this->setBdd();
		return self::$_bdd;
	}

	protected function getAll($table, $obj)
	{
		$var = [];
		$req = $this->getBdd()->prepare('SELECT * FROM '.$table.' ORDER BY ID desc');
		$req->execute();
		while ($data = $req->fetch(PDO::FETCH_ASSOC))
		{
			$var[] = new $obj($data);
		}
		return $var;
		$req->closeCursor();
	}
}


?>