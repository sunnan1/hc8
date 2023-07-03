<?php namespace _;

static $APIKEY	= 'AIzaSyCwkg3ojHxMt6fleyjG3Be9x3JWJlJwBfQ';

$patients		= io::getData('patients');

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Add Map</title>
	<script>

		function initMap() {

			let mapOpts = {
				/* center: { lat: 46.1080207, lng: -60.2318273 }, */
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

				patients['<?= $id ?>'].markerOpts	= { position: new google.maps.LatLng(<?= $lat ?>, <?= $long ?>) };
				patients['<?= $id ?>'].marker		= new google.maps.Marker(patients['<?= $id ?>'].markerOpts);

				patients['<?= $id ?>'].marker.setMap(map);

				<?php endforeach; ?>

		}

	</script>

    <!--<link rel="stylesheet" type="text/css" href="./style.css" />-->
    <!--<script type="module" src="./index.js"></script>-->
	<style>
		html, body { width:100%; height:100%; min-width:1080px; min-height:720px; position:relative; float:left; clear:both; }
		#map { width:100%; height:100%; }
	</style>
  </head>
  <body>
    <h3>Tours Map Demo</h3>
    <div id="map"></div>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.47&key=<?= $APIKEY ?>&callback=initMap" defer></script>
  </body>
</html>
