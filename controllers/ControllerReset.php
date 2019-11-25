<?php
require_once('views/View.php');

class ControllerReset
{
	private $_view;
	private $_accountManager;

	public function __construct($url)
	{
		if (isset($url) && count($url) != 2)
			throw new Exception('Page Introuvable');
		else
			$this->reset($url[1]);
	}

	private function user($token)
	{
		$this->_accountManager = new AccountManager;
		if ($user = $this->_accountManager->verify($token))
		{
			//add send of pwd
			$this->_view = new View('Reset');
			$this->_view->generate(array('token' => $token, 'user' => $user));
		}
		else
			throw new Exception('token invalide');
	}
}

?>