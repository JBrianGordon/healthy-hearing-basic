import $ from 'jquery';

interface MediaRecording {
	id: string | number;
	url: string;
}

// Extend Window interface to include the media array
declare global {
	interface Window {
		media?: MediaRecording[];
	}
}

// We should have an array called media which contains an entry for each recording to play
if (typeof window.media !== 'undefined') {
	window.media.forEach(function (recording: MediaRecording) {
		if (typeof recording.id === 'undefined') {
			console.error('media id is not defined');
			return;
		}
		if (typeof recording.url === 'undefined') {
			console.error('media url is not defined');
			return;
		}

		($(`#jquery_jplayer_${recording.id}`) as any).jPlayer({
			ready: function (this: HTMLElement) {
				($(this) as any).jPlayer("setMedia", {
					mp3: recording.url
				});
			},
			swfPath: "/js/jplayer",
			supplied: "mp3",
			cssSelectorAncestor: `#jp_container_${recording.id}`
		});
	});
}