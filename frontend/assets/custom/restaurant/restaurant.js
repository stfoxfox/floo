'use strict';

function RestaurantManager_f() {
    this.arPoints = [];
    this.map;
    this.center;
    this.zoom;
    this.collection;

    this.init = function () {
        RestaurantManager.center = center();
        RestaurantManager.zoom = zoom();
        ymaps.ready(RestaurantManager.mapInit);
        $('[data-children]').click(function(e) {
            RestaurantManager.childrenPoints(e);
        });
        $('[data-music]').click(function(e) {
            RestaurantManager.musicPoints(e);
        });
        $('[data-lunch]').click(function(e) {
            RestaurantManager.lunchPoints(e);
        });
        $('[data-banquet]').click(function(e) {
            RestaurantManager.banquetPoints(e);
        });
        $('[data-all]').click(function(e) {
            RestaurantManager.allPoints(e);
        });
    };

    this.filterPoints = function() {
        $('.filters button').removeClass('active');
        RestaurantManager.collection.removeAll();
    };

    this.childrenPoints = function(e) {
        RestaurantManager.filterPoints();
        RestaurantManager.arPoints = children_points();
        RestaurantManager.addPoints();
        $(e.target).addClass('active');
    };

    this.musicPoints = function(e) {
        RestaurantManager.filterPoints();
        RestaurantManager.arPoints = music_points();
        RestaurantManager.addPoints();
        $(e.target).addClass('active');
    };

    this.lunchPoints = function(e) {
        RestaurantManager.filterPoints();
        RestaurantManager.arPoints = lunch_points();
        RestaurantManager.addPoints();
        $(e.target).addClass('active');
    };

    this.banquetPoints = function(e) {
        RestaurantManager.filterPoints();
        RestaurantManager.arPoints = banquet_points();
        RestaurantManager.addPoints();
        $(e.target).addClass('active');
    };

    this.allPoints = function(e) {
        RestaurantManager.filterPoints();
        RestaurantManager.arPoints = points();
        RestaurantManager.addPoints();
        $(e.target).addClass('active');
    };

    this.mapInit = function () {
        RestaurantManager.map = new ymaps.Map("map", {
            center: RestaurantManager.center,
            zoom: RestaurantManager.zoom
        }, {
            searchControlProvider: 'yandex#search'
        });
        RestaurantManager.map.controls.add(new ymaps.control.ZoomControl());
        RestaurantManager.map.behaviors.enable('scrollZoom');
        RestaurantManager.arPoints = points();

        RestaurantManager.addPoints();
    };

    this.addPoints = function() {
        RestaurantManager.collection = new ymaps.GeoObjectCollection({});
        RestaurantManager.arPoints.forEach(function (element) {
            RestaurantManager.addPoint(element);
        });

        RestaurantManager.map.geoObjects.add(RestaurantManager.collection);
    };

    this.addPoint = function (element) {
        var marker = RestaurantManager.collection.add(new ymaps.Placemark(element.geo, '', {iconImageHref: point_url, href: '/restaurant/' + element.id + '.html', iconImageSize: [31, 47]}));
     //   if(window.location.pathname == '/restaurants/') {
            marker.events.add('click', function (e) {
                location = e.get('target').options.get('href');
            });
       // }
    };
}