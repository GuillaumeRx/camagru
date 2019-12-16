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

	public function sendNotification($email, $username)
	{
		$to = $email;
		$subject = "Tu as un nouveau commentaire sur ta photo !";
		$message = $username . " viens de commenter ta photo !";
		$headers = 'From: guillaume@guillaumerx.fr' . "\r\n" .
     				'Reply-To: guillaume@guillaumerx.fr' . "\r\n" .
     				'X-Mailer: PHP/' . phpversion();
		return (mail($to, $subject, $message, $headers));
	}

	public function sendPicture($path, $account)
	{
		$values = array(':account_id' => $account->id(), ':url' => $path);

		try
		{
			$req = $this->getBdd()->prepare('INSERT INTO pictures (account_id, url) VALUES (:account_id, :url)');
			$req->execute($values);
		}
		catch (PDOException $e)
		{
			throw new Exception('Query error');
		}
		$req->closeCursor();
	}

	public function processPhoto($picture_base, $filters_base, $account)
	{
		$width = 720;
		$height = 720;
		$base = imagecreatetruecolor($width, $height);
		$name = substr(md5(mt_rand()),0,15) . '.png';
		$save = './media/' . $name;
		imagesavealpha($base, true);
		$transparent = imagecolorallocatealpha($base, 0, 0, 0, 127);
		imagefill($base, 0, 0, $transparent);
 		$picture = imagecreatefromstring(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $picture_base)));
		$filters = imagecreatefromstring(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $filters_base)));
		imagecopy($base, $picture, 0, 0, 0, 0, $width, $height);
		imagecopy($base, $filters, 0, 0, 0, 0, $width, $height);
		imagepng($base, $save);
		imagedestroy($picture);
		imagedestroy($filters);
		$this->sendPicture($name, $account);
	}

	public function deletePicture($picture_id)
	{
		$values = array(':id' => $picture_id);
		
		try
		{
			$req = $this->getbdd()->prepare('DELETE FROM pictures WHERE (id = :id)');
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