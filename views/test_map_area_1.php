<!doctype html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="http://openlayers.org/en/v3.2.1/css/ol.css" type="text/css">
    <style>
      .map {
        height: 400px;
        width: 100%;
      }
    </style>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="http://openlayers.org/en/v3.2.1/build/ol.js" type="text/javascript"></script>
    <title>OpenLayers 3 example</title>
  </head>
  <body>
    <h2>My Map</h2>
    <div id="map" class="map"></div>
    
    <script>
    var base_url = '<?php echo base_url(); ?>';
    var marker_image = base_url+'assets/images/marker.png';
    var map = new ol.Map({
        target: 'map',
        renderer: 'canvas',
        layers: [
            new ol.layer.Tile({source: new ol.source.OSM()})
        ],
        view: new ol.View({
            //projection: 'EPSG:900913',
            center: ol.proj.transform([120.31231300, 29.15163200], 'EPSG:4326', 'EPSG:3857'),
            zoom: 10
        })
 
    });
    
    
    
    //Full Screen
    /*var myFullScreenControl = new ol.control.FullScreen();
    map.addControl(myFullScreenControl);
 
    map.addOverlay(new ol.Overlay({
        position: ol.proj.transform(
                [120.31231300, 29.15163200],
                'EPSG:4326',
                'EPSG:3857'
                ),
        element: $('<img src="'+marker_image+'">')
    }));*/
 
    /*map.on('singleclick', function(evt) {
        var coord = evt.coordinate;
        var transformed_coordinate = ol.proj.transform(coord, "EPSG:900913", "EPSG:4326");
        console.log(transformed_coordinate);
    });*/
     
 
</script>
 
  </body>
</html>