<?php namespace _;

static $APIKEY = 'AIzaSyCwkg3ojHxMt6fleyjG3Be9x3JWJlJwBfQ';

$version		= filter_int('ie') ? '' : '&v=3.47';

$patients		= io::getData('patients');

?>
<!DOCTYPE html>
<html>
  <head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Add Map</title>
    <script>
	function initMap() {

		setTimeout(function(){
			
			let mapOpts = {
				// center: { lat: 46.1080207, lng: -60.2318273 },
				center: { lat: 48.739299010992404, lng: 9.300438336081513 },
				zoom: 12
			}
				
			let patients = {};
			let markerOpts = {};

			let map = new google.maps.Map(document.getElementById("map"), mapOpts);

			<?php foreach( $patients as $patient ) :

			extract($patient);

			?>
			patients['<?= $id ?>']	= {
				id: <?= $id ?>,
				first_name: "<?= $first_name ?>",
				last_name: "<?= $last_name ?>",
				gender: "<?= $gender ?>",
				dob: <?= $dob ?>,
				key_number: "<?= $key_number ?>",
				phone: "<?= $phone ?>",
				gp_contact_id: <?= $gp_contact_id ?>,
				emergency_contact_id: <?= $emergency_contact_id ?>,
				insurance: "<?= $insurance ?>",
				address: "<?= $address ?>",
				primary_care_giver_id: <?= $primary_care_giver_id ?>,
				city: "<?= $city ?>",
				country: "<?= $country ?>",
				post_code: "<?= $post_code ?>",
				lat: <?= $lat ?>,
				long: <?= $long ?>,
				status: "<?= $status ?>",
				allergies: "<?= $allergies ?>",
				risks: "<?= $risks ?>",
				infections: "<?= $infections ?>",
				modified: <?= $modified ?>,
				previous_visit: "<?= $previous_visit ?>",
				medications: "<?= $medications ?>"
			};

			patients['<?= $id ?>'].image		= {
				//url: "https:/homecare.amnexis.dev/ui/kits/maps/patientPin.png",
				// This marker is 20 pixels wide by 32 pixels high.
				//size: new google.maps.Size(20, 24),
				// The origin for this image is (0, 0).
				//origin: new google.maps.Point(0, 0),
				// The anchor for this image is the base of the flagpole at (0, 32).
				//anchor: new google.maps.Point(0, 24),
			};

			<?php endforeach; ?>

		}, 1000);

	}
	</script>
    <!--<link rel="stylesheet" type="text/css" href="./style.css" />-->
    <!--<script type="module" src="./index.js"></script>-->
	<style>
		html, body { width:100%; height:100%; min-width:1080px; min-height:720px; position:relative; float:left; clear:both; }
		#map { width:75%; height:100%; float:left; }
		#tours { width:23%; height:100%l float:right; }
	</style>
  </head>
  <body>
    <!--<h3>Tours Map Demo</h3>-->
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= $APIKEY ?>&callback=initMap<?= $version ?>"></script>
  </body>
</html>
