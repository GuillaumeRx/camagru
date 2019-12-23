<?php
require_once('views/View.php');

class ControllerActivate
{
	private $_accountManager;
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) != 2)
			throw new Exception('Page Introuvable');
		else
			$this->verify($url);
	}

	private function verify($url)
	{
		$this->_accountManager = new AccountManager;
		$ret = $this->_accountManager->verifyAccount(htmlspecialchars($url[1]));
		$this->_view = new View('Activate');
		$this->_view->generate(array('return' => $ret));
	}
}

?>