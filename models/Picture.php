<?php

class Picture
{
	private $_id;
	private $_userId;
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
	public function setUserId($userId)
	{
		$userId = (int)$id;

		if ($userId > 0)
			$this->_userId = $userId;
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
	public function userId()
	{
		return $this->_userId;
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