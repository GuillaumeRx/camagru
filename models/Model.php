/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   Model.php                                          :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: guroux <guroux@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/10/02 18:57:57 by guroux            #+#    #+#             */
/*   Updated: 2019/10/02 19:01:58 by guroux           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

<?php

abstract class Model
{
	private static $_bdd;

	private static function setBdd()
	{
		require_once('config/database.php'); 

		self::$_bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPT);
		self::$_bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
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
		$req = $this->getBdd()->prepare('SELECT * FROM'.table.'ORDER BY id desc');
		$req->execute();
		while($data = $req->fetch(PDO::FETCH_ASSOC))
		{
			$var[] = new $obj($data);
		}
		return $var;
		$req->closeCursor();
	}
}


?>