var sessionFinalMinutes = 5;
var sessionStart = new Date().getTime();
var sessionEnd = sessionStart + (1000*60*sessionFinalMinutes);
function inicializaSessionTime(){
	sessionStart = new Date().getTime();
}
function countDown(){
	timeRemain = (1000*60*sessionFinalMinutes) - (new Date().getTime() - sessionStart);
	minutes = timeRemain/(1000*60);
	seconds =((minutes - Math.floor(minutes)))*60;
	finalSeconds = (Math.floor(seconds)).toString();
	if(finalSeconds.length == '1'){
		finalSeconds = "0"+finalSeconds;
	}
	$("#sessionTimeExpiration").text(Math.floor(minutes) + ":" + finalSeconds);
		if((Math.floor(minutes) <= 0) && (Math.floor(seconds) <= 0 ) ){
			window.location = '/login';
		}
		setTimeout(countDown,1000);
}

navHover = function() {
	if($("#navmen")){
		var lis = $("#navmenu").find('li');//getElementsByTagName("LI");
		for (var i=0; i<lis.length; i++) {
			lis[i].onmouseover=function() {
				this.className+=" iehover";
			}
			lis[i].onmouseout=function() {
				this.className=this.className.replace(new RegExp(" iehover\\b"), "");
			}
		}		
	}
}
