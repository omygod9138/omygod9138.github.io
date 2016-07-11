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
   
	this.Notify = function(){
		//define options
		var defaults = {
			title : 'New message', //title of notification
			body  : 'message input here', // message to be shown
			icon  : 'picture path', // icon of notification
			close : 3000//time delay to close notification after msg
		}
		//combine options with default options if any
		if (arguments[0] && typeof arguments[0] === "object") {
		  this.options = extendDefaults(defaults, arguments[0]);
		  
		}else{
		  this.options = defaults;
		}
		this.options.perm = initializeEvents.call(undefined, this);
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
			setTimeout(n.close.bind(n), this.options.close);//set timeout to close notification
			
		}
	 
	}
	// Private Methods
	function initializeEvents(e){
	
		// check if have permission for notification, if not, ask for it
		if (window.Notification && Notification.permission !== "granted") {
			Notification.requestPermission(function (status) {
				if (Notification.permission !== status) {
					Notification.permission = status;
				}
			});
		}

		// If the user agreed to get notified, send a 'permission granted' notification msg
		if (window.Notification && Notification.permission === "granted") {
			//custom the message you want to send
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

			// If permission granted
			if (status === "granted") {
				e.options.perm = true;
				e.send({'body': 'permission granted', 'icon': e.options.icon, 'tag': 'once'});
				return true;
			}

			// Otherwise, we can fallback to a regular modal alert
			else {
			  console.log('permission not granted, fallback to a regular modal alert');
			  return false;
			}
		  });
		}

		// If permission not granted
		else {
		 
		  console.log('permission not granted, fallback to a regular modal alert');
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
