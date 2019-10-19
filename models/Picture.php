<?php

class Picture
{
	private $_id;
	private $_account_id;
	private $_username;
	private $_date;
	private $_url;

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
	public function setAccount_id($account_id)
	{
		$account_id = (int)$account_id;

		if ($account_id > 0)
			$this->_account_id = $account_id;
	}
	public function setUsername($username)
	{
		if (is_string($username))
			$this->_username = $username;
	}
	public function setDate($date)
	{
		$this->_date = $date;
	}
	public function setUrl($url)
	{
		if (is_string($url))
			$this->_url = $url;
	}

	public function id()
	{
		return $this->_id;
	}
	public function accountId()
	{
		return $this->_account_id;
	}
	public function username()
	{
		return $this->_username;
	}
	public function date()
	{
		return $this->_date;
	}
	public function url()
	{
		return $this->_url;
	}
}

?>