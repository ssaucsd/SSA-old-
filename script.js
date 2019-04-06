const scriptURL = 'https://script.google.com/macros/s/AKfycbzQ0A_B1_Z2vrLnG4nxj3O8GnxQFlPeooVRkRoNuOaJmyleyNqj/exec'
const form = document.forms['submit-to-google-sheet']

form.addEventListener('submit', e => {
	e.preventDefault()
	fetch(scriptURL, { method: 'POST', body: new FormData(form)});
	removeInput();
});

function removeInput() {
	document.getElementById("email").value = "";
}