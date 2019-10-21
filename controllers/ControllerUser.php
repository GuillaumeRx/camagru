<?php
require_once('views/View.php');

class ControllerUser
{
	private $_view;
	private $_accountManager;
	private $_pictureManager;

	public function __construct($url)
	{
		if (isset($url) && count($url) < 2)
			throw new Exception('Page Introuvable');
		else
			$this->user($url);
	}

	private function user($url)
	{
		$this->_accountManager = new AccountManager;
		$this->_pictureManager = new PictureManager;
		if ($user = $this->_accountManager->getUserByUsername($url[1]))
		{
			$pictures = $this->_pictureManager->getAccountPictures($user->id());
			$this->_view = new View('User');
			$this->_view->generate(array('user' => $user, 'pictures' => $pictures));
		}
		else
			throw new Exception('Utilisateur Introuvable');
	}
}

?>