<?php
require_once('views/View.php');

class Controller518
{
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else
			$this->imateapot();
	}

	private function imateapot()
	{
		$this->_view = new View('518');
		$this->_view->generate(array());
	}
}

?>