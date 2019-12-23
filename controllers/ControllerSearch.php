<?php
require_once('views/View.php');

class ControllerSearch
{
	private $_accountManager;
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) != 2)
			throw new Exception('Page Introuvable');
		else
			$this->search($url);
	}

	private function search($url)
	{
		$this->_accountManager = new AccountManager;
		if (is_array($ret = $this->_accountManager->searchAccount(htmlspecialchars($url[1]))))
		{
			$data = json_encode($ret);
			echo $data;
		}
	}
	
}

?>