var constraints = { video:{width: 720, height: 720}, audio: false };
var mouseDown = false;

const	cameraView = document.querySelector('#camera-view'),
		cameraSensor = document.querySelector('#camera-sensor'),
		cameraOutput = document.querySelector('#camera-output'),
		cameraBtn = document.querySelector('#camera-btn'),
		filterScreen = document.querySelector('#filter-screen');

function cameraStart() {
	navigator.mediaDevices.getUserMedia(constraints)
	.then((stream) => {
		track = stream.getTracks()[0];
		cameraView.srcObject = stream;
	})
	.catch((err) => {
		console.error(`An error occured : ${err}`);
	})
}

function initFilters() {
	filterScreen.width = constraints.video.width;
	filterScreen.height = constraints.video.height;
}

var moveFilter = (e) => {
	if (mouseDown)
	{
		ctx = filterScreen.getContext('2d');
		var rect = e.target.getBoundingClientRect();
		ctx.clearRect(0, 0, filterScreen.width, filterScreen.height);
		ctx.fillRect((e.clientX - rect.left - 125), (e.clientY - rect.top - 125), 250, 250)
	}
}

cameraBtn.onclick = (e) => {
	cameraSensor.width = cameraView.videoWidth;
	cameraSensor.height= cameraView.videoHeight;
	cameraSensor.getContext('2d').drawImage(cameraView, 0, 0);
	console.log(cameraSensor.toDataURL('image/png'));
}

filterScreen.addEventListener('mousedown', (e) => {mouseDown = true});
filterScreen.addEventListener('mouseup', (e) => {mouseDown = false});
filterScreen.addEventListener('mouseover', moveFilter, false);
filterScreen.addEventListener('mousemove', moveFilter, false);

window.onload = () => {
	cameraStart();
	initFilters();
}