<?php
require_once('views/View.php');

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

		$this->_view = new View('Accueil');
		$this->_view->generate(array('pictures' => $pictures));
	}
}

?>