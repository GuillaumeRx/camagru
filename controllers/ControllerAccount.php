<?php
require_once('views/View.php');

class ControllerAccount
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

		if (isset($this->_accountManager) && $this->_accountManager->isAuthenticated())
		{
			$this->_view = new View('Account');
			$this->_view->generate(array('account' => $account));
		}
		else if (session_status() == PHP_SESSION_ACTIVE)
		{
			$this->_accountManager = new accountManager;
			$account = $this->_accountManager->sessionlogin();
			$this->_view = new View('Account');
			$this->_view->generate(array('account' => $account));
		}
		else if (isset($_POST['email']) && isset($_POST['password']))
		{
			
			$this->_accountManager = new accountManager;
			if ($account = $this->_accountManager->login($_POST['email'], $_POST['password']))
			{
				$this->_accountManager->registerLoginSession($account->id());
				$this->_view = new View('Account');
				$this->_view->generate(array('account' => $account));
			}
			$this->_view = new View('Login');
			$this->_view->generate(array());
		}
		else
		{
			$this->_view = new View('Login');
			$this->_view->generate(array());
		}
	}
}

?>