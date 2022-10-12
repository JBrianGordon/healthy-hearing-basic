// We should have an array called media which contains an entry for each recording to play
if (typeof media !== 'undefined') {
	media.forEach(function(recording) {
		if (typeof recording['id'] == 'undefined') {
			console.error('media id is not defined');
		}
		if (typeof recording['url'] == 'undefined') {
			console.error('media url is not defined');
		}
		$("#jquery_jplayer_"+recording['id']).jPlayer({
			ready: function () {
				$(this).jPlayer("setMedia", {
					mp3: recording['url']
				});
			},
			swfPath: "/js/jplayer",
			supplied: "mp3",
			cssSelectorAncestor: "#jp_container_"+recording['id']
		});
	});
}
