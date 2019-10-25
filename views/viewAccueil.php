<div id="gallery">
<?php $this->_t = 'Accueil';
foreach($pictures as $picture): ?>
<div class="post">
	<div class="user">
		<img src="http://via.placeholder.com/100" />
		<a href="/user/<?= $picture->username() ?>"><?= $picture->username() ?></a>
	</div>
	<img class="content" src="<?= $picture->url() ?>"/>
	<div class="bottom">	
		<div class="likes">
		<form method="POST" action="/accueil" >
			<input type="hidden" value="<?= $picture->id() ?>" name="picture_id">
			<button type="submit"><i class="far fa-heart fa-lg"></i></button>
		</form>	
		</div>
		<div class="likes-cont">
			<p>Aimé par&nbsp</p> 
			<?php foreach ($picture->likes() as $key => $like) { ?>
			<a><?= $like->username() ?></a>
			<p>,&nbsp</p>
			<?php }?>
			<!-- <a><?= count($picture->likes()) - 1 > 0 ? " et" . count($picture->likes()) . " personnes" : "" ?> </a></a> -->
		</div>
	</div>
</div>
<?php endforeach; ?>
</div>