<?php $this->_t = 'Montage'; ?>
<div id="camagru">
	<div class="camera-box">
		<div class="box" id="sensor">
			<div class="camera">
				<canvas id="filter-screen"></canvas>
				<canvas id="camera-sensor"></canvas>
				<video id="camera-view" autoplay playsinline></video>
				<button id="camera-btn">PHOTO</button>
			</div>
			<div class="import-pic">
				<label class="img-select" for="img-select" >Importer ma photo</label>	
				<input type="file" id="img-select" name="img-select" />
			</div>
			<button onclick="clearFilters()">Effacer les filtres</button>
		</div>
		<div class="box" id="filters-cont">
			<div id="filter-selector">
				<img src="/filters/filtre-1.png" onclick="selectFilter('/filters/filtre-1.png')"/>
				<img src="/filters/filtre-2.png" onclick="selectFilter('/filters/filtre-2.png')"/>
				<img src="/filters/filtre-3.png" onclick="selectFilter('/filters/filtre-3.png')"/>
			</div>
			<form method="POST" action="/camagru" id="send-form">
				<input type="hidden" id="picture" name="picture" />
				<input type="hidden" id="filters" name="filters" />
			</form>
			<script src="/js/webcam.js"></script>
		</div>
	</div>
		<div class="box" id="user-pic">
		<?php foreach($pictures as $picture): ?>
			<div class="picture">
				<img src="/media/<?= $picture->url() ?>" alt="<?= $picture->url() ?>">
				<form method="POST" action="/camagru">
					<input name="delete" type="hidden" value="<?= $picture->id() ?>" />
					<button type="submit" ><i class="fas fa-trash fa-lg"></i></button>
				</form>
			</div>
		<?php endforeach ; ?>
	</div>
</div>