function copyToClipboard(element, e) {
	console.log(e, "elment");
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val($(element).text()).select();
	document.execCommand("copy");
	$temp.remove();
	if (typeof e  !== "undefined")
	e.innerText = 'Copied';
}