<?php namespace _;

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Test Decubitus</title>
	<script>

		const debug = <?= filter_bool('debug') ? 'true' : 'false' ?>;
		var embeddedHostObj = (embeddedHostObj || null);
		
		function setHostObj() {
			
			if( isSet(embeddedHostObj) ) return;
			
			if( !isSet(window) ) return;
			if( !isSet(window.chrome) ) return;
			if( !isSet(window.chrome.webview) ) return;
			if( !isSet(window.chrome.webview.hostObjects) ) return;
			if( !isSet(window.chrome.webview.hostObjects.PDLAdmin) ) return;
			
			embeddedHostObj =  window.chrome.webview.hostObjects.PDLAdmin;

		}

		function debugHostObjs() {

			strObj('* * * * * chrome * * * * *', window.chrome);
			strObj('* * * * * webview * * * * *', window.chrome.webview);
			strObj('* * * * * hostObjects * * * * *', window.chrome.webview.hostObjects);
			strObj('* * * * * PDLAdmin * * * * *', nativeObj);

		}
		
		function isObject( m ) { return typeof m === 'object' && m !== null; }
		function isSet( m ) { return typeof m !== 'undefined' && m !== null; }
		function strObj( s, m ) { alert(s + JSON.stringify(m)); }
	</script>
	<script>

		const nativeObj = isObject(embeddedHostObj) ? embeddedHostObj : { targetPart: function(m){ alert("sent part [" + m + "] missing embeddedHostObj"); } };
		function sendPart(m) {

			//if( !!debug ) debugHostObjs(); 
			
			window.chrome.webview.hostObjects.PDLAdmin.ShowMessage(m);

			//nativeObj.targetPart(m);
		
		}

	</script>
	<style>
		html, body { width:100%; height:100%; position:relative; float:left; clear:both; box-sizing:border-box; font-size:1em; line-height:1.5em; }
		#parts, #parts > div[id]:not([id=""]) { box-sizing:border-box; position:relative; display:block; }
		#parts, #parts > div[id]:not([id=""]) { background-size:contain; background-repeat:no-repeat; }
		#parts { background-image:url('ui/kits/decubitus/body.svg'); width:93px; height:360px; float:left; clear:both; margin:0 auto; }
		#head { width:29.573%; height:11.168%; margin-left:35.438%; background-image:url('ui/kits/decubitus/head.svg'); }
		#chest { width:70.8088%; height:18.2445%; margin-left:14.6257%; margin-top:4.315%; background-image:url('ui/kits/decubitus/chest.svg'); }
		#parts > div[id]:not([id=""]) { opacity:0; cursor:pointer; }
		#parts > div[id]:not([id=""]):hover { opacity:1; }
		header,
		footer { display:block; float:left; clear:both; vertical-align:middle; line-break:none; padding:.25em; clear:both; box-sizing:border-box; margin:.25em 0; }
		input,
		button { margin:0 .25em; display:inline; }
		::placeholder { font-style:italic; color:#CCCCCC; }

	</style>
  </head>
  <body>
	<header>
    	<h3>Select the wound location</h3>
	</header>
	<div id=parts>
		<div id=head></div>
		<div id=chest></div>
	</form>
	<footer>
		
	</footer>
	<script>
		const head = document.getElementById('head'), chest = document.getElementById('chest');

		head.addEventListener('click', function() { sendPart(36); });
		chest.addEventListener('click', function() { sendPart(34); });

	</script>
  </body>
</html>
