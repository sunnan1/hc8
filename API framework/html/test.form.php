<?php namespace _;

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Test form</title>
	<script>

		const frm = { rows:{ count:0, elements: [], container: null }, row: { html: '', indexed: '' } };

		frm.rows.container = document.getElementById('rows');

		frm.row.html += '<input type=text name="row[index][note][]" placeholder="row note" required>';
		frm.row.html += '<input type=checkbox name="row[index][days][]" value=monday checked>';
		frm.row.html += '<input type=checkbox name="row[index][days][]" value=tuesday checked>';
		frm.row.html += '<input type=checkbox name="row[index][days][]" value=wednesday checked>';
		frm.row.html += '<input type=checkbox name="row[index][days][]" value=thursday checked>';
		frm.row.html += '<input type=checkbox name="row[index][days][]" value=friday checked>';
		frm.row.html += '<input type=checkbox name="row[index][days][]" value=saturday>';
		frm.row.html += '<input type=checkbox name="row[index][days][]" value=sunday>';

		function newRow() {
			
			var rowIndex		= frm.rows.count++;
			frm.row.indexed		= frm.row.html.replaceAll('row[index]', 'row[' + rowIndex + ']');
			frm.rows.container.insertAdjacentHTML('beforeend', '<div id=row_' + rowIndex + '>' + frm.row.indexed + '</div>');

		}
	</script>

    <!--<link rel="stylesheet" type="text/css" href="./style.css" />-->
    <!--<script type="module" src="./index.js"></script>-->
	<style>
		html, body { width:100%; height:100%; min-width:1080px; min-height:720px; position:relative; float:left; clear:both; box-sizing:border-box; font-size:1em; line-height:1.5em; }
		form { margin:1.5em 0; float:left: clear:both; box-sizing:border-box; position:relative; display:block; height:auto; min-height:1em; width:100%; }
		#rows { width:100%; height:100%; float:left; clear:both; box-sizing:border-box; padding:.5em; display:block; border:2px inset; background-color:#EBEBEB; position:relative; display:block; height:auto; min-height:1em; width:100%; }
		#rows > [id$=row] { background-color:#FAFAFA; border-radius:.15em; border:1px solid #CCCCCC; margin:.1em 0; box-sizing:border-box; }
		
		#rows > [id$=row],
		header,
		footer { display:inline-block; vertical-align:middle; line-break:none; max-height:2em; padding:.25em; clear:both; box-sizing:border-box; margin:.25em 0; }
		input,
		button { margin:0 .25em; display:inline; }
		::placeholder { font-style:italic; color:#CCCCCC; }

	</style>
  </head>
  <body>
	<header>
    	<h3>Test Form</h3>
	</header>
	<form id=testform>
		<div id=rows>

		</div>
	</form>
	<footer>
		<button type=button name=addrow onclick="newRow()">Add Row</button>
		<button type=submit name=action value=submit form=testform>Submit</button>
		<br><br><br>
		<button type=button name=callme onclick="sendMessage()">Push Message to Admin App</button>
	</footer>
	<script>
		frm.rows.container = document.getElementById('rows');
	
	
    function sendMessage() {
        window.chrome.webview.postMessage('Hello .NET from JavaScript');
    }
    
    //window.chrome.webview.postMessage('page.ready');
    
	
	function showMessage() {

        var text =  "Message Returned from Server in Webview";

        return text;
    }
	
	</script>
	
	
  </body>
  
</html>
