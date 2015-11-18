jwplayer('mediaplayer').setup({
	'id': 'playerID',
	'width': '100%',
	'aspectratio':'9:16',
	'file': '../media/Dark_Version_Blue_13.mp4',
	events: {
		onComplete: function() { 
			window.location.href = "http://mf23.cn/main.php";
		},
		onPause: function() {
			
		}
	}
});