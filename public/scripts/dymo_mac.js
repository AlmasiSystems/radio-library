function labelScript(albumID, artist, title, genre, date)
{
	win = window.open("","Print", "width=320,height=210,scrollbars=no", albumID, artist, title, genre, date); 
	win.document.writeln("<html><body><title>"+albumID+'</title><h2><p>'+artist+'</p></h2>"'+title+'"<p>'+genre+"</p><p>"+date+"</p></body></html>");
	window.location = "dymoprint://com.apple.AppleScript.DymoPrint?action=1"
}