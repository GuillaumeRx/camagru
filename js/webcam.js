var constraints = { video:{width: 720, height: 720}, audio: false };
var mouseDown = false;
const filters = [
	{
		size: {height: 250, width: 250},
		pos: {x: null, y: null},
		src: new Image()
	}
];
const usedFilters = []; 

filters[0].src.src = '/media/face.svg'

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

function isMouseOver(mousePos, filter)
{
	if (filter.pos.x && filter.pos.y && ((mousePos.x > (filter.pos.x + filter.size.width) || mousePos.x < filter.pos.x) || (mousePos.y > (filter.pos.y + filter.size.height) || mousePos.y < filter.pos.y)))
		return false;
	return true;
}

var moveFilter = (e) => {
	var rect = e.target.getBoundingClientRect();
	for (var filter of usedFilters)
	{
		if (mouseDown && isMouseOver({x: e.clientX - rect.left, y: e.clientY - rect.top}, filter))
		{
		ctx = filterScreen.getContext('2d');
		ctx.clearRect(filter.pos.x, filter.pos.y, filter.size.width, filter.size.height);
		ctx.drawImage(filter.src, (e.clientX - rect.left - filter.size.width / 2), (e.clientY - rect.top - filter.size.height / 2), filter.size.width , filter.size.height)
		filter.pos.x = e.clientX - rect.left - (filter.size.width / 2);
		filter.pos.y = e.clientY - rect.top - (filter.size.height / 2);
		}
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
	usedFilters.push(filters[0]);
}