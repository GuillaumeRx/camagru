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
		console.log(content[account]);
		var user = '<div class="user"><img src="' + (content[account].pic == null ? 'http://via.placeholder.com/100' : ('../media/' + content[account].pic)) + '"/><a href="/user/' + content[account].username + '">' + content[account].username + '</a></div>';
		container.innerHTML += user;
	}
}

function searchAccount()
{
	var content = document.getElementById("search-box").value;
	var container = document.getElementById("search-results");
	var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = () => {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {   // XMLHttpRequest.DONE == 4
           if (xmlhttp.status == 200) {
			   //console.log(JSON.parse(xmlhttp.responseText));
			   sendToDom(JSON.parse(xmlhttp.responseText));
           }
           else if (xmlhttp.status == 400) {
              console.error('There was an error 400');
           }
           else {
            	console.error('something else other than 200 was returned');
           }
        }
	};
	container.innerHTML = "";
	if (content != '')
	{
    	xmlhttp.open("GET", "/search/" + content, true);
		xmlhttp.send();
	}
}