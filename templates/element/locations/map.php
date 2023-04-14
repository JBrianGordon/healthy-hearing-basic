<?php
use Cake\Core\Configure;	

$width = isset($width) ? $width : '100%';
$height = isset($height) ? $height : '300px';
//$this->Clinic->setLocation($location);
$lat = $location->lat;
$lon = $location->lon;
$title = $location->title;
$isMobile = $location->is_mobile;
//*** TODO: add hideProvider when provider is pulled in to clinic view and clinic admin edit pages ***
//$this->set('hideProvider', $hideProvider);
if ($isMobile) {
	$miles = Configure::read('isMetric') ? ' km' : ' miles';
	$radius = $location->radius;
	$city = $location->city;
	$state = $location->state;
	$class = $this->App->isMobileDevice() ? 'tac mb5' : 'text-large tac mb5';
	echo $this->Html->tag('p', "We serve within {$radius} {$miles} of {$city}, {$state}", ['class' => $class]);
}
?>
<!-- *** TODO: change this back to == 'prod' once all testing is done ***-->
<?php if (Configure::read('env') != 'prod'): ?>
	<!--*** TODO: add hideProvider when provider is pulled in to clinic view and clinic admin edit pages ***-->
	<img id="staticMap" <?php if(true/*!$this->App->isMobileDevice() && !$hideProvider*/){ echo 'loading="lazy" ';} ?>width="300" height="192" alt="Clinic location map">
	<?php
	// Custom mobile icon is the short URL for https://www.healthyhearing.com/img/mobile-clinic.png
	$markers = $isMobile ? "icon:https://bit.ly/36TTEej" : "color:red";
	/*** TODO: address function needs to be built ***/
	$infoWindowContent = "<div style='width: 300px;'><h3 class='h4 mt0 mb5'>".$title."</h3>"./*$this->Clinic->address().*/"</div>";
	$googleApiLink = "https://maps.googleapis.com/maps/api/js?key=".Configure::read('googleMapsApiKey')."&callback=initMap";
	?>
	<script>
		//Create static map
		const latLon = {
				lat: <?= $lat; ?>,
				lng: <?= $lon; ?>
			};
		const markers = <?= '"'.$markers.'"'; ?>;
		const staticMap = document.getElementById("staticMap");
		const mapSrc = "https://maps.googleapis.com/maps/api/staticmap?center=" + latLon.lat +"," + latLon.lng + "&zoom=15&size=640x410&markers=" + markers + "%7C" + latLon.lat +"," + latLon.lng + "&key=<?php echo Configure::read('googleMapsStaticApiKey') ?>";

		staticMap.setAttribute("src", mapSrc);
		staticMap.addEventListener("click", () => {
			const apiScript = document.createElement("script");
			let mapCounter = 0;
			apiScript.src = "<?= $googleApiLink ?>";
			
			//If the modal map does not currently exist on the page, add the map script. API call will only occur on the static map click event, and only if the modal map doesn't already exist.
			if($("#map .gm-style").length == 0){
				document.getElementsByTagName('head')[0].appendChild(apiScript);
			}
			
			//Check for existence of map, and if it exists, open modal. If it fails for any reason, don't open
			const mapCheck = setInterval(() => {
				if($("#map .gm-style").length > 0) {
					$("#mapModal").modal('show');
					//redraw map by changing element height
					setTimeout(() => {
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
			const map = new google.maps.Map(
				document.getElementById('map'),
				{zoom: 17, center: latLon}
			);
			// Add the marker
			const customIcon = "<?= $isMobile ? 'https://bit.ly/36TTEej' : ''; ?>";
			const marker = new google.maps.Marker({icon: customIcon, position: latLon, map: map, title: <?= json_encode($title) ?>});

			// Add the info window
			const infoWindow = new google.maps.InfoWindow({
				content: <?= json_encode($infoWindowContent) ?>
			});
			infoWindow.open(map, marker);
		}
	</script>
<?php else: ?>
	<!-- Dev/QA map -->
	<img id="staticMap" <?php if(true/*!$this->App->isMobileDevice() && !$hideProvider*/){ echo 'loading="lazy" ';} ?>style="border:1px solid LightGray; min-width:100%" alt="Clinic location map">
<?php endif; ?>
