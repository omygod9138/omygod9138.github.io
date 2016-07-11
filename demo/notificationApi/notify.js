/*
*
*  Notify.js
*  Copyright 2016 John Auw. All rights reserved.
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*      https://www.apache.org/licenses/LICENSE-2.0
*
*  Unless required by applicable law or agreed to in writing, software
*  distributed under the License is distributed on an "AS IS" BASIS,
*  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*  See the License for the specific language governing permissions and
*  limitations under the License
*
*/

// Version 0.1
(function() {
    var privateVar = "You can't access me in the console"
	// Define our constructor
	
	this.Notify = function(){
		//define options
		var defaults = {
			title : 'Title', //title of notification
			body  : 'message input here', // message to be shown
			icon  : 'picture path', // icon of notification
			perm  : initializeEvents.call(this)
		}
		
		// Create options by extending defaults with the passed in arugments
		if (arguments[0] && typeof arguments[0] === "object") {
		  this.options = extendDefaults(defaults, arguments[0]);
		  this.options.perm = initializeEvents.call(this);
		}else{
		  this.options = defaults;
		}
		console.log('construct', this);
	}
	// Public Methods
	Notify.prototype.send = function(){
		
		var msg = arguments[0];
		msg.icon = 'img/icon.png';
		if(this.options.perm){
			console.log('open', msg);
			var options = {
				body : msg.body,
				icon : msg.icon,
				tag  : msg.tag
			}
			
			var n = new Notification(msg.title, options);
			
		}
	 
	}
	// Private Methods
	function initializeEvents(){
		console.log('init...', this);
		
		// At first, let's check if we have permission for notification
		// If not, let's ask for it
		if (window.Notification && Notification.permission !== "granted") {
			Notification.requestPermission(function (status) {
				if (Notification.permission !== status) {
					Notification.permission = status;
				}
			});
		}

		// If the user agreed to get notified
		// Let's try to send ten notifications
		if (window.Notification && Notification.permission === "granted") {
			console.log('granted');
			return true;
		}

		// If the user hasn't told if he wants to be notified or not
		// Note: because of Chrome, we are not sure the permission property
		// is set, therefore it's unsafe to check for the "default" value.
		else if (window.Notification && Notification.permission !== "denied") {
		  Notification.requestPermission(function (status) {
			if (Notification.permission !== status) {
				Notification.permission = status;
			}

			// If the user said okay
			if (status === "granted") {
				console.log('granted');
				return true;
			}

			// Otherwise, we can fallback to a regular modal alert
			else {
			  alert("Hi!");
			  return false;
			}
		  });
		}

		// If the user refuses to get notified
		else {
		  // We can fallback to a regular modal alert
		  alert("Hi!");
		  return false;
		}
 
		
	}
	// Utility method to extend defaults with user options
	function extendDefaults(source, properties) {
		var property;
		for (property in properties) {
			if (properties.hasOwnProperty(property)) {
				source[property] = properties[property];
			}
		}
		return source;
	}
}());
