jwplayer('mediaplayer').setup({
	'id': 'playerID',
	'width': '100%',
	'aspectratio':'9:16',
	'file': 'media/Dark_Version_Blue.mp4',
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