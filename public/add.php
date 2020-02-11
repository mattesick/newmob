<?php

require_once "../boot.php";
include "rights/auth.php"; ?>
<!DOCTYPE html>
<html lang="sv">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php include "js/scripts.php";
	include "css/style.php";
	?>
	<link rel="stylesheet" href="css/select.css">
	<link rel="stylesheet" href="css/add.css">
	<link rel="stylesheet" href="css/add/request.css">
</head>

<body <?php if (isset($_GET["oid"])) : ?> id=<?php echo $engine->getGeneratedId($_GET["oid"]) ?> <?php endif ?>>

	<?php
	include "partials/nav.php";
	?>
	<main>
		<div class="add-welcome">
			<h2>NY FÖRFRÅGAN</h2>
			<?php
			if (isset($_GET["oid"]) && $engine->getRequestId($_GET["oid"])) : ?>
				<div style="display:flex;float:right;align-items:center;">
					<button class="copy">KOPIERA ORDER</button>
					<?php if ($engine->getRole($_SESSION["uid"]) !== "Admin") : ?>
						<i class="fas fa-edit edit-add"></i>
					<?php endif ?>
				</div>
			<?php endif ?>

		</div>
		<?php include "partials/add/add-request.php";
		include "partials/add/add-article.php";
		?>
		<div class="chosen-article">
			<div class="remove-article"><i class="fad fa-times"></i></div>
			<div>
				<h3>Flyttpaket 2 - 1-69 kvm</h3>
			</div>
			<div class="inputs">
				<div>
					<input type="text" placeholder=" " name="badrfess" id="ex">
					<label for="ex">test...</label>
				</div>
				<div>
					<input type="text" placeholder=" " name="badsress" id="ex">
					<label for="ex">test...</label>
				</div>
				<div>
					<input type="text" placeholder=" " name="badraess" id="ex">
					<label for="ex">test...</label>
				</div>
				<div>
					<input type="text" placeholder=" " name="badregss" id="ex">
					<label for="ex">test...</label>
				</div>
				<div>
					<input type="text" placeholder=" " name="badraess" id="ex">
					<label for="ex">test...</label>
				</div>
			</div>
		</div>
		<?php
		include "partials/add/rut-calc.php";
		include "partials/add/add-log-and-files.php";
		?>
		<div id="map" style="height: 500px;width: 100%;border:1px #000 solid"></div>
		<div id="directions-panel" style="background-color: white;padding: 0;margin-bottom: 20px;">
			<div class="loading"><i class="fad fa-circle-notch fa-5x"></i>
				<div>

	</main>

	<?php if (!isset($_GET["oid"]) || !$engine->getRequestId($_GET["oid"])) : ?>
		<script>
			let id = "";
			let alf = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			for (let i = 0; i < 32; i++) {
				id += alf[Math.round(Math.random() * (alf.length - 1))];
			}
			$("body").attr("id", id)
		</script>
	<?php endif ?>
	<script src="js/select.js"></script>
	<script src="js/add/addLog.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6yfh06jGBv77PZPSS9OEQVZb2XeqNXjI&libraries=places&language=sv&region=SE"></script>
	<script>
		function forceCalcRoute() {

			let directionsService = new google.maps.DirectionsService;
			let directionsRenderer = new google.maps.DirectionsRenderer;
			let map = new google.maps.Map(document.getElementById('map'), {
				zoom: 8,
				center: {
					lat: 55.60,
					lng: 13.00
				}
			});
			directionsRenderer.setMap(map);

			let waypoint = [];
			$(".address-list-move-from").each(function() {
				if (($.trim($(this).val()).length > 0)) {
					let point = $($(`input[name=citymove-from]`)).length > 0 ? $(this).val() + ", " + ($(`input[name=citymove-from]`)).val() : $(this).val();
					waypoint.push(point);
				}
			});
			$(".address-list-move-to").each(function() {
				if (($.trim($(this).val()).length > 0)) {
					let point = $($(`input[name=citymove-to]`)).length > 0 ? $(this).val() + ", " + ($(`input[name=citymove-to]`)).val() : $(this).val();
					waypoint.push(point);
				}
			});
			if (waypoint.length > 0) {
				let origin = waypoint[0];
				let destination = waypoint.pop();
				waypoint.splice(0, 1)
				if (origin != "" && destination != "") {
					calculateAndDisplayRoute(directionsService, directionsRenderer, origin, destination, waypoint);
				}
			}
		}

		function initialize(map_id = "") {
			let input = document.getElementById(map_id);
			if (!input) return;
			let autocomplete = new google.maps.places.Autocomplete(input);

			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				let place = autocomplete.getPlace();
				if (!place.address_components) return false;
				let state = $(input).parent().parent().parent().attr("class");
				if ($(input).attr("id") == "badress") state = "";
				let i = 0;
				for (; i < $(`input[name=adress${state}]`).length; i++) {
					if (input == $(`input[name=adress${state}]`)[i]) {
						break;
					};
				}
				let number = false;
				$($(`input[name=zipcode${state}]`)[i]).val("");
				$($(`input[name=city${state}]`)[i]).val("");
				for (let j = 0; j < place.address_components.length; j++) {

					if (place.address_components[j].types[0] == "postal_code") {
						$($(`input[name=zipcode${state}]`)[i]).val(place.address_components[j].long_name);
					} else if (place.address_components[j].types[0] == "postal_town" || place.address_components[j].types[0] == "locality") {
						$($(`input[name=city${state}]`)[i]).val(place.address_components[j].long_name)
					} else if (place.address_components[j].types[0] == "country") {
						let val = $($(`input[name=city${state}]`)[i]).val().length > 0 ? $($(`input[name=city${state}]`)[i]).val() + ", " + place.address_components[j].long_name : place.address_components[j].long_name;
						$($(`input[name=city${state}]`)[i]).val(val);
					} else if (place.address_components[j].types[0] == "route") {

						if ($(input).attr("id") == "badress") {
							if (!number) $(`input[name=badress]`).val("");
							$($(`input[name=badress]`)[i]).val(place.address_components[j].long_name + " " + $($(`input[name=badress]`)[i]).val());
						} else {
							if (!number) $(`input[name=adress${state}]`).val("");
							$($(`input[name=adress${state}]`)[i]).val(place.address_components[j].long_name + " " + $($(`input[name=adress${state}]`)[i]).val());
						}

					} else if (place.address_components[j].types[0] == "street_number") {
						number = true;

						if ($(input).attr("id") == "badress") {
							$(`input[name=badress]`).val("");
							$($(`input[name=badress]`)[i]).val(place.address_components[j].long_name + " " + $($(`input[name=badress]`)[i]).val());
						} else {
							$(`input[name=adress${state}]`).val("");
							$($(`input[name=adress${state}]`)[i]).val(place.address_components[j].long_name + " " + $($(`input[name=adress${state}]`)[i]).val());
						}
					}
				}
				if ($(input).attr("id") == "badress") return false;
				let directionsService = new google.maps.DirectionsService;
				let directionsRenderer = new google.maps.DirectionsRenderer;
				let map = new google.maps.Map(document.getElementById('map'), {
					zoom: 8,
					center: {
						lat: 55.99,
						lng: 13.44
					}
				});
				directionsRenderer.setMap(map);

				let waypoint = [];
				$(".address-list-move-from").each(function(index) {
					if (($.trim($(this).val()).length > 0)) {
						let point = $($(`input[name=citymove-from]`)).length > 0 ? $(this).val() + ", " + ($(`input[name=citymove-from]`)).val() : $(this).val();
						waypoint.push(point);
					}
				});
				$(".address-list-move-to").each(function() {
					if (($.trim($(this).val()).length > 0)) {
						let point = $($(`input[name=citymove-to]`)).length > 0 ? $(this).val() + ", " + ($(`input[name=citymove-to]`)).val() : $(this).val();
						waypoint.push(point);
					}
				});
				if (waypoint.length > 0) {
					let origin = waypoint[0];
					let destination = waypoint.pop();
					waypoint.splice(0, 1)
					if (origin != "" && destination != "") {
						calculateAndDisplayRoute(directionsService, directionsRenderer, origin, destination, waypoint);
					}
				}


			});
			initMap();

		}
		google.maps.event.addDomListener(window, 'load', initialize('txtfromautocomplete'));
		google.maps.event.addDomListener(window, 'load', initialize('txttoautocomplete'));
		google.maps.event.addDomListener(window, 'load', initialize('badress'));


		$(document).on("click", ".fa-exchange,.fa-trash", function() {
			let input = document.getElementById("txtfromautocomplete");
			let autocomplete = new google.maps.places.Autocomplete(input);

			google.maps.event.addListener(autocomplete, 'click', function() {
				let place = autocomplete.getPlace();


				let directionsService = new google.maps.DirectionsService;
				let directionsRenderer = new google.maps.DirectionsRenderer;
				let map = new google.maps.Map(document.getElementById('map'), {
					zoom: 8,
					center: {
						lat: 55.99,
						lng: 13.44
					}
				});
				directionsRenderer.setMap(map);

				let waypoint = [];
				$(".address-list-move-from").each(function() {
					if (($.trim($(this).val()).length > 0)) {
						let point = $($(`input[name=citymove-from]`)).length > 0 ? $(this).val() + ", " + ($(`input[name=citymove-from]`)).val() : $(this).val();
						waypoint.push(point);
					}
				});
				$(".address-list-move-to").each(function() {
					if (($.trim($(this).val()).length > 0)) {
						let point = $($(`input[name=citymove-to]`)).length > 0 ? $(this).val() + ", " + ($(`input[name=citymove-to]`)).val() : $(this).val();
						waypoint.push(point);
					}
				});
				if (waypoint.length > 0) {
					let origin = waypoint[0];
					let destination = waypoint.pop();
					waypoint.splice(0, 1)
					if (origin != "" && destination != "") {
						calculateAndDisplayRoute(directionsService, directionsRenderer, origin, destination, waypoint);
					}
				}
			});
			google.maps.event.trigger(autocomplete, 'click', function() {});
		});

		function initMap() {
			let directionsService = new google.maps.DirectionsService;
			let directionsRenderer = new google.maps.DirectionsRenderer;
			let map = new google.maps.Map(document.getElementById('map'), {
				zoom: 8,
				center: {
					lat: 55.99,
					lng: 13.44
				}
			});
			directionsRenderer.setMap(map);
			forceCalcRoute();
		}

		function calculateAndDisplayRoute(directionsService, directionsRenderer, origin, destination, waypoint) {
			let waypts = [];

			if (waypoint.length > 0) {
				waypoint.forEach(myFunction);

				function myFunction(item, index) {
					waypts.push({
						location: item,
						stopover: true
					});
				}
			}

			directionsService.route({
				origin: origin,
				destination: destination,
				waypoints: waypts,
				optimizeWaypoints: false,
				travelMode: 'DRIVING'
			}, function(response, status) {
				if (status === 'OK') {
					directionsRenderer.setDirections(response);
					let route = response.routes[0];
					let summaryPanel = document.getElementById('directions-panel');
					summaryPanel.innerHTML = '';

					let route_data = [];
					for (let i = 0; i < route.legs.length; i++) {
						let legs = {
							start_address: route.legs[i].start_address,
							end_address: route.legs[i].end_address,
							distance: {
								text: route.legs[i].distance.text,
								value: route.legs[i].distance.value,
							},
							duration: {
								text: route.legs[i].duration.text,
								value: route.legs[i].duration.value,
							},
						};
						route_data.push(legs);
					}
					$.ajax({
						url: 'get_map_details.php',
						data: {
							'route_data': route_data
						},
						type: 'post',
						dataType: 'html',
						catch: false,
						success: function(data) {
							summaryPanel.innerHTML = data;
						}
					});
				} else {
					console.log(status)
				}
			});
		}
	</script>
	<?php

	if (isset($_GET["oid"]) && $engine->getRequestId($_GET["oid"]) && $engine->getRole($_SESSION["uid"]) !== "Admin") : ?>
		<script>
			$("main input").attr("readonly", true).css("background", "rgb(230,230,230)");
			$('main button').prop('disabled', true).css("background", "rgb(230,230,230)");
			$(".copy").prop("disabled", false).css("background", "");
			$('main input[type=submit]').prop('disabled', true).css("background", "rgb(230,230,230)");
			$("main input[type=checkbox]").prop("disabled", true).css("background", "rgb(230,230,230)");
			$(".custom-select").css("background", "rgb(230,230,230)");
			$("main textarea").attr("readonly", true).css("background", "rgb(230, 230, 230)");
			$("main i").off();
			$("main p").off();
			$(".edit-add").click(function() {
				$("main input").attr("readonly", false).css("background", "");
				$('main button').prop('disabled', false).css("background", "");
				$('main input[type=submit]').prop('disabled', false).css("background", "");
				$("main input[type=checkbox]").prop("disabled", false);
				$("main textarea").attr("readonly", false).css("background", "");
				$.getScript("js/add/article.js");
				$.getScript("js/add/sameAsBillingAdress.js");
				$.getScript("js/add/exchange.js");
				$.getScript("js/add/addName.js");
				$.getScript("js/add/post.js");
				$.getScript("js/add/addAdress.js");
				$.getScript("js/add/uploadFile.js");
				$(this).remove();
			})
		</script>
	<?php else : ?>
		<script src="js/add/article.js"></script>
		<script src="js/add/sameAsBillingAdress.js"></script>
		<script src="js/add/exchange.js"></script>
		<script src="js/add/addAdress.js"></script>
		<script src="js/add/addName.js"></script>
		<script src="js/add/post.js"></script>
		<script src="js/add/uploadFile.js"></script>
		<script>
			$(".loading").show();
			$(document).ready(() => {
				$(".loading").hide();
			})
		</script>
	<?php endif;

	if (isset($_GET["oid"]) && $engine->getRequestId($_GET["oid"])) {
		require_once 'liveData/requestInfo.php';
	} ?>


	<div class="alerts"></div>
	<div class="modal fade" id="modal" role="dialog">
		<div class="modal-dialog modal-sm custom-modal">
			<div class="modal-content">
				<form class="addNew">
				</form>
			</div>
		</div>
	</div>
	<script>
		$(".dashboard input").keydown(e => {
			if (e.key == "Enter") {
				e.preventDefault();
				return false;
			}

		})
	</script>
</body>

</html>