<?php
use Cake\Core\Configure;

$width = isset($width) ? $width : '100%';
$height = isset($height) ? $height : '300px';
$lat = $location->lat;
$lon = $location->lon;
$title = $location->title;
$isMobile = $location->is_mobile;
$hideProvider = isset($hideProvider) ? $hideProvider : false;
if ($isMobile) {
	$miles = Configure::read('isMetric') ? ' km' : ' miles';
	$radius = $location->radius;
	$city = $location->city;
	$state = $location->state;
	$class = $this->App->isMobileDevice() ? 'tac mb5' : 'text-large tac mb5';
	echo "<p class='".$class."'>We serve within ".$radius." ".$miles." of ".$city.", ".$state."</p>";
}
?>
<?php if (Configure::read('env') == 'prod'): ?>
	<img id="staticMap" <?= (!$this->App->isMobileDevice() && !$hideProvider) ? 'loading="lazy" ' : null ?>width="300" height="192" alt="Clinic location map">
	<?php
	// Custom mobile icon is the short URL for https://www.healthyhearing.com/img/mobile-clinic.png
	$markers = $isMobile ? "icon:https://bit.ly/36TTEej" : "color:red";
	$infoWindowContent = "<div style='width: 300px;'><h3 class='h4 mt0 mb5'>".$title."</h3>".$this->Clinic->address($location)."</div>";
	$googleApiLink = "https://maps.googleapis.com/maps/api/js?key=".Configure::read('googleMapsApiKey')."&callback=initMap";
	?>
	<script>
		<?php if(isset($lat) && isset($lon)) : ?>
			//Create static map
			const latLon = {
					lat: <?= $lat ?>,
					lng: <?= $lon ?>
				};
			const markers = <?= '"'.$markers.'"' ?>;
			const staticMap = document.getElementById("staticMap");
			const mapSrc = `https://maps.googleapis.com/maps/api/staticmap?center=${latLon.lat},${latLon.lng}&zoom=15&size=640x410&markers=${markers}%7C${latLon.lat},${latLon.lng}&key=<?= Configure::read('googleMapsStaticApiKey') ?>`;

			staticMap.setAttribute("src", mapSrc);
			staticMap.addEventListener("click", function() {
				const apiScript = document.createElement("script");
				let mapCounter = 0;
				apiScript.src = "<?php echo $googleApiLink; ?>";
				
				//If the modal map does not currently exist on the page, add the map script. API call will only occur on the static map click event, and only if the modal map doesn't already exist.
			    if(document.querySelector("#map .gm-style") === null){
			        document.getElementsByTagName('head')[0].appendChild(apiScript);
			    }
				
				//Check for existence of map, and if it exists, open modal. If it fails for any reason, don't open
				const mapCheck = setInterval(function() {
					if(document.querySelector("#map .gm-style") !== null){
						new bootstrap.Modal(document.getElementById('mapModal')).show();
						//redraw map by changing element height
						setTimeout(function(){
			                const gmStyle = document.querySelector(".gm-style");
			                gmStyle.style.height = `${gmStyle.offsetHeight + 1}px`;
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
				const customIcon = "<?php echo $isMobile ? 'https://bit.ly/36TTEej' : ''; ?>";
				const marker = new google.maps.Marker({icon: customIcon, position: latLon, map: map, title: <?php echo json_encode($title); ?>});

				// Add the info window
				const infoWindow = new google.maps.InfoWindow({
					content: <?php echo json_encode($infoWindowContent); ?>
				});
				infoWindow.open(map, marker);
			}
		<?php endif; ?>
	</script>
<?php else: ?>
	<!-- Dev/QA map -->
	<img id="staticMap" <?php if(!$this->App->isMobileDevice() && !$hideProvider){ echo 'loading="lazy" ';} ?>style="border:1px solid LightGray; min-width:100%" alt="Clinic location map">
<?php endif; ?>
