<?php
$width = isset($width) ? $width : '100%';
$height = isset($height) ? $height : '300px';
$this->Clinic->setLocation($location);
$lat = $this->Clinic->get('lat');
$lon = $this->Clinic->get('lon');
$title = $this->Clinic->get('title');
$isMobile = $this->Clinic->get('is_mobile');
$this->set('hideProvider', $hideProvider);
if ($isMobile) {
	$miles = Configure::read('isMetric') ? ' km' : ' miles';
	$radius = $this->Clinic->get('radius');
	$city = $this->Clinic->get('city');
	$state = $this->Clinic->get('state');
	$class = $this->App->isMobileDevice() ? 'tac mb5' : 'text-large tac mb5';
	echo "<p class='".$class."'>We serve within ".$radius." ".$miles." of ".$city.", ".$state."</p>";
}
?>
<?php if (Configure::read('env') == 'prod'): ?>
	<img id="staticMap" <?php if(!$this->App->isMobileDevice() && !$hideProvider){ echo 'loading="lazy" ';} ?>width="300" height="192" alt="Clinic location map">
	<?php
	// Custom mobile icon is the short URL for https://www.healthyhearing.com/img/mobile-clinic.png
	$markers = $isMobile ? "icon:https://bit.ly/36TTEej" : "color:red";
	$infoWindowContent = "<div style='width: 300px;'><h3 class='h4 mt0 mb5'>".$title."</h3>".$this->Clinic->address()."</div>";
	$googleApiLink = "https://maps.googleapis.com/maps/api/js?key=".Configure::read('googleMapsApiKey')."&callback=initMap";
	?>
	<script>
		//Create static map
		var latLon = {
				lat: <?php echo $lat; ?>,
				lng: <?php echo $lon; ?>
			};
		var markers = <?php echo '"'.$markers.'"'; ?>;
		var staticMap = document.getElementById("staticMap");
		var mapSrc = "https://maps.googleapis.com/maps/api/staticmap?center=" + latLon.lat +"," + latLon.lng + "&zoom=15&size=640x410&markers=" + markers + "%7C" + latLon.lat +"," + latLon.lng + "&key=<?php echo Configure::read('googleMapsStaticApiKey') ?>";

		staticMap.setAttribute("src", mapSrc);
		staticMap.addEventListener("click", function() {
			var apiScript = document.createElement("script");
			var mapCounter = 0;
			apiScript.src = "<?php echo $googleApiLink; ?>";
			
			//If the modal map does not currently exist on the page, add the map script. API call will only occur on the static map click event, and only if the modal map doesn't already exist.
			if($("#map .gm-style").length == 0){
				document.getElementsByTagName('head')[0].appendChild(apiScript);
			}
			
			//Check for existence of map, and if it exists, open modal. If it fails for any reason, don't open
			var mapCheck = setInterval(function() {
				if($("#map .gm-style").length > 0) {
					$("#mapModal").modal('show');
					//redraw map by changing element height
					setTimeout(function(){
						$(".gm-style").height($(".gm-style").height() + 1);
					}, 500);
					clearInterval(mapCheck);
				}
				mapCounter++;
				//Clear the interval in case the map doesn't load for any reason
				if(mapCounter >= 400){
					clearInterval(mapCheck);
				}
			}, 50);
		});
			
		// Initialize and add the map
		function initMap() {
			var map = new google.maps.Map(
				document.getElementById('map'),
				{zoom: 17, center: latLon}
			);
			// Add the marker
			var customIcon = "<?php echo $isMobile ? 'https://bit.ly/36TTEej' : ''; ?>";
			var marker = new google.maps.Marker({icon: customIcon, position: latLon, map: map, title: <?php echo json_encode($title); ?>});

			// Add the info window
			var infoWindow = new google.maps.InfoWindow({
				content: <?php echo json_encode($infoWindowContent); ?>
			});
			infoWindow.open(map, marker);
		}
	</script>
<?php else: ?>
	<!-- Dev/QA map -->
	<img id="staticMap" <?php if(!$this->App->isMobileDevice() && !$hideProvider){ echo 'loading="lazy" ';} ?>style="border:1px solid LightGray; min-width:100%" alt="Clinic location map">
<?php endif; ?>
