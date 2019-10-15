<?php
require_once('views/View.php');

class ControllerLogout
{
	private $_accountManager;
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else
			$this->logout();
	}

	private function logout()
	{
		$this->_accountManager = new AccountManager;
		$this->_accountManager->logout();
		$this->_view = new View('Logout');
		$this->_view->generate(array());
	}
}

?>