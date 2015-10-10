/*
	Opens a new window to preview markdown-parsed text.
	Defaults to preview the item with id="text"
*/
function preview() {
	var win = window.open(root + "/admin/preview", "förhandsgranska", "width=1100,height=600,status=0,scrollbars=1,toolbar=0,titlebar=0");
	win.document.open();

	win.document.write('<form method="post" action="' + root + '/admin/preview" id="preview_form">');
	win.document.write('<textarea name="text">' + document.getElementById("text").value + '</textarea>');
	win.document.write('<input type="submit">');
	win.document.write('</form');

	win.document.getElementById("preview_form").submit();
	win.document.close();
}
