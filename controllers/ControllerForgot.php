<?php
require_once('views/View.php');

class ControllerForgot
{
	private $_accountManager;
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else
			$this->forgot();
	}

	private function forgot()
	{
		$this->_accountManager = new AccountManager;
		if (isset($_POST['email']))
			if ($this->_accountManager->callReset($_POST['email']))
				$success = true;
		$this->_view = new View('Forgot');
		$this->_view->generate(array('success' => $success));
	}
}

?>