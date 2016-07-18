
onmessage = function(e){
	console.log('[worker] message received ', e.data);
	postMessage('data get ('+e.data+')'); 
}

onerror =function(e){
	console.log('error' , e);
}