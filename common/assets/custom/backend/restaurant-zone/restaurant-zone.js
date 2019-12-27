ymaps.ready(function () {
    var myMap = new ymaps.Map('map', {
        center: [55.751574, 37.573856],
        zoom: 9
    });

    if(zone !== ''){
        var myPolygon = new ymaps.Polygon(JSON.parse(zone), {}, {
            editorDrawingCursor: "crosshair",
            editorMaxPoints: 100,
            fillColor: 'rgba( 255, 0, 0, 0.5)',
            strokeColor: 'rgba( 255, 0, 0, 0.5)',
            strokeWidth: 5
        });

    }else{
        myPolygon = new ymaps.Polygon([], {}, {
            editorDrawingCursor: "crosshair",
            editorMaxPoints: 100,
            fillColor: 'rgba( 255, 0, 0, 0.5)',
            strokeColor: 'rgba( 255, 0, 0, 0.5)',
            strokeWidth: 5
        });
    }

    myMap.geoObjects.add(myPolygon);

    var stateMonitor = new ymaps.Monitor(myPolygon.editor.state);
    stateMonitor.add("drawing", function (newValue) {
        myPolygon.options.set("strokeColor", newValue ? '#FF0000' : '#FF0000');
    });

    myPolygon.editor.events.add('click', function(e){
        console.log(e.get('coords'));    
    });

    myPolygon.editor.startDrawing();
 
    $('#add-restaurant-zone').on('click', function(e){
        $('#restaurantzoneform-zone').val(myPolygon.geometry.getCoordinates()); 
    });
});