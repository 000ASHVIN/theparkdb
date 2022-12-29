<div class="row" style="margin-top: 200px;">
<div class="col-lg-12">
<button class="btn btn-default" class="pull-left" id="reset">Reset</button>
<div class="pull-right">
Length (red line): <span id="span-length"></span> mt - Area (grey area): <span id="span-area"></span> Meter Square
</div>
</div>
<div class="col-lg-12">
<div id="map" style="width:80%; height:500px;"></div>
</div>
</div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyBcf-TCGah732vizLT3ZFiRaeVRo4h8REA&"></script>
<script>
var map;

// Create a meausure object to store our markers, MVCArrays, lines and polygons
var measure = {
    mvcLine: new google.maps.MVCArray(),
    mvcPolygon: new google.maps.MVCArray(),
    mvcMarkers: new google.maps.MVCArray(),
    line: null,
    polygon: null
};

// When the document is ready, create the map and handle clicks on it
jQuery(document).ready(function() {

    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: new google.maps.LatLng(39.57592, -105.01476),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        draggableCursor: "crosshair" // Make the map cursor a crosshair so the user thinks they should click something
    });

    google.maps.event.addListener(map, "click", function(evt) {
        // When the map is clicked, pass the LatLng obect to the measureAdd function
        measureAdd(evt.latLng);
    });

});


function measureAdd(latLng) {

    // Add a draggable marker to the map where the user clicked
    var marker = new google.maps.Marker({
        map: map,
        position: latLng,
        draggable: true,
        raiseOnDrag: false,
        title: "Drag me to change shape",
        icon: new google.maps.MarkerImage("/images/demos/markers/measure-vertex.png", new google.maps.Size(9, 9), new google.maps.Point(0, 0), new google.maps.Point(5, 5))
    });

    // Add this LatLng to our line and polygon MVCArrays
    // Objects added to these MVCArrays automatically update the line and polygon shapes on the map
    measure.mvcLine.push(latLng);
    measure.mvcPolygon.push(latLng);

    // Push this marker to an MVCArray
    // This way later we can loop through the array and remove them when measuring is done
    measure.mvcMarkers.push(marker);

    // Get the index position of the LatLng we just pushed into the MVCArray
    // We'll need this later to update the MVCArray if the user moves the measure vertexes
    var latLngIndex = measure.mvcLine.getLength() - 1;

    // When the user mouses over the measure vertex markers, change shape and color to make it obvious they can be moved
    google.maps.event.addListener(marker, "mouseover", function() {
        marker.setIcon(new google.maps.MarkerImage("/images/demos/markers/measure-vertex-hover.png", new google.maps.Size(15, 15), new google.maps.Point(0, 0), new google.maps.Point(8, 8)));
    });

    // Change back to the default marker when the user mouses out
    google.maps.event.addListener(marker, "mouseout", function() {
        marker.setIcon(new google.maps.MarkerImage("/images/demos/markers/measure-vertex.png", new google.maps.Size(9, 9), new google.maps.Point(0, 0), new google.maps.Point(5, 5)));
    });

    // When the measure vertex markers are dragged, update the geometry of the line and polygon by resetting the
    //     LatLng at this position
    google.maps.event.addListener(marker, "drag", function(evt) {
        measure.mvcLine.setAt(latLngIndex, evt.latLng);
        measure.mvcPolygon.setAt(latLngIndex, evt.latLng);
    });

    // When dragging has ended and there is more than one vertex, measure length, area.
    google.maps.event.addListener(marker, "dragend", function() {
        if (measure.mvcLine.getLength() > 1) {
            measureCalc();
        }
    });

    // If there is more than one vertex on the line
    if (measure.mvcLine.getLength() > 1) {

        // If the line hasn't been created yet
        if (!measure.line) {

            // Create the line (google.maps.Polyline)
            measure.line = new google.maps.Polyline({
                map: map,
                clickable: false,
                strokeColor: "#FF0000",
                strokeOpacity: 1,
                strokeWeight: 3,
                path:measure. mvcLine
            });

        }

        // If there is more than two vertexes for a polygon
        if (measure.mvcPolygon.getLength() > 2) {

            // If the polygon hasn't been created yet
            if (!measure.polygon) {

                // Create the polygon (google.maps.Polygon)
                measure.polygon = new google.maps.Polygon({
                    clickable: false,
                    map: map,
                    fillOpacity: 0.25,
                    strokeOpacity: 0,
                    paths: measure.mvcPolygon
                });

            }

        }

    }

    // If there's more than one vertex, measure length, area.
    if (measure.mvcLine.getLength() > 1) {
        measureCalc();
    }

}

function measureCalc() {

    // Use the Google Maps geometry library to measure the length of the line
    var length = google.maps.geometry.spherical.computeLength(measure.line.getPath());
    jQuery("#span-length").text(length.toFixed(1))

    // If we have a polygon (>2 vertexes in the mvcPolygon MVCArray)
    if (measure.mvcPolygon.getLength() > 2) {
        // Use the Google Maps geometry library to measure the area of the polygon
        var area = google.maps.geometry.spherical.computeArea(measure.polygon.getPath());
        jQuery("#span-area").text(area.toFixed(1));
    }

}

function measureReset() {

    // If we have a polygon or a line, remove them from the map and set null
    if (measure.polygon) {
        measure.polygon.setMap(null);
        measure.polygon = null;
    }
    if (measure.line) {
        measure.line.setMap(null);
        measure.line = null
    }

    // Empty the mvcLine and mvcPolygon MVCArrays
    measure.mvcLine.clear();
    measure.mvcPolygon.clear();

    // Loop through the markers MVCArray and remove each from the map, then empty it
    measure.mvcMarkers.forEach(function(elem, index) {
        elem.setMap(null);
    });
    measure.mvcMarkers.clear();

    jQuery("#span-length,#span-area").text(0);

}

$(document).on('click','#reset',function(){
    measureReset();
});
</script>