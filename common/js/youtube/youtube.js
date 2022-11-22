/* 유튜브 */
var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var player;	
function onYouTubeIframeAPIReady() {
}
function onPlayerReady(event) {
	event.target.playVideo();
}
function onPlayerStateChange(event) {
}
function stopVideo() {
	player.stopVideo();
}
function closePlayer(){
	$("#playerWrap").html("<div id='player'></div>")
	$("#playerview").hide();
	$("body").css("overflow","auto");
}
function playerview(id,type){
	$("#playerview").show();
	$("body").css("overflow","hidden");
	if(type=="Y"){
		player = new YT.Player('player', {
			height: 450,
			width: 800,
			videoId: id,
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange
			}
		});	
	}
}

