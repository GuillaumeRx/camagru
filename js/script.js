var open = false;

function checkContent(pictureId)
{
    button = document.getElementById("comment-btn" + pictureId);
    commentBox = document.getElementById("comment-content" + pictureId);
    (commentBox.value == '') ? button.disabled = true : button.disabled = false;
}

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

function sendToDom(content)
{
	var container = document.getElementById("search-results");

	for (var account in content)
	{
		var user = '<div class="user"><div class="user-pic"><img src="' + (content[account].pic == null ? 'http://via.placeholder.com/100' : ('../media/' + content[account].pic)) + '"/></div><a href="/user/' + content[account].username + '">' + content[account].username + '</a></div>';
		container.innerHTML += user;
	}
}

function searchAccount()
{
	var content = document.getElementById("search-box").value;
	var container = document.getElementById("search-results");
	var corner = document.getElementById("corner");
	var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
           if (xmlhttp.status == 200) {
			   sendToDom(JSON.parse(xmlhttp.responseText));
           }
        }
	};
	container.innerHTML = '';
	if (content != '')
	{
		container.style.display = 'flex';
		corner.style.display = 'block';
    	xmlhttp.open("GET", "/search/" + content, true);
		xmlhttp.send();
	}
	else
	{
		container.style.display = 'none';
		corner.style.display = 'none';
	}
}