var open = false;

function openLikes(pictureId)
{
	const likeDrawer = document.getElementById("like-drawer-" + pictureId);
	open === true ? fade(likeDrawer) : unfade(likeDrawer) ;
	open = open === true ? false : true;
}

function fade(element) {
    var op = 1;
    var timer = setInterval(function () {
        if (op <= 0.1){
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, .3);
}

function unfade(element) {
    var op = 0.1;
    element.style.display = 'flex';
    var timer = setInterval(function () {
        if (op >= 1){
            clearInterval(timer);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op += op * 0.1;
    }, .3);
}