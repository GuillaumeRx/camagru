<?php $this->_t = 'Montage'; ?>
<div id="camagru">
	<canvas id="camera-sensor"></canvas>
	<div class="camera">
		<canvas id="filter-screen"></canvas>
    	<video id="camera-view" autoplay playsinline></video>
		<button id="camera-btn">Take a picture</button>
	</div>
	<canvas id="filter-selector"></canvas>
    <script src="/js/webcam.js"></script>
</div>