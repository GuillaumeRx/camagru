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
			$this->_accountManager->register(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']), htmlspecialchars($_POST['email']));
			header('Location: /login');
		}
		$this->_view = new View('Register');
		$this->_view->generate(array());
	}
}

?>