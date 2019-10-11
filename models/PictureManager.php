<?php

class PictureManager extends Model
{
	public function getPictures()
	{
		$this->getBdd();
		return $this->getAll('pictures', 'Picture');
	}
}

?>