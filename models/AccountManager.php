<?php

class AccountManager extends Model
{
	public function isNameValid(string $username):bool
	{
		$len = nb_len($username);
		return ($len < 8 || $len > 16) ? false : true;
	}
	public function isPasswdValid(string $password):bool
	{
		return (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/gm', $password)) ? true : false;
	}
	public function isEmailValid(string $email):bool
	{
		return (preg_match("/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g", $email)) ? true : false;
	}
	public function getIdFromEmail(string $email): ?int
	{
		$values = array(':email' => $email);
		try
		{
			$req = $this->getBdd()->prepare('SELECT id FROM accounts WHERE (email = :email)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$data = $req->fetch(PDO::FETCH_ASSOC);
		if (is_array($data))
			$id = intval($data['id'], 10);
		return $id;
		$req->closeCursor();
	}

	private function registerLoginSession()

	public function register(string $username, string $password, string $email)
	{
		$username = trim($username);
		$password = trim($password);
		$email = trim($email);

		if (!$this->isNameValid($username))
			throw new Exception('Invalid Username');
		if (!isPasswdValid($password))
			throw new Exception('Invalid Password');
		if (!isEmailValid($email))
			throw new Exception('Invalid Email');
		if (!is_null($this->getIdFromEmail($username)))
			throw new Exception('User already exist');
		
		$hash = password_hash($password, PASSWORD_BCRYPT);
		$values = array(':username' => $username, ':password' => $hash);

		try
		{
			$req = $this->getBdd()->prepare('INSERT INTO accounts (username, password, email) VALUES (:username, :password, :email)');
			$req->execute($values);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
	}

	public function login(string $username, string $password): bool
	{
		$email = trim($email);
		$password = trim($password);

		if (!$this->isEmailValid($email))
			return false;
		if (!$this->isPasswdValid($password))
			return false;
		
		$values = array(':email' => $email);
		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM accounts WHERE (email = :email)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}

		$data = $req->fetch(PDO::FETCH_ASSOC);
		
		if (is_array($data))
		{
			if (password_verify($password, $data['password']))
			{
				$account = new Account($data);
				$account->setAuth(true);

				$this->registerLoginSession();
				return true;
				$req->closeCursor();
			}
		}
		return false;
	}
}

?>