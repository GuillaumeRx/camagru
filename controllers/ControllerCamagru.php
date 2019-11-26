<?php
require_once('views/View.php');

class ControllerCamagru
{
	private $_accountManager;
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else
			$this->camagru();
	}

	private function camagru()
	{
		$this->_accountManager = new AccountManager;
		if ($user = $this->_accountManager->sessionLogin())
		{
			$this->_view = new View('Camagru');
			$this->_view->generate(array('user' => $user));
		}
		else
			header('Location: /');
	}
}

?>