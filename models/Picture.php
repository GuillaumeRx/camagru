<?php

class Picture
{
	private $_id;
	private $_account_id;
	private $_account;
	private $_date;
	private $_url;
	private $_likes;
	private $_liked = false;
	private $_comments;

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
	public function setAccount($account)
	{
		$this->_account = $account;
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
	public function setLikes($likes)
	{
		if (is_array($likes))
			$this->_likes = $likes;
	}
	public function setLiked($liked)
	{
		if (is_bool($liked))
			$this->_liked = $liked;
	}
	public function setComments($comments)
	{
		$this->_comments = $comments;
	}

	public function id()
	{
		return $this->_id;
	}
	public function accountId()
	{
		return $this->_account_id;
	}
	public function account()
	{
		return $this->_account;
	}
	public function date()
	{
		return $this->_date;
	}
	public function url()
	{
		return $this->_url;
	}
	public function likes()
	{
		return $this->_likes;
	}
	public function liked()
	{
		return $this->_liked;
	}
	public function comments()
	{
		return $this->_comments;
	}
}

?>