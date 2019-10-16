<?php

class AccountManager extends Model
{
	public function isNameValid($username)
	{
		$len = strlen($username);
		return ($len < 8 || $len > 16) ? false : true;
	}
	public function isPasswdValid($password)
	{
		return (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/', $password)) ? true : false;
	}
	public function isEmailValid($email)
	{
		return (preg_match('/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/', $email)) ? true : false;
	}
	public function getIdFromEmail($email)
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
	public function getIdFromUsername($username)
	{
		$values = array(':username' => $username);
		try
		{
			$req = $this->getBdd()->prepare('SELECT id FROM accounts WHERE (username = :username)');
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
	public function isIdValid($id)
	{
		return (($id >= 1) && ($id <= 1000000)) ? true : false;
	}

	public function registerLoginSession($id)
	{
		if (session_status() == PHP_SESSION_ACTIVE)
		{
			$values = array(':id' => session_id(), ':account_id' => $id);

			try
			{
				$req = $this->getBdd()->prepare('REPLACE INTO account_sessions (id, account_id, login_time) VALUES (:id, :account_id, NOW())');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
			$req->closeCursor();
		}
	}

	public function sessionLogin()
	{
		if (session_status() == PHP_SESSION_ACTIVE)
		{
			$values = array('id' => session_id());
			try
			{
				$req = $this->getBdd()->prepare('SELECT * FROM account_sessions, accounts WHERE (account_sessions.id = :id) ' . 
				'AND (account_sessions.login_time >= (NOW() - INTERVAL 7 DAY)) AND (account_sessions.account_id = accounts.id) ');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}

			$data = $req->fetch(PDO::FETCH_ASSOC);

			if (is_array($data))
				return new Account($data);
			$req->closeCursor();
		}
	}

	public function register($username, $password, $email)
	{
		$username = trim($username);
		$password = trim($password);
		$email = trim($email);

		if (!$this->isNameValid($username))
			throw new Exception('Invalid Username');
		if (!$this->isPasswdValid($password))
			throw new Exception('Invalid Password');
		if (!$this->isEmailValid($email))
			throw new Exception('Invalid Email');
		if (!is_null($this->getIdFromEmail($email)))
			throw new Exception('User already exist');
		
		$hash = password_hash($password, PASSWORD_BCRYPT);
		$values = array(':username' => $username, ':password' => $hash, ':email' => $email);

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

	public function login($email, $password)
	{
		$email = trim($email);
		$password = trim($password);

		if (!$this->isEmailValid($email))
			throw new Exception('Invalid email');
		if (!$this->isPasswdValid($password))
		throw new Exception('Invalid password');

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
				return new Account($data);
				$req->closeCursor();
			}
		}
		return null;
	}

	public function editAccount($id, $username, $email, $password)
	{
		$username = trim($username);
		$password = trim($password);

		if (!$this->isIdValid($id))
			throw new Exception('Invald account ID');
		if (!$this->isUsernameValid($username))
			throw new Exception('Invalid username');
		if (!$this->isEmailValid($email))
			throw new Exception('Invalid email');
		if (!$this->isPasswdValid($password))
			throw new Exception('Invalid password');
		
		$idFromEmail = $this->getIdFromEmail($email);
		if (!is_null($idFromEmail) && $idFromEmail != $id)
			throw new Exception('Email already used');

		$idFromName = $this->getIdFromUsername($username);
		if (!is_null($idFromName) && $idFromName != $id)
			throw new Exception('Username already used');

		$hash = password_hash($password, PASSWORD_BCRYPT);

		$values = array(':username'=> $username, ':email' => $emai, ':password' => $hash);

		try
		{
			$req = $this->getBdd()->prepare('UPDATE accounts SET username = :username, email = :email, password = :password WHERE id = :id');
			$req->execute($values);
			$req->prepare('SELECT * FROM accounts WHERE id = :id');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}

		$data = $req->fetch(PDO::FETCH_ASSOC);

		return new Account($data);
		$req->closeCursor();
	}

	public function logout()
	{
		if (session_status() == PHP_SESSION_ACTIVE)
		{
			$values = array(':id' => session_id());

			try
			{
				$req = $this->getBdd()->prepare('DELETE FROM account_sessions WHERE (id = :id)');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
			session_destroy();
			$req->closeCursor();
		}
	}
}

?>