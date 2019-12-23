<div id="gallery">
<div class="buttons">
	<button id="prev" onclick="prevPage()"><i class="fas fa-chevron-left fa-lg"></i></button>
	<p id="page-num"></p>
	<button id="next" onclick="nextPage()"><i class="fas fa-chevron-right fa-lg"></i></button>
</div>
<?php $this->_t = 'Accueil';
$j = 0;
if (count($pictures) == 0)
	echo("<p>Il n'y a pas de photos pour le moment</p>");
foreach($pictures as $picture) {
	if (++$j == 1)
		echo("<div class='page'>");
?>
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
			<input type="hidden" value="<?= $picture->accountId() ?>" name="account_id">
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
<?php 
	if($j == 5)
	{
		echo("</div>");
		$j = 0;
	}
}
if ($j != 0)
	echo("</div>");	
?>
<div class="buttons">
	<button id="prev" onclick="prevPage()"><i class="fas fa-chevron-left fa-lg"></i></button>
	<p id="page-num2"></p>
	<button id="next" onclick="nextPage()"><i class="fas fa-chevron-right fa-lg"></i></button>
</div>
<script src="/js/paginate.js"></script>
</div>