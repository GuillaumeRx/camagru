<?php

class PictureManager extends Model
{

	public function alreadyLiked($picture_id, $account_id)
	{
		$values = array(":account_id" => $account_id, ":picture_id" => $picture_id);

		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM likes WHERE (picture_id = :picture_id) AND (account_id = :account_id)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		return $req->fetch(PDO::FETCH_ASSOC);
		$req->closeCursor();
	}

	public function getLikes($picture_id)
	{
		$likes = array();
		$values = array('picture_id' => $picture_id);

		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM likes WHERE (picture_id = :picture_id)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}

		while ($data = $req->fetch(PDO::FETCH_ASSOC))
			$likes[] = new Like($data);
		foreach ($likes as $like)
		{
			$values = array(':id' => $like->account_id());
			try
			{
				$req = $this->getBdd()->prepare('SELECT * FROM accounts WHERE (id = :id)');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');;
			}
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$account = new Account($data);
			$like->setAccount($account);
			$req->closeCursor();
		}
		return $likes;
		$req->closeCursor();
	}

	public function getComments($picture_id)
	{
		$comments = array();
		$values = array('picture_id' => $picture_id);

		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM comments WHERE (picture_id = :picture_id) ORDER BY date ASC');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}

		while ($data = $req->fetch(PDO::FETCH_ASSOC))
			$comments[] = new Comment($data);
		foreach ($comments as $comment)
		{
			$values = array(':id' => $comment->account_id());
			try
			{
				$req = $this->getBdd()->prepare('SELECT * FROM accounts WHERE (id = :id)');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');;
			}
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$account = new Account($data);
			$comment->setAccount($account);
			$req->closeCursor();
		}
		return $comments;
		$req->closeCursor();
	}

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
				throw new Exception('Query error');;
			}
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$account = new Account($data);
			$picture->setAccount($account);
			$picture->setLikes($this->getLikes($picture->id()));
			$picture->setComments($this->getComments($picture->id()));
			$req->closeCursor();
		}
		return $pictures;
	}

	public function getAccountPictures($account_id)
	{
		$pictures = array();
		$values = array(':account_id' => $account_id);
		try
		{
			$req = $this->getBdd()->prepare('SELECT * FROM pictures WHERE (account_id = :account_id) ORDER BY date DESC');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		while ($data = $req->fetch(PDO::FETCH_ASSOC))
		{
			$pictures[] = new Picture($data);
		}
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
				throw new Exception('Query error');;
			}
			$data = $req->fetch(PDO::FETCH_ASSOC);
			$account = new Account($data);
			$picture->setAccount($account);
			$picture->setLikes($this->getLikes($picture->id()));
			$picture->setComments($this->getComments($picture->id()));
			$req->closeCursor();
		}
		return $pictures;
		$req->closeCursor();
	}

	public function likePicture($picture_id, $account_id)
	{
		$values = array(":account_id" => $account_id, ":picture_id" => $picture_id);

		if ($this->alreadyLiked($picture_id, $account_id))
		{
			try
			{
				$req = $this->getBdd()->prepare('DELETE FROM likes WHERE (picture_id = :picture_id) AND (account_id = :account_id)');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
		}
		else
		{
			try
			{
				$req = $this->getBdd()->prepare('INSERT INTO likes (picture_id, account_id) VALUES (:picture_id, :account_id)');
				$req->execute($values);
			}
			catch (PDOException $e)
			{
				throw new Exception('Query error');
			}
		}
		$req->closeCursor();
	}

	public function commentPicture($picture_id, $comment, $account_id)
	{
		$values = array(":picture_id" => $picture_id, ":content" => $comment, ":account_id" => $account_id);

		try
		{
			$req = $this->getBdd()->prepare('INSERT INTO comments (picture_id, account_id, content) VALUES (:picture_id, :account_id, :content)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

}

?>