<?php

class PictureManager extends Model
{
	public function getPictures()
	{
		$this->getBdd();
		$pictures = $this->getAll('pictures', 'Picture');
		foreach ($pictures as $picture)
		{
			$values = array(':id' => $picture->accountId());
			try
			{
				$req = $this->getBdd()->prepare('SELECT * FROM accounts WHERE (id = :id)');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$account = new Account($data);
			$picture->setUsername($account->username());
			$req->closeCursor();
		}
		return $pictures;
	}
}

?>