<?php

class Setup
{
	private static $_bdd;

	private static function setBdd()
	{
		require_once('./database.php'); 
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

	public function getBdd()
	{
		if (self::$_bdd == null)
			$this->setBdd();
		return self::$_bdd;
	}
}

$sql = file_get_contents('./database_dump.sql');

$setup = new Setup;

try
{
$setup->getBdd()->exec($sql);
}
catch (PDOException $e)
{
	throw new Exception('Error while hydrating database');
}
?>