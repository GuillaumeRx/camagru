<?php

class Account
{
	private $_id;
	private $_username;
	private $_pic;
	private $_bio;
	private $_notification;
	private $_email;

	public function __construct(array $data)
	{
		$this->hydrate($data);
	}

	public function hydrate(array $data)
	{
		foreach($data as $key => $value)
		{
			$method = 'set'.ucfirst($key);

			if (method_exists($this, $method))
				$this->$method($value);
		}
	}

	public function setId($id)
	{
		$id = (int)$id;

		if ($id > 0)
			$this->_id = $id;
	}
	public function setUsername($username)
	{
		if (is_string($username))
			$this->_username = $username;
	}
	public function setPic($pic)
	{
		if (is_string($pic))
			$this->_pic = $pic;
	}
	public function setBio($bio)
	{
		if (is_string($bio))
			$this->_bio = $bio;
	}
	public function setEmail($email)
	{
		if (is_string($email))
			$this->_email = $email;
	}
	public function setNotification($notification)
	{
		$notification = (int)$notification;

		if ($notification == 1 || $notification == 0)
			$this->_notification = $notification;
	}

	public function id()
	{
		return $this->_id;
	}
	public function username()
	{
		return $this->_username;
	}
	public function pic()
	{
		return $this->_pic;
	}
	public function bio()
	{
		return $this->_bio;
	}
	public function email()
	{
		return $this->_email;
	}
	public function notification()
	{
		return $this->_notification;
	}
}

?>