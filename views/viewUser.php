<?php $this->_t = $user->username(); ?>
<div id="user">
	<div class="container">
		<div class="user-head">
			<div class="user-pic">
				<img src="<?= ($user->pic()) ? "../media/" . $user->pic() : 'http://via.placeholder.com/100' ?>"/>
			</div>		
			<div class="infos">
				<p class="username"><?= $user->username() ?></p>
				<div class="counters">
					<div class="counter">
						<p class="number">152</p>
						<p class="label">publications</p>
					</div>
				</div>
				<div class="bio">
					<p><?= $user->bio() ?></p>
				</div>
			</div>
		</div>
		<div class="user-posts">
			<p><i class="fas fa-th"></i> Publications</p>
			<?php foreach($pictures as $picture): ?>
			<div class="post">
				<div class="overlay">
					<div><i class="fas fa-heart"></i><p><?= count($picture->likes()) ?></p></div>
					<div><i class="fas fa-comment"></i><p><?= count($picture->comments()) ?></p></div>
				</div>
				<img class="content" src="<?= "../media/" . $picture->url() ?>"/>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>