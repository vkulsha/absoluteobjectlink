"use strict";

function cDom(dom, parentDom) {
	return parentDom ? parentDom.appendChild(document.createElement(dom)) : document.createElement(dom);
}

function post(url, params, callback) {
	var req = null;
	if (window.XMLHttpRequest) {
		try {
			req = new XMLHttpRequest();
		} catch (e){}
	} else if (window.ActiveXObject) {
		try {
			req = new ActiveXObject('Msxml2.XMLHTTP');
		} catch (e){
			try {
				req = new ActiveXObject('Microsoft.XMLHTTP');
			} catch (e){}
		}
	}

	if (req) {
		req.open("POST", url, true);
		req.onreadystatechange = function(){
			try {
			if (req.readyState == 4) {
				if (req.status == 200) {
					callback(req.response);
				} else {
					console.log("Не удалось получить данные:\n"+req.statusText);
				}
			}
			} catch( e ) {
			}							
		};
		req.send(params);
	}
}		

function gOrm(f, p, callback) {
	var formData = new FormData();
	formData.append("f", f);
	formData.append("p", JSON.stringify(p));
	post('/server/orm.php', formData, callback);
}		
