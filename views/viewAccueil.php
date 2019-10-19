<div id="gallery">
<?php $this->_t = 'Accueil';
foreach($pictures as $picture): ?>
<div class="post">
	<div class="user">
		<img src="http://via.placeholder.com/100" />
		<p><?= $picture->username() ?></p>
	</div>
	<img class="content" src="<?= $picture->url() ?>"/>
	<div class="bottom">	
		<div class="likes">
			<i class="far fa-heart fa-lg"></i>
		</div>
		<div>
		</div>
	</div>
</div>
<?php endforeach; ?>
</div>