// you cannot console.log any thing here
onconnect = function(e){
	
	var port = e.ports[0];
	port.postMessage('new worker connected on port : ' + name);
}

onerror =function(e){
	console.log('error' , e);
}