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

	public function getUserByUsername($username)
	{
		$values = array(':username' => $username);
		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM accounts WHERE (username = :username)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$data = $req->fetch(PDO::FETCH_ASSOC);
		if (is_array($data))
			return new Account($data);
		return null;
		$req->closeCursor();
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

	private function sendmail($email, $token)
	{
		$to = $email;
		$subject = "Ton code d'activation";
		$message = "Voici ton lien d'activation : " . $_SERVER['SERVER_NAME'] . "/activate" . "/" . $token;
		$headers = 'From: guillaume@guillaumerx.fr' . "\r\n" .
     				'Reply-To: guillaume@guillaumerx.fr' . "\r\n" .
     				'X-Mailer: PHP/' . phpversion();
		return (mail($to, $subject, $message, $headers));
	}

	public function register($username, $password, $email)
	{
		$username = trim($username);
		$password = trim($password);
		$email = trim($email);
		$token = substr(md5(mt_rand()),0,15);

		if (!$this->isNameValid($username))
			throw new Exception('Invalid Username');
		if (!$this->isPasswdValid($password))
			throw new Exception('Invalid Password');
		if (!$this->isEmailValid($email))
			throw new Exception('Invalid Email');
		if (!is_null($this->getIdFromEmail($email)))
			throw new Exception('User already exist');
		if (!is_null($this->getIdFromUsername($username)))
			throw new Exception('Username not available');
		
		$hash = password_hash($password, PASSWORD_BCRYPT);
		$values = array(':username' => $username, ':password' => $hash, ':email' => $email, ':token' => $token);

		try
		{
			$req = $this->getBdd()->prepare('INSERT INTO accounts (username, password, email, token) VALUES (:username, :password, :email, :token)');
			$req->execute($values);
			$req->closeCursor();
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		if (!$this->sendmail($email, $token))
			throw new Exception('Mail error');
	}

	public function verifyAccount($token)
	{
		$values = array(':token' => $token);
		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM accounts WHERE (token = :token) AND (active = 0)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$data = $req->fetch(PDO::FETCH_ASSOC);
		if (is_array($data))
		{
			$values = array(':id' => $data['id']);
			
			try
			{
				$req = $this->getBdd()->prepare('UPDATE accounts SET active = 1 WHERE (id = :id)');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
			return true;
		}
		return false;
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

	public function editAccount($id, $username, $email, $bio, $notification)
	{
		$username = trim($username);
		$password = trim($password);
		$notification = $notification == "on" ? 1 : 0;


		if (!$this->isIdValid($id))
			throw new Exception('Invald account ID');
		if (!$this->isNameValid($username))
			throw new Exception('Invalid username');
		if (!$this->isEmailValid($email))
			throw new Exception('Invalid email');
		
		$idFromEmail = $this->getIdFromEmail($email);
		if (!is_null($idFromEmail) && $idFromEmail != $id)
			throw new Exception('Email already used');

		$idFromName = $this->getIdFromUsername($username);
		if (!is_null($idFromName) && $idFromName != $id)
			throw new Exception('Username already used');

		$values = array(':id' => $id, ':username'=> $username, ':email' => $email, ':bio' => $bio, 'notification' => $notification);

		try
		{
			$req = $this->getBdd()->prepare('UPDATE accounts SET username = :username, email = :email, bio = :bio, notification = :notification WHERE id = :id');
			$req->execute($values);
			$values = array(':id' => $id);
			$req = $this->getBdd()->prepare('SELECT * FROM accounts WHERE id = :id');
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

	public function editPicture($id, $pic)
	{

		if (!$this->isIdValid($id))
			throw new Exception('Invald account ID');
		$values = array(':id' => $id, ':pic' => $pic);

		try
		{
			$req = $this->getBdd()->prepare('UPDATE accounts SET pic = :pic WHERE id = :id');
			$req->execute($values);
			$values = array(':id' => $id);
			$req = $this->getBdd()->prepare('SELECT * FROM accounts WHERE id = :id');
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

	public function getAccountFromId($id)
	{
		$values = array(':id' => $id);
		
		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM accounts WHERE id = :id');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception ('Query error here');
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

	public function searchAccount($username)
	{
			$tab = array();
			$values = array(':username' => $username . '%');
			try
			{
				$req = $this->getBdd()->prepare("SELECT id, username, pic, bio, email FROM accounts WHERE username LIKE :username");
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
			while ($data = $req->fetch(PDO::FETCH_ASSOC))
			{
				$tab[] = $data;
			}
			return $tab;
			$req->closeCursor();
	}

	public function sendReset($email, $token)
	{
		$to = $email;
		$subject = "Reinitialisation de ton mot de passe";
		$message = "Voici ton lien : " . $_SERVER['SERVER_NAME'] . "/reset" . "/" . $token;
		$headers = 'From: guillaume@guillaumerx.fr' . "\r\n" .
     				'Reply-To: guillaume@guillaumerx.fr' . "\r\n" .
     				'X-Mailer: PHP/' . phpversion();
		return (mail($to, $subject, $message, $headers));
	}

	public function callReset($account)
	{
		$token = substr(md5(mt_rand()),0,15);

		$values = array(':email' => $account->email(), ':token' => $token);

		try
		{
			$req = $this->getBdd()->prepare('INSERT INTO password_reset (email, token) VALUES (:email, :token)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}

		$this->sendReset($account->email(), $token);
		$req->closeCursor();
	}

	public function verifyToken($token)
	{
		$values= array(':token' => $token);

		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM password_reset WHERE (token = :token)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}

		$data = $req->fetch(PDO::FETCH_ASSOC);
		if (is_array($data))
			return $data;
		else
			return null;
		$req->closeCursor();
	}
}

?>