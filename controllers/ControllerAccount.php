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
			$this->account();
	}

	private function account()
	{
		$this->_accountManager = new AccountManager;
		if (isset($_POST['email']) && isset($_POST['password']))
		{
			if ($account = $this->_accountManager->login($_POST['email'], $_POST['password']))
			{
				$this->_accountManager->RegisterLoginSession($account->id());
				$this->_view = new View('Account');
				$this->_view->generate(array('account' => $account));
			}
			else
			{
				$this->_view = new View('Login');
				$this->_view->generate(array());
			}

		}
		else if ($account = $this->_accountManager->sessionLogin())
		{
			$this->_view = new View('Account');
			$this->_view->generate(array('account' => $account));
		}
		else
		{
			$this->_view = new View('Login');
			$this->_view->generate(array());
		}
	}
}

?>