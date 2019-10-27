<?php

class Comment
{
	private $_id;
	private $_account_id;
	private $content;
	private $_account;

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
	public function setContent($content)
	{
		if (is_string($content))
			$this->_content = $content;
	}
	public function setAccount($account)
	{
			$this->_account = $account;
	}

	public function id()
	{
		return $this->_id;
	}
	public function account_id()
	{
		return $this->_account_id;
	}
	public function content()
	{
		return $this->_content;
	}
	public function account()
	{
		return $this->_account;
	}
}

?>