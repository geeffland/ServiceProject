//google.maps.event.addDomListener(window, 'load', initialize);
//var map = new GMap2(document.getElementById("map_canvas"));

//var geocoder = new GClientGeocoder();
//var geocoder = new google.maps.Geocoder();
var map;
var marker;

// This function calls Google Maps and gets the geo codes based on an address
// address = "13500 Botts Road, Grandview MO"
function showAddress()
{
	var geocoder = new google.maps.Geocoder();
	address = document.getElementById("jform_streetaddress1").value + " " + document.getElementById("jform_city").value + " " + document.getElementById("jform_state").value + " " + document.getElementById("jform_zipcode").value;
	//geocoder.getLocations(address, handleGeoCodes);
	geocoder.geocode( { 'address': address}, handleGeoCodes);
}

// This function reads the GeoCodes and puts them into the Address edit form
function handleGeoCodes(results, status)
{
	map = new google.maps.Map(document.getElementById('map_canvas'), {
		zoom: document.getElementById("jform_gm_zoomlevel").value*1,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});
	
	// add listener for zoom changes
	google.maps.event.addListener(map, 'dragend', updateCenter);
	google.maps.event.addListener(map, 'zoom_changed', updateZoomlevel);
	//alert(results[0]['address_components'][component]['short_name']);
	// Retrieve the object
	point = results[0].geometry.location;
	
	// Retrieve the Latitude and Longitude (Geo Codes)
	ThisLat = point.lat();
	ThisLong = point.lng();
	//point = new google.maps.LatLng(ThisLat, ThisLong);
	document.getElementById("jform_latitude").value = ThisLat;
	document.getElementById("jform_longitude").value = ThisLong;
	document.getElementById("jform_center_latitude").value = ThisLat;
	document.getElementById("jform_center_longitude").value = ThisLong;
	// put a marker on the map that the user can drag to adjust
	marker = new google.maps.Marker({position: point, map: map, draggable: true});
	// Center the map on the point
	map.setCenter(point, 13);
	
	//Add the marker to the map
	//map.addOverlay(marker);
	
	// Add listener to listen to dragged marker
	google.maps.event.addListener(marker, 'dragend', updateDraggedGeoCodes);
	
}

// This function updates the map center
function updateCenter()
{
	ThisCenter = map.getCenter();
	ThisLat = ThisCenter.lat();
	ThisLong = ThisCenter.lng();
	document.getElementById("jform_center_latitude").value = ThisLat;
	document.getElementById("jform_center_longitude").value = ThisLong;
}

// This function updates the zoom level
function updateZoomlevel()
{
	ThisZoom = map.getZoom();
	document.getElementById("jform_gm_zoomlevel").value = ThisZoom;
}

// This function updates the geocodes based on the dragged marker
function updateDraggedGeoCodes()
{
	point = marker.getPosition()
	ThisLat = point.lat();
	ThisLong = point.lng();
	document.getElementById("jform_latitude").value = ThisLat;
	document.getElementById("jform_longitude").value = ThisLong;
}

function showLatLng() {
	var latlng = new google.maps.LatLng(document.getElementById("jform_latitude").value, document.getElementById("jform_longitude").value);
	var mapCenter = new google.maps.LatLng(document.getElementById("jform_center_latitude").value, document.getElementById("jform_center_longitude").value);
	var myOptions = {
		zoom: document.getElementById("jform_gm_zoomlevel").value*1,
		center: mapCenter,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	// add listener for zoom changes
	google.maps.event.addListener(map, 'dragend', updateCenter);
	google.maps.event.addListener(map, 'zoom_changed', updateZoomlevel);

	marker = new google.maps.Marker({position: latlng, map: map, draggable: true});
	// Add listener to listen to dragged marker
	google.maps.event.addListener(marker, 'dragend', updateDraggedGeoCodes);
}