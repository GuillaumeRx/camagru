<div id="gallery">
<?php $this->_t = 'Accueil';
foreach($pictures as $picture): ?>
<div class="post">
	<div class="user">
		<div class="user-pic">
			<img src="<?= ($picture->account()->pic()) ? "../media/" . $picture->account()->pic() : 'http://via.placeholder.com/100' ?>"/>
		</div>
		<a href="/user/<?= $picture->account()->username() ?>"><?= $picture->account()->username() ?></a>
	</div>
	<img class="content" src="../media/<?= $picture->url() ?>"/>
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
			<?php if (++$i == 2) break; ?>
			<a href="/user/<?= $like->account()->username() ?>"><?= $like->account()->username() ?></a>
			<?php }?>
			<?php $i = 0?>
			<?= count($picture->likes()) - 1 > 0 ? "<p>&nbspet&nbsp</p>" . '<a onclick="openLikes(' . $picture->id() . ')">' . (count($picture->likes()) - 1) . "&nbspautres personnes" . '</a>' : "" ?>
		</div>
	</div>
	<div class="comments">
		<?php foreach ($picture->comments() as $comment): ?>
			<span>
				<a href="/user/<?= $comment->account()->username() ?>"><?= $comment->account()->username() ?></a>
				<p><?= $comment->content() ?></p>
			</span>
		<?php endforeach; ?>
	</div>
	<div class="comment-form">
		<form action="/accueil" method="post">
			<input type="hidden" value="<?= $picture->id() ?>" name="picture_id">
			<textarea placeholder="Ajouter un commentaire..." name="comment" id="comment-content<?= $picture->id() ?>" onkeyup="checkContent(<?= $picture->id() ?>)"></textarea>
			<button type="submit" id="comment-btn<?= $picture->id() ?>" disabled>Publier</button>
		</form>
	</div>
	
</div>
<div id="like-drawer-<?= $picture->id() ?>" class="like-drawer">
	<div class="content">
		<div class="header">
			<p>Mentions J'aime</p>
			<a onclick="openLikes(<?= $picture->id() ?>)"><i class="fas fa-times fa-2x"></i></a>
		</div>
		<div class="likes">
			<?php foreach ($picture->likes() as $key => $like):?>
			<div class="like">
				<div class="user-pic">
					<img src="<?= $like->account()->pic() ? "../media/".$like->account()->pic() : "http://via.placeholder.com/100" ?>" />
				</div>
				<a href="/user/<?= $like->account()->username() ?>"><?= $like->account()->username() ?></a>
			</div>
			<?php endforeach;?>
		</div>
	</div>
</div>
<?php endforeach; ?>
</div>