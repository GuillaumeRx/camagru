<?php $this->_t = $user->username(); ?>
<div id="user">
	<h1><?= $user->username() ?></h1>
	<?php foreach($pictures as $picture): ?>
<div class="post">
	<img class="content" src="<?= $picture->url() ?>"/>
</div>
<?php endforeach; ?>
</div>