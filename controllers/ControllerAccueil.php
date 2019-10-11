<?php

class ControllerAccueil
{
	private $_pictureManager;
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else
			$this->pictures();
	}

	private function pictures()
	{
		$this->_pictureManager = new PictureManager;
		$pictures = $this->_pictureManager->getPictures();

		require_once('views/viewAccueil.php');
	}
}

?>