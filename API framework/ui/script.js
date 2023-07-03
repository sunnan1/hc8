const _ = { ready:[], intervals:[], win:{} };

function e( s ) { return document.getElementById( s ); }
function ready( cb, onClose ) { _.ready.push(cb); }
function doReady(){ _.ready.map(function(cb){ cb(); }); _.ready = []; }

function cleanUp() {

	_.intervals.map(clearInterval);
	_.intervals = [];

}

function _setInterval() {

	var ID = window.setInterval.apply(window, arguments);
	_.intervals.push(ID);

	return ID;

}
