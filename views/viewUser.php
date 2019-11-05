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
		<!-- <?php foreach($pictures as $picture): ?>
		<div class="post">
			<img class="content" src="<?= "../" . $picture->url() ?>"/>
		</div>
		<?php endforeach; ?> -->
	</div>
</div>