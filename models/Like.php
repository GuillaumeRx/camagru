<?php

class Like
{
	private $_account_id;
	private $_picture_id;
	private $_username;

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

	public function setAccount_id($account_id)
	{
		$account_id = (int)$account_id;

		if ($account_id > 0)
			$this->_account_id = $account_id;
	}
	public function setPicture_id($picture_id)
	{
		$picture_id = (int)$picture_id;

		if ($picture_id > 0)
			$this->_picture_id = $picture_id;
	}
	public function setUsername($username)
	{
		if (is_string($username))
			$this->_username = $username;
	}

	public function picture_id()
	{
		return $this->_picture_id;
	}
	public function account_id()
	{
		return $this->_account_id;
	}
	public function username()
	{
		return $this->_username;
	}
}

?>