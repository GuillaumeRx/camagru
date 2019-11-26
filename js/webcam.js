window.onload = startup();

var width = 320;
var height = 0;
var streaming = false;
var video = null;
var canvas = null;
var photo = null;
var startbutton = null;

function startup() {
	video = document.getElementById('video');
	canvas = document.getElementById('canvas');
	photo = document.getElementById('photo');
	startbutton = document.getElementById('startbutton');

	navigator.mediaDevices.getUserMedia({video: true, audio: false})
	.then((stream) => {
		video.srcObject = stream;
		video.play();
	}).catch((err) => {
		console.log(err);
	});

	video.addEventListener('canplay', (e) => {
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth / width);
			video.setAttribute('width', width);
        	video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
	}, false);

	startbutton.addEventListener('click', (e) => {
		takePicture();
		e.preventDefault();
	}, false);

	clearPhoto();
}

function clearPhoto() {
	var context = canvas.getContext('2d');
	context.fillStyle = 'AAA';
	context.fillRect(0, 0, canvas.width, canvas.height);

	var data = canvas.toDataURL('image/png');
	photo.setAttribute('src', data);
}

function takePicture() {
	var context = canvas.getContext('2d');
	if (width && height) {
		canvas.width = width;
		canvas.height = height;
		context.drawImage(video, 0, 0, width, height);

		var data = canvas.toDataURL('image/png');
		photo.setAttribute('src', data);
	} else {
		clearPhoto();
	}
}
