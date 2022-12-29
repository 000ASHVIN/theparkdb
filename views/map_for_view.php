<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>" />
<style>
body {
    display: block;
    margin: 0px;
    font-family: 'Raleway', sans-serif;
}

.pull-right{
    float:right;
}
.pull-left{
    float:left;
}
.clearfix{
    clear:both;
}
.unselected {
    border-radius: 0px;
    height: 35px;
    padding: 10px 24px;
    color: #333;
    background-color: #f3f4f6;
    background-image: none;
    border: 1px solid #cccccc;
    width: 110px;
}
.selected {
    border-radius: 0px;
    background: #3f0c5f;
    height: 35px;
    padding: 10px 24px;
    color: #fff;
    border: 1px solid #89A507;
    width: 110px;
}
.form-group{
    margin-top:10px;
    margin-bottom:0px;
}
.ml-5{
    margin-left:5px;
}

.store_title{
    color: #3f0c5f;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
}
</style>
<link href='https://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic|Raleway:400,700,400italic,500,500italic' rel='stylesheet' type='text/css'>
<div id="google-map" style="height: 350px;width:100%;" ></div>
<div class="clearfix"></div>
<div class="form-group">
 <div class="btn-group pull-left" data-toggle="buttons">
  <label class="btn btn-default active btn-xs btn_toggle">
    <input type="radio" name="options" id="map_distance" value="1" autocomplete="off" checked>Distance
  </label>
  <label class="btn btn-default btn-xs btn_toggle">
    <input type="radio" name="options" id="map_area" value="2" autocomplete="off"> Area 
    </label>
  </div>
  <button class="btn btn-default btn-xs ml-5 reset-map">Reset</button>
  <div class="pull-right">
  <span id="span-result"></span>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
<?php if(@$this->session->userdata("user_ip_address") == 'CN'){ ?>
<script defer type="text/javascript" src="https://maps.google.cn/maps/api/js?libraries=geometry&key=AIzaSyBcf-TCGah732vizLT3ZFiRaeVRo4h8REA&callback=initialize"></script>
<?php } else { ?>
<script defer type="text/javascript" src="https://maps.google.com/maps/api/js?libraries=geometry&key=AIzaSyBcf-TCGah732vizLT3ZFiRaeVRo4h8REA&callback=initialize"></script>
<?php } ?>
<script>
var site_url = '<?php echo site_url(); ?>';
var base_url = '<?php echo base_url(); ?>';
var map;
var kml_full_path;
var measure;
var cLength = 0;
var cArea = 0;
var gmarkers = [];
var kml_file = '<?php echo @$details[0]["attachment"]; ?>';
var lat = '<?php echo @$details[0]["latitude"]; ?>';
var longi = '<?php echo @$details[0]["longitude"]; ?>';
function initialize(){
    //console.log('in');   
    map = new google.maps.Map(document.getElementById('google-map'), {
    mapTypeId: google.maps.MapTypeId.SATELLITE,
    center: new google.maps.LatLng(lat, longi),
    zoom:14,
    draggableCursor: "crosshair"
    });
       
       
    if(kml_file.length>1)
    { 
        //console.log(kml_file);
        kml_full_path = '<?php echo $this->config->item('map_file_path')."/"; ?>'+kml_file;
        loadKmlLayer(kml_full_path, map);
    }
     
	//create gmap latlng obj
	tmpLatLng = new google.maps.LatLng( lat, longi);
     var infowindow =  new google.maps.InfoWindow({content: ''});

   
    
    var store_marker='';
    store_marker += '<div>';
    store_marker += '<div class="store_list_meta">';
    store_marker += "<a href='#'  data-park_id='<?php echo @$details[0]["park_id"]; ?>'  class='store_title'><?php echo @$details[0]["name"]; ?></a>";
    store_marker += '<p class="address">';
    
    if("<?php echo @$details[0]["brand_name"]; ?>") store_marker += "<?php echo @$details[0]["brand_name"]; ?> | "
    if("<?php echo @$details[0]["location"]; ?>") store_marker += "<?php echo @$details[0]["location"]; ?> | "
    if("<?php echo @$details[0]["park_type_name"]; ?>") store_marker += "<?php echo @$details[0]["park_type_name"]; ?>";
    store_marker += '</p>';
    store_marker += '</div>';
    store_marker += '</div>';

    if(kml_file.length<1){//if not kml, show marker
      // make and place map maker.
        var marker = new google.maps.Marker({
            map: map,
            position: tmpLatLng,
            title : "<?php echo @$details[0]["name"]; ?>",
            icon: base_url+'assets/images/marker.png',
        }); 
          bindInfoWindow(marker, map, infowindow, store_marker );
    }
    
    
     
       
    // Create a meausure object to store our markers, MVCArrays, lines and polygons
    measure = {
        mvcLine: new google.maps.MVCArray(),
        mvcPolygon: new google.maps.MVCArray(),
        mvcMarkers: new google.maps.MVCArray(),
        line: null,
        polygon: null
    }; 
     
    google.maps.event.addListener(map, "click", function(evt) {
        placeMarker(evt.latLng);
        // When the map is clicked, pass the LatLng obect to the measureAdd function
        measureAdd(evt.latLng);
    });   
}

function loadKmlLayer(src, map) {
  var kmlLayer = new google.maps.KmlLayer(src, {
    preserveViewport: false,
    map: map
  });
}

function placeMarker(location) {
    var marker = new google.maps.Marker({
        position: location, 
        map: map
    });
    
    gmarkers.push(marker);
}

function removeMarkers(){
    for(i=0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
}

function measureAdd(latLng){

    // Add a draggable marker to the map where the user clicked
    var marker = new google.maps.Marker({
        map: map,
        position: latLng,
        draggable: true,
        raiseOnDrag: false,
        title: "Drag me to change shape",
        //icon: new google.maps.MarkerImage("/images/demos/markers/measure-vertex.png", new google.maps.Size(9, 9), new google.maps.Point(0, 0), new google.maps.Point(5, 5))
    });

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
        //marker.setIcon(new google.maps.MarkerImage("/images/demos/markers/measure-vertex-hover.png", new google.maps.Size(15, 15), new google.maps.Point(0, 0), new google.maps.Point(8, 8)));
    });

    // Change back to the default marker when the user mouses out
    google.maps.event.addListener(marker, "mouseout", function() {
        //marker.setIcon(new google.maps.MarkerImage("/images/demos/markers/measure-vertex.png", new google.maps.Size(9, 9), new google.maps.Point(0, 0), new google.maps.Point(5, 5)));
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
                strokeColor: "#FFCA33",
                strokeOpacity: 1,
                strokeWeight: 3,
                path:measure. mvcLine
            });

        }

        // If there is more than two vertexes for a polygon
        if (measure.mvcPolygon.getLength() > 2 && $(".btn_toggle.active").find('input').val()==2 ) {

            // If the polygon hasn't been created yet
            if (!measure.polygon) {

                // Create the polygon (google.maps.Polygon)
                measure.polygon = new google.maps.Polygon({
                    clickable: false,
                    map: map,
                    fillColor: "#00ff00",
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
        cLength = length.toFixed(1);
        if($(".btn_toggle.active").find('input').val()==1)
        $("#span-result").text('Distance: '+numeral(parseInt(cLength)).format('0,0')+' m');

    // If we have a polygon (>2 vertexes in the mvcPolygon MVCArray)
    if (measure.mvcPolygon.getLength() > 2) {
        // Use the Google Maps geometry library to measure the area of the polygon
        var area = google.maps.geometry.spherical.computeArea(measure.polygon.getPath());
        cArea = area.toFixed(1);
        if($(".btn_toggle.active").find('input').val()==2)
        $("#span-result").text('Area: '+numeral(parseInt(cArea)).format('0,0')+' sqm');
  
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
    
    $("#span-length,#span-area").text(0);

}

$(document).on('click','.btn_toggle',function(){
    cLength = 0;
    cArea = 0;
    measureReset();
    removeMarkers();
   if($(this).find('input').val() == 1){
    $("#span-result").text('Distance: '+cLength+' m');
   }
   else{
    $("#span-result").text('Area: '+cArea+' sqm');
   }  
});

$(document).on('click','.reset-map',function(){
    cLength = 0;
    cArea = 0;
    measureReset();
    removeMarkers();
    $('.btn_toggle.active').trigger('click');
   
});

// binds a map marker and infoWindow together on click
var bindInfoWindow = function(marker, map, infowindow, html) {
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(html);
        infowindow.open(map, marker);
     });
} 
//measureReset();
</script>  