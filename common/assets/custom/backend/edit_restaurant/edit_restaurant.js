/**
 * Created by anatoliypopov on 02.11.15.
 */


$(document).ready(function() {

    initWorkingHours();


    $("#select-types").select2(
        {


            placeholder: "Select types"
        }


    );

    var dell_zone_item = function () {
        var item_name = $(this).data('item-name');
        var item_id = $(this).data('item-id');
        
        swal({
                title: "Delete item?",
                text: "Зона " + item_name,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "NO"

            },
            function () {
                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url: "/restaurant-zone/item-dell.html",
                    data: {
                        'item_id': item_id,
                        _csrf: csrfToken
                    },
                    success: function (json) {
                        if (json.error) {
                            swal("Error", "%(", "error");
                        }
                        else {
                            $("#item_" + json.item_id).remove();

                            swal("Deleted!", "\n", "success");
                        }
                    },
                    dataType: 'json'
                });
            });

        return false;
    };

    $('.dell-zone-item').click(dell_zone_item);
    
});


function initWorkingHours(){

    var csrfToken = $('meta[name="csrf-token"]').attr("content");

    var restaurantStartTime={
        type:"combodate",
        format: 'HH:mm',
        template: 'HH:mm',
        emptytext:"Время открытия",
        combodate: {

            minuteStep: 10
        }
    };
    var restaurantStopTime={
        type:"combodate",
        format: 'HH:mm',
        template: 'HH:mm',
        emptytext:"Время закрытия",
        combodate: {

            minuteStep: 10
        }
    };
    var deliveryStartTime={
        type:"combodate",
        format: 'HH:mm',
        template: 'HH:mm',
        emptytext:"Время открытия",
        combodate: {

            minuteStep: 10
        }
    };

    var deliveryStopTime={
        type:"combodate",
        format: 'HH:mm',
        template: 'HH:mm',
        emptytext:"Время закрытия",
        combodate: {

            minuteStep: 10
        }
    };



    var  restaurantStartFunction = function (e,params) {

        var editable = $(this).data('editable');
        var wD=editable.options.day;
        var restaurant_id=editable.options.restaurant;
        var closeTime = $("#rh-hours-stop-"+wD);


        if(params.newValue!==null){

            if(closeTime.data('editable').isEmpty){

                closeTime.editable('show');
            }
            else {

                $.ajax({
                    type: "POST",
                    url: '/restaurant/set-hours.html',
                    data: {

                        restaurant_id:restaurant_id,
                        weekday:wD,
                        start_time:getTime(new Date(params.newValue)),
                        stop_time:getTime(new Date(closeTime.editable('getValue',true))),
                        _csrf : csrfToken


                    }, // serializes the form's elements.
                    success: function(data)
                    {

                    }
                });


            }

        }



    };

    var restaurantStopFunction = function (e,params) {


        var editable = $(this).data('editable');
        var wD=editable.options.day;
        var openTime = $("#rh-hours-start-"+wD);
        var restaurant_id=editable.options.restaurant;

        if(params.newValue!==null){

            if(openTime.data('editable').isEmpty){

                openTime.editable('show');
            }
            else {


                $.ajax({
                    type: "POST",
                    url: '/restaurant/set-hours.html',
                    data: {
                        restaurant_id:restaurant_id,
                        weekday:wD,
                        start_time:getTime(new Date(openTime.editable('getValue',true))),
                        stop_time:getTime(new Date(params.newValue)),
                        _csrf : csrfToken


                    }, // serializes the form's elements.
                    success: function(data)
                    {

                    }
                });



            }

        }

    };


    var  deliveryStartFunction = function (e,params) {

        var editable = $(this).data('editable');
        var wD=editable.options.day;
        var restaurant_id=editable.options.restaurant;
        var closeTime = $("#dh-hours-stop-"+wD);


        if(params.newValue!==null){

            if(closeTime.data('editable').isEmpty){

                closeTime.editable('show');
            }
            else {

                $.ajax({
                    type: "POST",
                    url: '/restaurant/set-delivery-hours.html',
                    data: {

                        restaurant_id:restaurant_id,
                        weekday:wD,
                        start_time:getTime(new Date(params.newValue)),
                        stop_time:getTime(new Date(closeTime.editable('getValue',true))),
                        _csrf : csrfToken


                    }, // serializes the form's elements.
                    success: function(data)
                    {

                    }
                });


            }

        }



    };

    var deliveryStopFunction = function (e,params) {


        var editable = $(this).data('editable');
        var wD=editable.options.day;
        var openTime = $("#dh-hours-start-"+wD);
        var restaurant_id=editable.options.restaurant;

        if(params.newValue!==null){

            if(openTime.data('editable').isEmpty){

                openTime.editable('show');
            }
            else {


                $.ajax({
                    type: "POST",
                    url: '/restaurant/set-delivery-hours.html',
                    data: {
                        restaurant_id:restaurant_id,
                        weekday:wD,
                        start_time:getTime(new Date(openTime.editable('getValue',true))),
                        stop_time:getTime(new Date(params.newValue)),
                        _csrf : csrfToken


                    }, // serializes the form's elements.
                    success: function(data)
                    {

                    }
                });



            }

        }

    };





    $(".rh-editable-start").editable(restaurantStartTime).on('save', restaurantStartFunction);
    $(".rh-editable-stop").editable(restaurantStopTime).on('save', restaurantStopFunction);
  $(".dh-editable-start").editable(deliveryStartTime).on('save', deliveryStartFunction);
    $(".dh-editable-stop").editable(deliveryStopTime).on('save', deliveryStopFunction);









}


function initMap() {
    var lat = $('#restaurantform-lat').val();
    var lng = $('#restaurantform-lng').val();

    var spotCoord =  {lat: parseFloat(lat), lng: parseFloat(lng)};


    var map = new google.maps.Map(document.getElementById('map'), {
        center: spotCoord,
        zoom: 15,
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

    var marker = new google.maps.Marker({
        position: spotCoord,
        map: map,
        title: ''
    });
    markers.push(marker);
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

function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function getTime(date) {
    var d = date;
    var h = addZero(d.getHours());
    var m = addZero(d.getMinutes());

    return  h + ":" + m;
}