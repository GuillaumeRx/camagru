<?php
require_once('views/View.php');

class ControllerAccueil
{
	private $_pictureManager;
	private $_accountManager;
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
		$this->_accountManager = new AccountManager;
		if (isset($_POST["picture_id"]) && isset($_POST['account_id']) && isset($_POST["comment"]) && $account = $this->_accountManager->sessionLogin())
		{
			$this->_pictureManager->commentPicture($_POST["picture_id"], $_POST["comment"], $account->id());
			$pictureAccount = $this->_accountManager->getAccountFromId($_POST['account_id']);
			if ($pictureAccount->notification())
				$this->_pictureManager->sendNotification($pictureAccount->email(), $account->username());
		}
		else if (isset($_POST["picture_id"]) && $account = $this->_accountManager->sessionLogin())
			$this->_pictureManager->likePicture($_POST["picture_id"], $account->id());
		$pictures = $this->_pictureManager->getPictures();
		if ($account = $this->_accountManager->sessionLogin())
		{
			foreach ($pictures as $picture)
			{
				foreach ($picture->likes() as $like)
				{
					if ($like->account_id() == $account->id())
						$picture->setLiked(true);
				}
			}
		}
		$this->_view = new View('Accueil');
		$this->_view->generate(array('pictures' => $pictures));
	}
}

?>