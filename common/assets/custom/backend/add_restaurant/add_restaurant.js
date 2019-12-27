/**
 * Created by anatoliypopov on 02.11.15.
 */


$(document).ready(function() {
    $("#select-types").select2(
        {


            placeholder: "Select types"
        }


    );









});

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -33.8688, lng: 151.2195},
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    var markers = [];
    // [START region_getplaces]
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    google.maps.event.addListener(map, 'click', function(event) {


        var lat = event.latLng.lat();
        var lng = event.latLng.lng();


        if(markers.length>0)
        {
            markers[0].setMap(null);



            markers.splice(0, 1);

            var marker2 = new google.maps.Marker({
                position: event.latLng,
                map: map
            });

            markers.push(marker2);

        }else {


            var  marker2 = new google.maps.Marker({
                position: event.latLng,
                map: map
            });
            markers.push(marker2);
        }



        $('#restaurantform-lat').val(lat );;

        $('#restaurantform-lng').val(lng );;

    });

    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {

            console.log(place);
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };




            $('#restaurantform-address').val(place.formatted_address);
            $('#restaurantform-lat').val(place.geometry.location.lat);
            $('#restaurantform-lng').val(place.geometry.location.lng);




            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
    // [END region_getplaces]
}


