
function enableInteractiveMap(mapName) {
	var element = document.getElementById(mapName + 'Map');

	// Verify this map exists on this page.
	if (!element) {
		return false;
	}

	if (element.getSVGDocument() == null) {
		setTimeout(function() { enableInteractiveMap(mapName); }, 500);
		return false;
	}

	var svgDoc 	= element.contentDocument;
	var svgRoot = svgDoc.documentElement;

	// Prevent the Map from being initialized twice.
	if ($(element).attr('data-enabled') == '1') {
		return false;
	}
	$(element).attr('data-enabled', '1');

	// Mouseover CSS
	$('g.Canada g', svgRoot).mouseover(function() {
		$(this).css('fill', '#78afc9').css('cursor', 'pointer');
	});
	$('g.Canada g', svgRoot).mouseout(function() {
		$(this).css('fill', '#d3d3d3');
	});

	// Click Events
	$('g.Canada g', svgRoot).click(function() {
		province = $(this).attr('province');
		window.location = '/hearing-aids/' + province;
	});	
}

window.onload = function() {
	enableInteractiveMap('interactive');
	enableInteractiveMap('header');
}

// Back-button/forward cache fix for Safari
$(window).on('pageshow', function(event) { 
	if (event.originalEvent.persisted) {
		// reset 'data-enabled' for any cached maps
		$("object[data-enabled='1']").each(function() {
			$(this).attr('data-enabled', '0');
		});
		// hide modal map if it's open
		if ($('#enlargeMap').is(':visible')) {
			$('#enlargeMap').modal('hide');
		}
		// wait for resources to load
		setTimeout(function(){
			enableInteractiveMap('interactive');
			enableInteractiveMap('header');
		}, 700);
	}	
});

// Enable modal map when shown
$('#enlargeMap').on('shown.bs.modal', function() {
	enableInteractiveMap('big');
});
// Reset 'data-enabled' after closing modal map
$('#enlargeMap').on('hidden.bs.modal', function() {
	$('#bigMap').attr('data-enabled', '0');
});
