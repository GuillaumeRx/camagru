<?php $this->_t = $user->username(); ?>
<div id="user">
	<div class="user-head">
		<img src="<?= ($user->pic()) ? $user->pic() : 'http://via.placeholder.com/100' ?>"/>
		<div class="infos">
			<p class="username"><?= $user->username() ?></p>
			<div class="counters">
				<div class="counter">
					<p class="number">152</p>
					<p class="label">publications</p>
				</div>
			</div>
			<p><?= $user->bio() ?></p>
		</div>
	</div>
	<?php foreach($pictures as $picture): ?>
	<div class="post">
		<img class="content" src="<?= $picture->url() ?>"/>
	</div>
	<?php endforeach; ?>
</div>