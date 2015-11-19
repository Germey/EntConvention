jwplayer('mediaplayer').setup({
	flashplayer: 'media/jwplayer.flash.swf',
	id: 'playerID',
	width: '100%',
	aspectratio:'9:16',
	image: 'images/player.png',
	file: 'media/Dark_Version_Blue.mp4',
	//autostart: 'true',
	events: {
		onComplete: function() { 
			window.location.href="http://mf23.cn/wx/php/main.php";
		},
		onPause: function() {
			$(".to-index").slideDown();
			setTimeout(function(){
				$(".to-index").slideUp();
			}, 5000);
		},
		onPlay: function() {
			$(".to-index").slideUp();
		}
	}
});