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
				$token = substr(md5(mt_rand()),0,15);
				
				$path = $_FILES['pic']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$uploadfile = move_uploaded_file($_FILES['pic']['tmp_name'], $uploaddir . "/" . $token . "." . $ext);
				$account = $this->_accountManager->editPicture($account->id(), $token . "." . $ext);
			}
			else if (isset($_POST['password_reset']))
			{
				$this->_accountManager->callReset($account->email());
			}
			else if (isset($_POST['username']) || isset($_POST['email']) ||isset($_POST['bio']) || isset($_POST['notification']))
			{
				$account = $this->_accountManager->editAccount($account->id(), htmlspecialchars($_POST['username']), htmlspecialchars($_POST['email']), htmlspecialchars($_POST['bio']), htmlspecialchars($_POST['notification']));
			}
			$this->_view = new View('Account');
			$this->_view->generate(array('account' => $account));
		}
		else
			header('Location: /login');
	}
}

?>