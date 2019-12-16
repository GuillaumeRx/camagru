var constraints = { video:{width: 720, height: 720}, audio: false };
var mouseDown = false;
class Filter {
	constructor(canvasWidth, canvasHeight, source) {
		this.isSelected = false;
		this.size = {height: 250, width: 250};
		this.pos = {x: (canvasWidth / 2) - (this.size.width / 2), y: (canvasHeight / 2) - (this.size.height / 2)};
		this.src = new Image();
		this.src.src = source;
	}

	moveFilter(x, y) {
		this.pos.x = x;
		this.pos.y = y;
	}

	handleSelect() {
		this.isSelected = this.isSelected == true ? false : true;
		console.log(this.isSelected);
	}

	toJSON() {
		return {
			width: this.size.width,
			height: this.size.height,
			x: this.pos.x,
			y: this.pos.y,
			src: this.src.src
		}
	}
}

var usedFilters = []; 

const	cameraView = document.querySelector('#camera-view'),
		cameraSensor = document.querySelector('#camera-sensor'),
		cameraOutput = document.querySelector('#camera-output'),
		cameraBtn = document.querySelector('#camera-btn'),
		filterScreen = document.querySelector('#filter-screen');
		filterSelector = document.querySelector('#filter-selector')
		formPicture = document.querySelector('#picture');
		formFilters = document.querySelector('#filters');
		form = document.querySelector('#send-form')

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
	if (((mousePos.x > (filter.pos.x + filter.size.width) || mousePos.x < filter.pos.x) || (mousePos.y > (filter.pos.y + filter.size.height) || mousePos.y < filter.pos.y)))
		return false;
	return true;
}

var moveFilter = (e) => {
	var rect = e.target.getBoundingClientRect();
	let select = false;
	for (i = 0; i < usedFilters.length; i++)
	{
		if (usedFilters[i].isSelected)
		{
			select = true;
		}
	}
	if (select)
	{
		for (i = 0; i < usedFilters.length; i++)
		{
			if (usedFilters[i].isSelected)
			{
				usedFilters[i].moveFilter(e.clientX - rect.left - (usedFilters[i].size.width / 2), usedFilters[i].pos.y = e.clientY - rect.top - (usedFilters[i].size.height / 2));
			}
		}
	}
	else
	{
		for (i = 0; i < usedFilters.length; i++)
		{
			if (mouseDown && isMouseOver({x: e.clientX - rect.left, y: e.clientY - rect.top}, usedFilters[i]))
			{
				usedFilters[i].handleSelect();
				usedFilters[i].moveFilter(e.clientX - rect.left - (usedFilters[i].size.width / 2), usedFilters[i].pos.y = e.clientY - rect.top - (usedFilters[i].size.height / 2));
				break;
			}
	}
	}
	let ctx = filterScreen.getContext('2d');
	ctx.clearRect(0, 0, filterScreen.width, filterScreen.height);
	for (i = 0; i < usedFilters.length; i++)
	{
		let ctx = filterScreen.getContext('2d');
		ctx.drawImage(usedFilters[i].src, usedFilters[i].pos.x, usedFilters[i].pos.y, usedFilters[i].size.width , usedFilters[i].size.height);
	}
}

function selectFilter(source)
{
	var filter = new Filter(filterScreen.width, filterScreen.height, source);
	usedFilters.push(filter);
	let ctx = filterScreen.getContext('2d');
	ctx.drawImage(filter.src, filter.pos.x, filter.pos.y, filter.size.width , filter.size.height);
	if (usedFilters.length > 0)
		cameraBtn.style.display = 'block';

}

cameraBtn.onclick = (e) => {
	cameraSensor.width = cameraView.videoWidth;
	cameraSensor.height= cameraView.videoHeight;
	cameraSensor.getContext('2d').drawImage(cameraView, 0, 0);
	formPicture.value = cameraSensor.toDataURL('image/png');
	formFilters.value = filterScreen.toDataURL('image/png');
	form.submit();

}

filterScreen.addEventListener('mousedown', (e) => {mouseDown = true});
filterScreen.addEventListener('mouseup', (e) => {
	for (i = 0; i < usedFilters.length; i++)
	{
		if (usedFilters[i].isSelected)
		{
			usedFilters[i].handleSelect();
		}
	}
	mouseDown = false});
filterScreen.addEventListener('mousemove', moveFilter, false);

window.onload = () => {
	cameraStart();
	initFilters();
}