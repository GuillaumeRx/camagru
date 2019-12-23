<?php
require_once('views/View.php');

class ControllerCamagru
{
	private $_accountManager;
	private $_pictureManager;
	private $_view;

	public function __construct($url)
	{
		if (isset($url) && count($url) > 1)
			throw new Exception('Page Introuvable');
		else
			$this->camagru();
	}

	private function camagru()
	{
		$this->_accountManager = new AccountManager;
		$this->_pictureManager = new PictureManager;
		if ($user = $this->_accountManager->sessionLogin())
		{
			if (isset($_POST['picture']) && isset($_POST['filters']))
			{
				$this->_pictureManager->processPhoto(htmlspecialchars($_POST['picture']), htmlspecialchars($_POST['filters']), $user);
			}
			else if (isset($_POST['delete']))
			{
				$this->_pictureManager->deletePicture(htmlpecialchar($_POST['delete']));
			}
			$pictures = $this->_pictureManager->getAccountPictures($user->id());
			$this->_view = new View('Camagru');
			$this->_view->generate(array('user' => $user, 'pictures' => $pictures));
		}
		else
			header('Location: /login');
	}
}

?>