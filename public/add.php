<?php

// echo date('i',strtotime(5429));exit;
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
					<?php if($engine->getRole($_SESSION["uid"]) !== "Admin") : ?>
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
					<input type="text" placeholder=" " name="badress" id="ex">
					<label for="ex">Faktueringsadress...</label>
				</div>
				<div>
					<input type="text" placeholder=" " name="badress" id="ex">
					<label for="ex">Faktueringsadress...</label>
				</div>
				<div>
					<input type="text" placeholder=" " name="badress" id="ex">
					<label for="ex">Faktueringsadress...</label>
				</div>
				<div>
					<input type="text" placeholder=" " name="badress" id="ex">
					<label for="ex">asd...</label>
				</div>
				<div>
					<input type="text" placeholder=" " name="badress" id="ex">
					<label for="ex">asd...</label>
				</div>
			</div>
		</div>
		<?php
		include "partials/add/rut-calc.php";
		include "partials/add/add-log-and-files.php";
		?>


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
<?php
if (isset($_GET["oid"]) && $engine->getRequestId($_GET["oid"])) {
	require_once 'liveData/requestInfo.php';
}
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
	<?php endif ?>
	

	<div class="alerts"></div>
	<div class="modal fade" id="modal" role="dialog">
		<div class="modal-dialog modal-sm custom-modal">
			<div class="modal-content">
				<form class="addNew">
				</form>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6yfh06jGBv77PZPSS9OEQVZb2XeqNXjI&libraries=places"></script>
<script>
	function initialize(map_id = "") {
		var input = document.getElementById(map_id);
		var autocomplete = new google.maps.places.Autocomplete(input);
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place = autocomplete.getPlace();

			var directionsService = new google.maps.DirectionsService;
			var directionsRenderer = new google.maps.DirectionsRenderer;
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 6,
				center: {lat: 41.85, lng: -87.65}
			});
			directionsRenderer.setMap(map);

			var waypoint = [];
			$(".address-list-move-from").each(function(){
				if(($.trim($(this).val()).length>0)){
					waypoint.push($(this).val());
				}
			});
			$(".address-list-move-to").each(function(){
				if(($.trim($(this).val()).length>0)){
					waypoint.push($(this).val());
				}
			});
			if (waypoint.length > 0) {
				var origin = waypoint[0];
				var destination = waypoint.pop();
				waypoint.splice(0,1)
				if (origin != "" && destination != "") {
					calculateAndDisplayRoute(directionsService, directionsRenderer,origin,destination,waypoint);
				}
			}
			// console.log(place);
			// document.getElementById('city2').value = place.name;
			// document.getElementById('cityLat').value = place.geometry.location.lat();
			// document.getElementById('cityLng').value = place.geometry.location.lng();
		});
		initMap();
	}
	google.maps.event.addDomListener(window, 'load', initialize('txtfromautocomplete'));
	google.maps.event.addDomListener(window, 'load', initialize('txttoautocomplete'));

	
	$(document).on("click",".fa-exchange,.fa-trash",function () {
		var input = document.getElementById("txtfromautocomplete");
		var autocomplete = new google.maps.places.Autocomplete(input);
		
		google.maps.event.addListener(autocomplete,'click', function () {
			var place = autocomplete.getPlace();

			var directionsService = new google.maps.DirectionsService;
			var directionsRenderer = new google.maps.DirectionsRenderer;
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 6,
				center: {lat: 41.85, lng: -87.65}
			});
			directionsRenderer.setMap(map);

			var waypoint = [];
			$(".address-list-move-from").each(function(){
				if(($.trim($(this).val()).length>0)){
					waypoint.push($(this).val());
				}
			});
			$(".address-list-move-to").each(function(){
				if(($.trim($(this).val()).length>0)){
					waypoint.push($(this).val());
				}
			});
			if (waypoint.length > 0) {
				var origin = waypoint[0];
				var destination = waypoint.pop();
				waypoint.splice(0,1)
				if (origin != "" && destination != "") {
					calculateAndDisplayRoute(directionsService, directionsRenderer,origin,destination,waypoint);
				}
			}
		});
		google.maps.event.trigger(autocomplete,'click', function () {});
	});

	function initMap() {
		var directionsService = new google.maps.DirectionsService;
		var directionsRenderer = new google.maps.DirectionsRenderer;
		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 6,
			center: {lat: 41.85, lng: -87.65}
		});
		directionsRenderer.setMap(map);

		/**/
	}

	function calculateAndDisplayRoute(directionsService, directionsRenderer,origin,destination,waypoint) {
		var waypts = [];

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
				var route = response.routes[0];
				var summaryPanel = document.getElementById('directions-panel');
				summaryPanel.innerHTML = '';

				var route_data = [];
				for (var i = 0; i < route.legs.length; i++) {
					var legs = {
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
		            data: {'route_data':route_data},
		            type: 'post',
		            dataType: 'html',
		            catch : false,
		            success: function (data) {
		                summaryPanel.innerHTML = data;
		            }
		        });
			} else {
				window.alert('Directions request failed due to ' + status);
			}
		});
	} 
</script>
</html>