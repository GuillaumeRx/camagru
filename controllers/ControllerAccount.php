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
		$uploaddir = 'media/';

		$this->_accountManager = new AccountManager;
		if ($account = $this->_accountManager->sessionLogin())
		{
			if (isset($_FILES['pic']))
			{
				$uploadfile = $uploaddir . basename($_FILES['pic']['name']);
				if (!file_exists($uploadfile))
				{
					if (move_uploaded_file($_FILES['pic']['tmp_name'], $uploadfile))
						$account = $this->_accountManager->editPicture($account->id(), basename($_FILES['pic']['name']));
				}
				else
				$account = $this->_accountManager->editPicture($account->id(), basename($_FILES['pic']['name']));
			}
			else if (isset($_POST['password_reset']) && isset($_POST['email']))
			{
				$this->_accountManager->callReset($account);
			}
			else if (isset($_POST['username']) || isset($_POST['email']) ||isset($_POST['bio']) || isset($_POST['notification']))
			{
				$account = $this->_accountManager->editAccount($account->id(), $_POST['username'], $_POST['email'], $_POST['bio'], $_POST['notification']);
			}
			$this->_view = new View('Account');
			$this->_view->generate(array('account' => $account));
		}
		else
			header('Location: /login');
	}
}

?>