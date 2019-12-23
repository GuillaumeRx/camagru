var current_page = 1;
var pagesSelector = null;
var num = null;
var num2 = null;

function prevPage()
{
    if (current_page > 1) {
		changePage(current_page - 1);
        current_page--;
       
	}
	else
	{
		changePage(numPages());
		current_page = numPages();
	}
}

function nextPage()
{
    if (current_page < numPages()) {
		changePage(current_page + 1);
        current_page++;
        
	}
	else
	{
		changePage(1);
		current_page = 1;
	}
}

function changePage(page)
{
	pagesSelector = document.querySelectorAll(".page");
	num = document.getElementById("page-num");
	num2 = document.getElementById("page-num2");
	if (pagesSelector.length > 0)
	{
		if (page < 1) page = 1;
		if (page > numPages()) page = numPages();

		pagesSelector[current_page - 1].style.display = "none";
		pagesSelector[page - 1].style.display = "block";
		num.innerHTML = page;
		num2.innerHTML = page;
	}
	else
	{
		num.innerHTML = "0";
		num2.innerHTML = "0";
	}
}

function numPages()
{
    return (pagesSelector.length);
}

window.onload = () => {
	changePage(1);
};