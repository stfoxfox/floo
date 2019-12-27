



'use strict';

function LocationManager_f() {
    this.location = false;
    this.address;
    this.addressName;
    this.section;
    this.stage;
    this.flat;
    this.lat;
    this.lon;
    this.locations;
    this.locationID = false;
    this.restaurants;
    this.restaurant = false;
    this.zone = false;
    this.myMap;
    this.collection;
    this.suggestions;
    this.open=true;




    this.geocode = function(suggest){


        ymaps.geocode(suggest, {
            /**
             * Опции запроса
             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
             */
            // Сортировка результ атов от центра окна карты.
            // boundedBy: myMap.getBounds(),
            // strictBounds: true,
            // Вместе с опцией boundedBy будет искать строго внутри области, указанной в boundedBy.
            // Если нужен только один результат, экономим трафик пользователей.
            results: 1
        }).then(function (res) {

            // Выбираем первый результат геокодирования.
            var firstGeoObject = res.geoObjects.get(0),
                // Координаты геообъекта.
                coords = firstGeoObject.geometry.getCoordinates(),
                // Область видимости геообъекта.
                bounds = firstGeoObject.properties.get('boundedBy');



            var pr = firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.precision');
            if(pr == "exact" && firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.kind') == 'house'){



                LocationManager.lat = coords[0];
                LocationManager.lon =coords[1];


                LocationManager.newPoint();
                LocationManager.address = firstGeoObject.properties.get('text');
                LocationManager.addressName = firstGeoObject.properties.get('name');
                LocationManager.section = $('[data-section]').val();
                LocationManager.stage = $('[data-stage]').val();
                LocationManager.flat = $('[data-flat]').val();
                MainManager.showAddressError(false);
                LocationManager.testOutsideMap();




            }else {

                MainManager.showAddressError(true);
            }

            /**
             * Все данные в виде javascript-объекта.
             */
            //  console.log('Все данные геообъекта: ', firstGeoObject.properties.getAll());
            /**
             * Метаданные запроса и ответа геокодера.
             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderResponseMetaData.xml
             */
            //console.log('Метаданные ответа геокодера: ', res.metaData);
            /**
             * Метаданные геокодера, возвращаемые для найденного объекта.
             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderMetaData.xml
             */
            //console.log('Метаданные геокодера: ', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData'));
            /**
             * Точность ответа (precision) возвращается только для домов.
             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/precision.xml
             */
            //console.log('precision', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.precision'));
            /**
             * Тип найденного объекта (kind).
             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/kind.xml
             */
            /* console.log('Тип геообъекта: %s', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.kind'));
             console.log('Название объекта: %s', firstGeoObject.properties.get('name'));
             console.log('Описание объекта: %s', firstGeoObject.properties.get('description'));
             console.log('Полное описание объекта: %s', firstGeoObject.properties.get('text'));
 */
            /**
             * Если нужно добавить по найденным геокодером координатам метку со своими стилями и контентом балуна, создаем новую метку по координатам найденной и добавляем ее на карту вместо найденной.
             */
            /**
             var myPlacemark = new ymaps.Placemark(coords, {
             iconContent: 'моя метка',
             balloonContent: 'Содержимое балуна <strong>моей метки</strong>'
             }, {
             preset: 'islands#violetStretchyIcon'
             });

             myMap.geoObjects.add(myPlacemark);
             */
        });

    };

    this.newPoint = function () {
        LocationManager.collection.removeAll();
        LocationManager.collection.add(new ymaps.Placemark([LocationManager.lat, LocationManager.lon], '', {
            iconImageHref: "/bitrix/templates/pronto/images/point.png",
            iconImageSize: [31, 47]
        }));
        LocationManager.myMap.setCenter([LocationManager.lat, LocationManager.lon]);
        LocationManager.myMap.geoObjects.add(LocationManager.collection);
        $("#map").show();
    };

    this.loadRestaurants = function () {
        LocationManager.restaurants = restPolygons();
    };

    this.loadBasketMap = function () {
        ymaps.ready(function () {
            LocationManager.myMap = new ymaps.Map('map', {center: [55.76, 37.64], zoom: 16});
            LocationManager.collection = new ymaps.GeoObjectCollection({});
        });
    };
    /*
        this.initSuggestions = function() {
            LocationManager.suggestions = $("[data-address]").suggestions({
                serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
                token: "f53809dc9ad4846a811a2f794772e0e9bbe157e4",
                type: "ADDRESS",
                count: 8,
                autoSelectFirst: true,
                deferRequestBy: 600,
                floating: true,
                timeout: 1000,
                minChars: 5,
                onSelect: function (suggestion) {
                    if (suggestion.data.fias_level > 6) {
                        LocationManager.lat = suggestion.data.geo_lat;
                        LocationManager.lon = suggestion.data.geo_lon;
                        LocationManager.newPoint();
                        LocationManager.address = suggestion.value;
                        LocationManager.addressName = suggestion.data.street_with_type + ' ' + suggestion.data.house;
                        LocationManager.section = $('[data-section]').val();
                        LocationManager.stage = $('[data-stage]').val();
                        LocationManager.flat = $('[data-flat]').val();
                        MainManager.showAddressError(false);
                        LocationManager.testOutsideMap();
                    }
                    else {
                        MainManager.clearHints();
                        MainManager.showAddressError(true);
                    }
                },
                onSelectNothing: function (data) {
                    MainManager.clearHints();
                }
            });
            if($('[data-address]').val() != '') {
                $('[data-address]').focus();
            }
        };
    */
    this.initSuggestions = function(ymaps) {



        var suggestView = new ymaps.SuggestView('orderform-address',{
            results: 5,
            boundedBy:[[56.23, 36.51],[55.4, 38.2]],
            offset: [10, 10],
            provider: {
                suggest: function (request, options) {
                    console.log(ymaps.suggest(request));
                    return (LocationManager.open?
                        ymaps.suggest(request) : ymaps.vow.resolve([]))
                        .then(function (res) {
                            suggestView.events.fire('requestsuccess', {
                                target: suggestView,
                            })

                            return res;
                        })

                }
            }


        });

        $( "#orderform-address" ).blur(function() {

            setTimeout(function(){


                var active_index = suggestView.state.get('activeIndex');

                if(active_index===null){


                    var suggestItems = suggestView.state.get('items');

                    if(suggestItems !==null && suggestItems !== undefined && typeof  suggestItems !== "undefined" && suggestItems.length>0){


                        var firstItem = suggestItems[0];

                        LocationManager.open=false;
                        $('[data-address]').val(firstItem.value);


                        $('[data-section]').val("");
                        $('[data-stage]').val("");
                        $('[data-flat]').val("");
                        suggestView.events.once('requestsuccess', function () {
                            LocationManager.open=true;
                        });




                        ymaps.geocode(firstItem.value, {
                            /**
                             * Опции запроса
                             * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
                             */
                            // Сортировка результ атов от центра окна карты.
                            // boundedBy: myMap.getBounds(),
                            // strictBounds: true,
                            // Вместе с опцией boundedBy будет искать строго внутри области, указанной в boundedBy.
                            // Если нужен только один результат, экономим трафик пользователей.
                            results: 1
                        }).then(function (res) {

                            // Выбираем первый результат геокодирования.
                            var firstGeoObject = res.geoObjects.get(0),
                                // Координаты геообъекта.
                                coords = firstGeoObject.geometry.getCoordinates(),
                                // Область видимости геообъекта.
                                bounds = firstGeoObject.properties.get('boundedBy');
                            // console.log(coords);
                            $("#orderform-lat").val("");
                            $("#orderform-lng").val("") ;
                            $('#orderform-lat').val(coords[0]);
                            $('#orderform-lng').val(coords[1]);
                            // console.log(coords[0]);


                            var pr = firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.precision');
                            if(pr == "exact" && firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.kind') == 'house'){



                                LocationManager.lat = coords[0];
                                LocationManager.lon =coords[1];
                                LocationManager.newPoint();
                                //LocationManager.address = firstGeoObject.properties.get('text');
                                //LocationManager.addressName = firstGeoObject.properties.get('name');
                                //LocationManager.section = $('[data-section]').val();
                                //LocationManager.stage = $('[data-stage]').val();
                               // LocationManager.flat = $('[data-flat]').val();
                                MainManager.showAddressError(false);
                                LocationManager.testOutsideMap();

                            }else {

                                MainManager.showAddressError(true);
                            }

                            /**
                             * Все данные в виде javascript-объекта.
                             */
                            //  console.log('Все данные геообъекта: ', firstGeoObject.properties.getAll());
                            /**
                             * Метаданные запроса и ответа геокодера.
                             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderResponseMetaData.xml
                             */
                            //console.log('Метаданные ответа геокодера: ', res.metaData);
                            /**
                             * Метаданные геокодера, возвращаемые для найденного объекта.
                             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderMetaData.xml
                             */
                            //console.log('Метаданные геокодера: ', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData'));
                            /**
                             * Точность ответа (precision) возвращается только для домов.
                             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/precision.xml
                             */
                            //console.log('precision', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.precision'));
                            /**
                             * Тип найденного объекта (kind).
                             * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/kind.xml
                             */
                            /* console.log('Тип геообъекта: %s', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.kind'));
                             console.log('Название объекта: %s', firstGeoObject.properties.get('name'));
                             console.log('Описание объекта: %s', firstGeoObject.properties.get('description'));
                             console.log('Полное описание объекта: %s', firstGeoObject.properties.get('text'));
                 */
                            /**
                             * Если нужно добавить по найденным геокодером координатам метку со своими стилями и контентом балуна, создаем новую метку по координатам найденной и добавляем ее на карту вместо найденной.
                             */
                            /**
                             var myPlacemark = new ymaps.Placemark(coords, {
             iconContent: 'моя метка',
             balloonContent: 'Содержимое балуна <strong>моей метки</strong>'
             }, {
             preset: 'islands#violetStretchyIcon'
             });

                             myMap.geoObjects.add(myPlacemark);
                             */
                        });

                    }else{


                        $('[data-address]').val("");
                        $('[data-section]').val("");
                        $('[data-stage]').val("");
                        $('[data-flat]').val("");

                    }



                }

            }, 500);


        });


        suggestView.events.add('select',function(e){




            ymaps.geocode(e.get('item').value, {
                /**
                 * Опции запроса
                 * @see https://api.yandex.ru/maps/doc/jsapi/2.1/ref/reference/geocode.xml
                 */
                // Сортировка результ атов от центра окна карты.
                // boundedBy: myMap.getBounds(),
                // strictBounds: true,
                // Вместе с опцией boundedBy будет искать строго внутри области, указанной в boundedBy.
                // Если нужен только один результат, экономим трафик пользователей.
                results: 1
            }).then(function (res) {

                // Выбираем первый результат геокодирования.
                var firstGeoObject = res.geoObjects.get(0),
                    // Координаты геообъекта.
                    coords = firstGeoObject.geometry.getCoordinates(),
                    // Область видимости геообъекта.
                    bounds = firstGeoObject.properties.get('boundedBy');



                var pr = firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.precision');
                if(pr == "exact" && firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.kind') == 'house'){



                    LocationManager.lat = coords[0];
                    LocationManager.lon =coords[1];
                    LocationManager.newPoint();
                    LocationManager.address = firstGeoObject.properties.get('text');
                    LocationManager.addressName = firstGeoObject.properties.get('name');
                    LocationManager.section = $('[data-section]').val();
                    LocationManager.stage = $('[data-stage]').val();
                    LocationManager.flat = $('[data-flat]').val();
                    MainManager.showAddressError(false);
                    LocationManager.testOutsideMap();

                }else {

                    MainManager.showAddressError(true);
                }

                /**
                 * Все данные в виде javascript-объекта.
                 */
                //  console.log('Все данные геообъекта: ', firstGeoObject.properties.getAll());
                /**
                 * Метаданные запроса и ответа геокодера.
                 * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderResponseMetaData.xml
                 */
                //console.log('Метаданные ответа геокодера: ', res.metaData);
                /**
                 * Метаданные геокодера, возвращаемые для найденного объекта.
                 * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/GeocoderMetaData.xml
                 */
                //console.log('Метаданные геокодера: ', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData'));
                /**
                 * Точность ответа (precision) возвращается только для домов.
                 * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/precision.xml
                 */
                //console.log('precision', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.precision'));
                /**
                 * Тип найденного объекта (kind).
                 * @see https://api.yandex.ru/maps/doc/geocoder/desc/reference/kind.xml
                 */
                /* console.log('Тип геообъекта: %s', firstGeoObject.properties.get('metaDataProperty.GeocoderMetaData.kind'));
                 console.log('Название объекта: %s', firstGeoObject.properties.get('name'));
                 console.log('Описание объекта: %s', firstGeoObject.properties.get('description'));
                 console.log('Полное описание объекта: %s', firstGeoObject.properties.get('text'));
     */
                /**
                 * Если нужно добавить по найденным геокодером координатам метку со своими стилями и контентом балуна, создаем новую метку по координатам найденной и добавляем ее на карту вместо найденной.
                 */
                /**
                 var myPlacemark = new ymaps.Placemark(coords, {
             iconContent: 'моя метка',
             balloonContent: 'Содержимое балуна <strong>моей метки</strong>'
             }, {
             preset: 'islands#violetStretchyIcon'
             });

                 myMap.geoObjects.add(myPlacemark);
                 */
            });
        })



        if($('[data-address]').val() != '') {
            $('[data-address]').focus();
        }
    };
    this.init = function () {
        $("#map").hide();
       // if(window.location.pathname != '/personal/') {
            LocationManager.loadBasketMap();
            //LocationManager.loadRestaurants();
           MainManager.showAddressError(false);
            $('.apply .text').hide();
            //LocationManager.initSuggestions();
       // }
       // LocationManager.initLocations();
       // $(document)
         //   .on("click", "[data-address-list]", LocationManager.copyAddress);
    };

    this.copyAddress = function () {
        $("[data-address-list]").removeClass('active');
        $(this).addClass('active');
        var index = $(this).attr('data-address-list');
        LocationManager.doCopy(LocationManager.locations[index]);
    };

    this.doCopy = function (element) {
        LocationManager.locationID = element.id;
        $('[data-address]').val(element.address).focus();
        $('[data-section]').val(element.section);
        $('[data-stage]').val(element.stage);
        $('[data-flat]').val(element.flat);
    };

    this.initLocations = function () {
        if(typeof locations != 'undefined') {
            LocationManager.locations = locations;
            LocationManager.locations.forEach(function (element, index) {
                $('.addr-list h2').after('<button data-address-list="' + index + '" class="btn border">' + element.title + '</button>');
            });
        }
    };

    this.testOutsideMap = function () {


        if (typeof LocationManager.lat != 'undefined' && typeof LocationManager.lon != 'undefined') {


            var csrfToken = $('meta[name="csrf-token"]').attr("content");

            $.post(
                "/cart/check-zone.html",
                {
                    "_csrf-frontend" : csrfToken,

                    "lat": LocationManager.lat,
                    "lng": LocationManager.lon,
                },
                function (data) {
                    if (data.found) {

                        // $("#orderform-lat").val(LocationManager.lat);
                        // $("#orderform-lng").val(LocationManager.lon) ;

                    }else {


                        MainManager.showAddressError(true);
                       // MainManager.showTextAlert('К сожалению, ваш адрес не входит в зону доставки наших ресторанов, но вы можете сами забрать заказ в удобном для вас <a href="/restaurants/">ресторане</a>');
                        MainManager.showTextAlert(data.message);

                    }
                }, "json");
        }

                else{


        }


    };

    this.saveLocation = function (callback) {
        LocationManager.section = $('[data-section]').val();
        LocationManager.stage = $('[data-stage]').val();
        LocationManager.flat = $('[data-flat]').val();

        if (LocationManager.address && LocationManager.addressName) {
            $.post(
                "/ajax/",
                {
                    "action": 'locationUpdate',
                    "id": LocationManager.locationID,
                    "address": LocationManager.address,
                    "addressName": LocationManager.addressName,
                    "section": LocationManager.section,
                    "stage": LocationManager.stage,
                    "flat": LocationManager.flat
                },
                function (data) {
                    if (data.result == 'ok') {
                        if (!LocationManager.locationID) {
                            var index = $('[data-address-list]').length;
                            $('[data-address-list]').removeClass("active");
                            $('.addr-list h2').after('<button data-address-list="' + index + '" class="btn border active">' + data.title + '</button>');
                            LocationManager.locationID = data.locationID;
                        }
                        if (typeof callback == 'undefined')
                            MainManager.showTextAlert('Новый адрес сохранен');
                        else
                            callback();
                    }
                }, "json");
        }
        else
            MainManager.showTextAlert('Поля "город", "улица" и "дом" обязательны к заполнению');
    };
}


$('.address-change-button').on('click', function(){
    $('#orderform-address').val($(this).attr('data-address'));
    $('#orderform-lat').val($(this).attr('data-lat'));
    $('#orderform-lng').val($(this).attr('data-lng'));
    $('#orderform-entrance').val($(this).attr('data-entrance'));
    $('#orderform-floor').val($(this).attr('data-floor'));
    $('#orderform-flat').val($(this).attr('data-flat'));
});

