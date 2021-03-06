var RELOAD_RATE = 25;

function eraseYear() {
	var monthTitle = document.getElementsByClassName("date-top")[0];
	var dateNavButtons = 
		document.getElementsByClassName("nav-table")[0];
	var monthTitleText = monthTitle.innerHTML;

	monthTitle.innerHTML = monthTitleText.replace(/[0-9]/g, '');
	dateNavButtons.style.visibility = "visible";
}

function eraseMonthName() {
	var days = document.getElementsByClassName("st-dtitle");
	var found = false;

	for (var i = 0; i < days.length; i++) {
		var day = days[i];
		
		if(!found && !day.classList.contains("st-dtitle-nonmonth")) {
			day.firstElementChild.innerHTML = "1";
			found = true;
		}

		day.style.visibility = "visible";
	}
}

function replaceEventsWithDots() {
	var grids = document.getElementsByClassName("st-grid");
	var events = document.getElementsByClassName("te");

	for (var i = 0; i < grids.length; i++) {
		var dates = 
			grids[i].getElementsByTagName("tr")[0].getElementsByTagName("td");
		var firstEvents = 
			grids[i].getElementsByTagName("tr")[1].getElementsByTagName("td");

		for (j = 0; j < firstEvents.length; j++) {
			var event = firstEvents[j].getElementsByClassName("te");

			if (event.length > 0) {
				event[0].innerHTML = "&#8226;";

				if (!dates[j].classList.contains("st-dtitle-nonmonth")) {
					event[0].style.display = "block";
				}
			}
		}
	}
}

function repeat() {
	var f = setInterval(function() {
		replaceEventsWithDots();
		eraseMonthName();
		eraseYear();

		if (document.getElementsByClassName("loading")[0].style.display == 
			"none") {
			clearInterval(f);
		}
	}, RELOAD_RATE);
}

window.onload = function() {
	var navBackButton = document.getElementsByClassName("navBack")[0];
	var navForwardButton = document.getElementsByClassName("navForward")[0];
	var dateNavButtons =
		document.getElementsByClassName("nav-table")[0];

	navBackButton.onclick = function() {
		dateNavButtons.style.visibility = "hidden";
		repeat();
	};
	navForwardButton.onclick = function() {
		dateNavButtons.style.visibility = "hidden";
		repeat();
	};

	repeat();

	document.getElementsByClassName("loading")[0].style.visibility = "hidden";
};

window.onresize = repeat;
