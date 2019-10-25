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
			
			<button type="submit"><i class="<?= $picture->liked() ? " liked fas" : "far"?> fa-heart fa-lg"></i></button>
		</form>	
		</div>
		<div class="likes-cont">
			<p>Aimé par&nbsp</p> 
			<?php foreach ($picture->likes() as $key => $like) { ?>
			<?php if (++$i == 3) break; ?>
			<a href="/user/<?= $like->username() ?>"><?= ($i == 1) ? $like->username() : ", ". $like->username() ?></a>
			<?php }?>
			<?php $i = 0?>
			<a><?= count($picture->likes()) - 2 > 0 ? "&nbspet&nbsp" . (count($picture->likes()) - 2) . "&nbspautres personnes" : "" ?> </a>
		</div>
	</div>
</div>
<?php endforeach; ?>
</div>