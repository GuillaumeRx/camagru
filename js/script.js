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

var current_page = 1;
var pagesSelector = null;

function prevPage()
{
    if (current_page > 1) {
		changePage(current_page - 1);
        current_page--;
       
    }
}

function nextPage()
{
    if (current_page < numPages()) {
		changePage(current_page + 1);
        current_page++;
        
    }
}

function changePage(page)
{
	pagesSelector = document.querySelectorAll(".page");
	console.log(pagesSelector);
	var btn_next = document.getElementById("next");
    var btn_prev = document.getElementById("prev");
    // Validate page
    if (page < 1) page = 1;
    if (page > numPages()) page = numPages();

	pagesSelector[current_page - 1].style.display = "none";
	pagesSelector[page - 1].style.display = "block";

    if (page == 1) {
        btn_prev.style.visibility = "hidden";
    } else {
        btn_prev.style.visibility = "visible";
    }

    if (page == numPages()) {
        btn_next.style.visibility = "hidden";
    } else {
        btn_next.style.visibility = "visible";
    }
}

function numPages()
{
    return (pagesSelector.length);
}

window.onload = () => {
	changePage(1);
};