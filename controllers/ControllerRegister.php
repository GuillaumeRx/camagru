<?php
require_once('views/View.php');

class ControllerRegister
{
	private $_accountManager;
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else
			$this->register();
	}

	private function register()
	{
		if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']))
		{
			
			$this->_accountManager = new accountManager();
			$this->_accountManager->register($_POST['username'], $_POST['password'], $_POST['email']);
			$this->_view = new View('Registered');
			$this->_view->generate(array());
		}
		$this->_view = new View('Register');
		$this->_view->generate(array());
	}
}

?>