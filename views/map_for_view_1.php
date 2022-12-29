<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>" />
<link rel="stylesheet" href="https://openlayers.org/en/v3.20.1/css/ol.css" type="text/css">

<div id="map" class="map" style="height: 350px;width:100%;" ></div>
<div style="display: none;">
    <div id="marker" title="Marker"><img src="<?php echo base_url('assets/images/marker.png'); ?>" /></div>
</div>
<div id="info">&nbsp;</div>
<div class="clearfix"></div>

<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
<script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
<script src="https://openlayers.org/en/v3.20.1/build/ol.js"></script>
<script>
var site_url = '<?php echo site_url(); ?>';
var base_url = '<?php echo base_url(); ?>';
var map;
var myFullScreenControl;
var kml_full_path;
var measure;
var cLength = 0;
var cArea = 0;
var gmarkers = [];
var kml_file = '<?php echo @$details[0]["attachment"]; ?>';
var lat = <?php echo @$details[0]["latitude"]; ?>;
var longi = <?php echo @$details[0]["longitude"]; ?>;

    if(kml_file.length>1)
    { 
      kml_full_path = '<?php echo $this->config->item('map_file_path')."/"; ?>'+kml_file;
      //var projection = ol.proj.get('EPSG:3857');

      var raster = new ol.layer.Tile({
        source: new ol.source.OSM()
      });

      var vector = new ol.layer.Vector({
        source: new ol.source.Vector({
          url: kml_full_path,
          format: new ol.format.KML()
        })
      });

      var map = new ol.Map({
        layers: [raster, vector],
        target: document.getElementById('map'),
        view: new ol.View({
          center: ol.proj.transform([longi, lat], 'EPSG:4326', 'EPSG:3857'),
          //projection: projection,
          zoom: 10
        })
      });

      var displayFeatureInfo = function(pixel) {
        var features = [];
        map.forEachFeatureAtPixel(pixel, function(feature) {
          features.push(feature);
        });
        if (features.length > 0) {
          var info = [];
          var i, ii;
          for (i = 0, ii = features.length; i < ii; ++i) {
            info.push(features[i].get('name'));
          }
          document.getElementById('info').innerHTML = info.join(', ') || '(unknown)';
          map.getTarget().style.cursor = 'pointer';
        } else {
          document.getElementById('info').innerHTML = '&nbsp;';
          map.getTarget().style.cursor = '';
        }
      };

      map.on('pointermove', function(evt) {
        if (evt.dragging) {
          return;
        }
        var pixel = map.getEventPixel(evt.originalEvent);
        displayFeatureInfo(pixel);
      });

      map.on('click', function(evt) {
        displayFeatureInfo(evt.pixel);
      });

    }else{
        var map = new ol.Map({
            target: 'map',
            renderer: 'canvas',
            layers: [
                new ol.layer.Tile({source: new ol.source.OSM()})
            ],
            view: new ol.View({
                //projection: 'EPSG:900913',
                center: ol.proj.transform([longi, lat], 'EPSG:4326', 'EPSG:3857'),
                zoom: 10
            })
     
        });
        
        var marker = new ol.Overlay({
            position: ol.proj.transform(
                    [longi, lat],
                    'EPSG:4326',
                    'EPSG:3857'
                    ),
            positioning: 'center-center',
            element: document.getElementById('marker'),
            stopEvent: false
          });
          map.addOverlay(marker);
    }


</script>  