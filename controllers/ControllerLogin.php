<?php
require_once('views/View.php');

class ControllerLogin
{
	private $_accountManager;
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else
			$this->login();
	}

	private function login()
	{
		$this->_accountManager = new AccountManager;
		if ($this->_accountManager->sessionLogin())
			header("Location: /account");
		else
		{
			if (isset($_POST['email']) && isset($_POST['password']))
			{
				if ($account = $this->_accountManager->login(htmlspecialchars($_POST['email']), htmlspecialchars($_POST['password'])))
				{
					$this->_accountManager->RegisterLoginSession($account->id());
					header('Location: /account');
				}
				else
				{
					$this->_view = new View('Login');
					$this->_view->generate(array());
				}

			}
			else
			{
				$this->_view = new View('Login');
				$this->_view->generate(array());
			}
		}
	}
}

?>