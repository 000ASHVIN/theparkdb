<?php
$image_path = $this->config->item('logo_image');
$flag = 0;
$filterKeyword = (@$keyword_data["filterKeyword"]) ? addslashes($keyword_data["filterKeyword"]) : 0;
$filterType = (@$keyword_data["filterType"]) ? addslashes($keyword_data["filterType"]) : 0;
$latitude = (@$keyword_data[0]["latitude"]) ? $keyword_data[0]["latitude"] : 40.785611;
$longitude = (@$keyword_data[0]["longitude"]) ? $keyword_data[0]["longitude"] : -13.946056;
$geo_type = @$keyword_data[0]["geo_type_1"];


if ($filterType == 'name') {
  $mapZoom = 6;
} else if ($filterType == 'location') {
  $mapZoom = 10;
} else if ($filterType == 'country') {
  $mapZoom = 4;
} else if ($filterType == 'continent') {
  $mapZoom = 3;
} else $mapZoom = 2;
?>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<style>
  
  .left{
    position: relative;
  }
  .content {
      position: absolute;
      bottom: 0; 
      background: rgba(0, 0, 0, 0.7); 
      color: #f1f1f1; 
      width: 100%;
      padding: 20px;
      padding-bottom: 50px;
    }
    #park-list{
      height:655px;
    }
    .form-control{
      height: 45px;
    }
    .btnsign{
      color: black;
      background-color: #ffe431;
    }
    /* @media only screen and(min-width: 1200px){
      .form-control{
        max-width: 30%;
      }
    }
    @media only screen and(min-width: 992px){
      .form-control{
        max-width: 30%;
      }
    }
    @media only screen and(min-width: 768px){
      .form-control{
        max-width: 30%;
      }
    } */
    .d-flex {
      display: flex;
      gap: 10px;
    }
    .modal-dialog-centered {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    @media only screen and (min-width: 768px){
      .modal-content {
        width: 600px;
      }
    }
    .modal-dialog {
      margin: 0 auto;
    }
    .sign-up .modal-body {
      background-image: url('<?php echo base_url('assets/images/search_bg.jpg') ?>');
      background-size: cover;
      min-height: 400px;
      background-position: center;
    }
    .sign-up .parks-info {
      display: flex;
      justify-content: center;
      gap: 20px;
      color: #fff;
      font-size: 12px;
      margin-top: 10px;
    }
    .sign-up .title {
      color: #fff;
    }
    .sign-up .form {
      width: 70%;
      margin: auto;

    }
    .sign-up input {
        font-weight: bold;
    }
    .ride_holder {
      position: relative;
    }
    .view-park-content {
      position: absolute;
      bottom: 0; 
      background: rgba(0, 0, 0, 0.7); 
      color: #f1f1f1; 
      width: 100%;
      padding: 20px;
      padding-bottom: 50px;
    }
    .sorter_dd_holder {
      width: 220px;
    }
    .sort_dir_trigger {
      cursor: auto;
    }
</style>
<div class="clearfix"></div>
<section id="other_page_search_area">
  <div class="container">
    <div class="col-md-offset-3 col-md-6">
      <div class="search-form-wrapper">
        <form class="form-inline" id="sub_form" role="form">
          <div class="input-group">
            <input autofocus="true" type="search" id="searchbox" class="form-control ui-autocomplete-input" value="<?php if ($filterKeyword) echo $filterKeyword; ?>" name="search" placeholder="Search for a park, type, country or region" autocomplete="off">
            <div class="input-group-btn">
              <button type="submit" class="btn-submit"><i class="glyphicon glyphicon-search"></i></button>
            </div><!-- /btn-group -->
          </div>
          <small class="result-count"></small>
        </form>
      </div>
    </div>
  </div>
</section>
<section id="map_list_wrapper">
  <div class="col-md-offset-3 col-md-6" id="related_articles" style="display: none;">
    <div class="col-md-6 text-right">
      <p>You might be interested in:</p>
    </div>
    <div class="col-md-6">
      <ul id="related_list"></ul>
    </div>
  </div>
  <?php if (@$this->session->userdata("user_ip_address") == 'CN' || isMobile()) echo '<div class="container">'; ?>
  <div class="left" <?php if (@$this->session->userdata("user_ip_address") == 'CN' || isMobile()) echo 'style="width:100%;margin:auto;"'; ?>>
    <div class="filter-access">
      <div class="pull-left fa-l">
        <div class="sorting-options">
          <div class="col-md-9 col-xs-1 sorter_dd_holder">
            <div class="select-box type-2 filter-block-item">
              <input name="sort_key" id="short_key" class="js-input no-select" type="hidden" value="" />
              <input name="sort_key" id="short_key_id" class="js-input no-select" type="text" readonly value="" placeholder="SORT BY" />
              <ul>
                <li>Attendance (High - Low)</li>
                <li>Attendance (Low - High)</li>
                <li>Est. Value (High - Low)</li>
                <li>Est. Value (Low - High)</li>
              </ul>
            </div>
          </div>
          <div class="col-md-1 col-xs-1 dir">
            <input name="sort_direction" id="sort_direction" type="hidden" readonly value="DESC" />
            <span class="btn btn-default sort_dir_trigger"><i class="fa fa-sort-amount-desc"></i></span>

          </div>
          <div class="col-md-5 col-xs-3 filter">
            <div class="select-box type-2 park_types_holder">
              <select class="form-control" id="park_types" name="types[]" multiple="true" class="types">
                <option value="5">Theme park</option>
                <option value="6">Indoor Park</option>
                <option value="7">Waterpark</option>
                <option value="-1">Others</option>
              </select>

            </div>
          </div>
          <button class="btn btn-default pull-right reset_filters visible-xs mob_rf"><i class="fa fa-remove"></i></button>
        </div>

      </div>
      <button class="btn btn-default pull-right reset_filters hidden-xs">RESET FILTERS </button>
      <div class="clearfix"></div>
    </div>

    <div id="park-list-loader"><img src="<?php echo base_url('assets/images/ripple.gif'); ?>" /> Loading.... </div>
    <div id="park-list" <?php if (@$this->session->userdata("user_ip_address") == 'CN' || isMobile()) echo 'style="height:auto;"'; ?>>
    </div>
    <?php if(!($this->session->userdata('user') && $this->session->userdata('user')['logged_in'])) { ?>
      <div class="content" style="display: none;">
        <h3>View all <span class="park_count">0</span> results from this search</h3>
        <p>When you  create a free TheParkDatabase account you get unlimited access to over 4,000 theme parks and attractions,with new locations added every week.</p>
        <!-- <div class="d-inline">
          <input type="email" name="email" id="email" class="email" >
          <button type="submit" class="btnsign"><strong>SIGNUP FOR FREE</strong></button>
        </div> -->
        <div class="row">
          <div class="col-sm-8">
              <div class="d-flex">
                <input type="email" class="form-control" placeholder="Enter your email address">
                <button class="btn btnsign btn-warning" type="button" data-toggle="modal" data-target="#exampleModalCenter"><strong>SIGNUP FOR FREE</strong></button>
              </div>
          </div>
          
        </div>
      </div>
    <!-- Modal -->
    <?php } ?>

  </div>
  <?php if (@$this->session->userdata("user_ip_address") == 'CN' || isMobile()) echo '</div>'; ?>
  <?php if (@$this->session->userdata("user_ip_address") != 'CN' && !isMobile()) { ?>
    <div class="right">
      <div id="map-canvas" class="search_map">
        <div><img src="<?php echo base_url('assets/images/ripple.gif'); ?>" /> Loading.... </div>
      </div>
    </div>
  <?php } ?>
  <div class="clearfix"></div>
</section>

<div class="modal fade" id="view_park" tabindex="-2" role="dialog">
  <div class="modal-dialog">
    <div itemscope itemtype="http://schema.org/TouristAttraction" class="modal-content">

      <?php
      if ($park_id) {
        $data['details'] = $this->Results_model->view_park($park_id);
        $data['rides'] = $this->Results_model->get_rides($park_id);
        $data['tickets'] = $this->Results_model->get_tickets($park_id);
        $data['atts'] = $this->Results_model->get_att($park_id);
        $data['misc'] = $this->Results_model->get_misc_info($park_id, $data['details'][0]["brand_id"]);
        $data["ppp"] = $this->Results_model->get_ppp_rates($data['details'][0]["country_id"]);
        if (@$data['details'][0]["park_code"])
          $data["related"] = $this->Results_model->get_related_articles($data['details'][0]["park_code"]);
        if (strlen($data["details"][0]["wikipedia_name"]) > 0)
          $data["wiki_name"] = $data["details"][0]["wikipedia_name"];
        else
          $data["wiki_name"] = str_replace(' ', '_', $data['details'][0]["name"]);
        $data["no_js"] = 1;
        $this->load->view('view_park', $data);
      }
      ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="email_sub" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <img src="<?php echo base_url('assets/images/sticker.png') ?>" class="sticker" />
        <form name="email_sub_form" id="email_sub_form">
          <div class="email_sub_heading">
            Stay informed of <br />
            our latest updates!
          </div>
          <div class="alert_area"></div>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Enter your e-mail">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit">SIGN UP</button>
            </span>
          </div><!-- /input-group -->
          <div class="promise">
            <i class="fa fa-lock"></i>We promise to keep your e-mail safe and not to spam!
          </div>
          <p class="close-email-sub text-center" data-dismiss="modal" aria-label="Close">
            Close POP-UP <i class="fa fa-times-circle"></i>
          </p>
        </form>

      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="sign-up modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        
        <div class="modal-body">
          <div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="text-center title">
            <h3>Sign Up</h3>
            <p>Unlimited access to The Park Database</p>
          </div>
          <div class="form">
            <form method="post" action="<?php echo site_url('Login/process'); ?>">
              <div class="form-group">
                <input type="text" name="full_name" class="form-control" id="full_name" placeholder="Full name" required>
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
              </div>
              <div class="form-group">
                <input type="text" name="company" class="form-control" id="company" placeholder="Company" required>
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
              </div>

              <div class="text-center">
                <button type="submit" class="btn btn-warning btnsign">SIGNUP FOR FREE</button>
              </div>
            </form>
          </div>
          <div class="parks-info">
            <span>4000+ Parks & attractions</span>
            <span>Unlimited searches</span>
            <span>100% free</span>
          </div>
        </div>

      </div>
    </div>
</div>


<script src="<?php echo base_url('assets/js/jquery.mask.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.mCustomScrollbar.concat.min.js'); ?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
<?php if (@$this->session->userdata("user_ip_address") != 'CN' && !isMobile()) { ?>
  <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBcf-TCGah732vizLT3ZFiRaeVRo4h8REA"></script>
<?php } ?>
<script src="<?php echo base_url('assets/js/masonry.pkgd.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/imagesloaded.pkgd.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.multiselect.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/results.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/all_suggestions.js'); ?>"></script>

<!---search---->
<script>
  var loadMap = true;
  <?php if (@$this->session->userdata("user_ip_address") == 'CN' || isMobile()) { ?>
    loadMap = false;
  <?php } ?>
  var searchKeyword = '<?php echo $filterKeyword; ?>';
  var keywordType = '<?php echo $filterType; ?>';
  var markers = [];
  var map;
  var mapZoom = <?php echo $mapZoom; ?>;
  var mapLat = <?php echo $latitude; ?>;
  var mapLng = <?php echo $longitude; ?>;
  var data;
  var parkID = <?php echo ($park_id) ? $park_id : 0;  ?>;
  var site_url = '<?php echo site_url(); ?>';
  var base_url = '<?php echo base_url(); ?>';
  var processing = 0;
  var filterChanged = 0;
  var bounds;
  var first = 1;
  var geo_type = '<?php echo $geo_type; ?>';
  var sw_lat = 0;
  var sw_long = 0;
  var ne_lat = 0;
  var ne_long = 0;


  function filterParks(activity) {

    if (processing == 1) return false;
    else processing = 1;

    if (keywordType == 'country_name') keywordType = 'country';
    if (keywordType == 'continent_name') keywordType = 'continent';
    if (keywordType == 'park_type_name') keywordType = 'park_type';
    if (keywordType == 'brand_name') keywordType = 'brand';
    $("#park-list-loader").show();
    $('#mCSB_1_container').empty();


    if (activity == 'zoom_changed' || activity == 'dragend') {
      $('#searchbox').val('');
    }

    //re-adjust map accoding to new search
    if (keywordType == 'name')
      mapZoom = 12;
    else if (keywordType == 'location') {
      if (geo_type == 'administrative_area_level_1')
        mapZoom = 7;
      else
        mapZoom = 10;
    } else if (keywordType == 'country')
      mapZoom = 4;
    else if (keywordType == 'continent')
      mapZoom = 4;
    else { //set default zoom and co-ordinates
      mapZoom = 2;
      mapLat = 40.785611;
      mapLng = -13.946056;
    }

    var sData = {
      "filter_keyword": searchKeyword,
      "filter_type": keywordType,
      "lat": mapLat,
      "long": mapLng
    };



    if (first == 1) {

      if (loadMap) map.setCenter(new google.maps.LatLng(mapLat, mapLng));
      if (loadMap) map.setZoom(mapZoom);

      if (keywordType == 'location' && loadMap) {

        bounds = map.getBounds();
        var ne = bounds.getNorthEast();
        var sw = bounds.getSouthWest();
        sData.bounds = {
          'sw': [sw.lat(), sw.lng()],
          'ne': [ne.lat(), ne.lng()]
        };

        sw_lat = sData.bounds['sw'][0];
        sw_long = sData.bounds['sw'][1];
        ne_lat = sData.bounds['ne'][0];
        ne_long = sData.bounds['ne'][1];

        if (sData.bounds['ne'][1] < 0 && ((sData.bounds['sw'][0] <= 0 && sData.bounds['sw'][0] >= -90) && sData.bounds['sw'][1] >= 0 && sData.bounds['sw'][1] <= 180)) {
          sData.bounds['ne'][1] = 180;
          ne_long = 180;
        }

      }
    } else {

      if (loadMap) {
        bounds = map.getBounds();
        var ne = bounds.getNorthEast();
        var sw = bounds.getSouthWest();

        sData.bounds = {
          'sw': [sw.lat(), sw.lng()],
          'ne': [ne.lat(), ne.lng()]
        };
        sw_lat = sData.bounds['sw'][0];
        sw_long = sData.bounds['sw'][1];
        ne_lat = sData.bounds['ne'][0];
        ne_long = sData.bounds['ne'][1];

        if (sData.bounds['ne'][1] < 0 && ((sData.bounds['sw'][0] <= 0 && sData.bounds['sw'][0] >= -90) && sData.bounds['sw'][1] >= 0 && sData.bounds['sw'][1] <= 180)) {
          sData.bounds['ne'][1] = 180;
          ne_long = 180;
        }
      }
    }

    /*if(sData.bounds['sw'][1] > sData.bounds['ne'][1]){
      sData.sData.bounds['ne'][1] = sData.sData.bounds['ne'][1]*(-1);
    }*/
    //console.log(sData.bounds);
    clearMarkers();



    if (filterChanged == 1) { //only filters are changed no need to get parks from server side.
      initialize();
      processing = 0;
      $("#park-list-loader").hide();
      return false;
    }



    $.ajax({
      url: "<?php echo site_url('results/getParks') ?>",
      dataType: "json",
      type: 'POST',
      data: sData,
      success: function(results) {
        if (results.status == '1') {
          data = results;
          ppp = data.ppp;
          showResultCount(results.parks.length);

          if (typeof data.keyword_data != 'undefined') {
            if (data.keyword_data[0].type == 'name')
              mapZoom = 14;
            else if (data.keyword_data[0].type == 'location') {
              mapZoom = 10;
              mapLat = (data.keyword_data[0].latitude) ? data.keyword_data[0].latitude : 40.785611;
              mapLng = (data.keyword_data[0].longitude) ? data.keyword_data[0].longitude : -13.946056;
            } else if (data.keyword_data[0].type == 'country_name')
              mapZoom = 4;
            else if (data.keyword_data[0].type == 'continent_name')
              mapZoom = 4;
            else { //set default zoom and co-ordinates
              mapZoom = 2;
              mapLat = 40.785611;
              mapLng = -13.946056;
            }
          } else {
            if (keywordType == 'name')
              mapZoom = 14;
            else if (keywordType == 'location')
              mapZoom = 10;
            else if (keywordType == 'country')
              mapZoom = 4;
            else if (keywordType == 'continent')
              mapZoom = 4;
            else { //set default zoom and co-ordinates
              mapZoom = 2;
              mapLat = 40.785611;
              mapLng = -13.946056;
            }
          }
          initialize();

          $('.park_count').html(results.park_count)
        } else {
          data = results;
          initialize();
          showResultCount(0);
        }

        $("#park-list-loader").hide();
        processing = 0;
        first = 0;
      }
    });

  }


  function initialize() {

    add_map_components();
    if (loadMap) {
      $("#park-list").mCustomScrollbar({
        theme: "dark",
        advanced: {
          autoScrollOnFocus: false,
          updateOnContentResize: true
        }
      });
    }
    $('.result-count').empty().html('Total ' + data.parks.length + ' results found');
    check_related();
  }

  function check_related() {
    if (first == 1) {

      var sData = {
        "filter_keyword": searchKeyword,
        "filter_type": keywordType,
        "lat": mapLat,
        "long": mapLng
      };

      $.ajax({
        url: "<?php echo site_url('results/getRelated') ?>",
        dataType: "json",
        type: 'POST',
        data: sData,
        success: function(result) {
          if (result.status == 1) {
            $('#related_list').empty();
            $.each(result.data, function(k, v) {
              $('#related_list').append('<li><a href="' + v.link + '" target="_blank">' + v.title + '</a></li>');
            });
            $('#related_articles').slideDown();
          } else {
            $('#related_list').empty();
            $('#related_articles').slideUp('fast');
          }
        }
      });
    }
  }


  $(document).ready(function() {

    //reset all filters
    $('.reset_filters').click(function() {
      $("#park_types").multiselect("uncheckAll");
      $('.park_types_holder button span:nth-child(2)').html('ALL Types');

      $('#short_key_id').attr('value', 'SORT BY');
      $('#sort_direction').attr('value', 'DESC');


      add_map_components();
    });

    if (loadMap) {
      latlngCenter = new google.maps.LatLng(mapLat, mapLng);
      mapOptions = {
        zoom: mapZoom,
        center: latlngCenter,
        mapType: 'roadmap',
        scrollwheel: false,
      }

      map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
      google.maps.event.addListener(map, 'dragend', function() {
        filterParks('dragend');
        // $('#searchbox').val('');
      });
      google.maps.event.addListener(map, 'zoom_changed', function() {
        filterParks('zoom_changed');
      });
      google.maps.event.addListenerOnce(map, 'idle', function() {
        filterParks('idle');
        //$('#searchbox').val('');
      });
    } else {
      filterParks('idle');
    }


    // multitselect park_types
    $("#park_types").multiselect({
      header: false,
      close: function(e) {
        if ($(this).multiselect("widget").find("input:checked").length == 0) {
          $('.park_types_holder button span:nth-child(2)').html('ALL Types');
        }
      }
    });
    $('.park_types_holder button span:nth-child(2)').html('ALL Types');

    $('#park_types, #short_key_id, #sort_direction').change(function() {
      console.log('done')
      var value = '';
      if($(this).val() == 'Attendance (High - Low)') {
        $('#short_key').val('ATTENDANCE');
        $('#sort_direction').val('DESC')
      } else if($(this).val() == 'Attendance (Low - High)') {
        $('#short_key').val('ATTENDANCE');
        $('#sort_direction').val('ASC')
      } else if($(this).val() == 'Est. Value (High - Low)') {
        $('#short_key').val('EST. VALUE');
        $('#sort_direction').val('DESC')
      } else if($(this).val() == 'Est. Value (Low - High)') {
        $('#short_key').val('EST. VALUE');
        $('#sort_direction').val('ASC')
      }

      var current = $('#sort_direction').val();
      if (current == 'DESC') {
        $('.sort_dir_trigger i').removeClass('fa-sort-amount-desc').addClass('fa-sort-amount-asc');
      } else {
        $('.sort_dir_trigger i').removeClass('fa-sort-amount-asc').addClass('fa-sort-amount-desc');
      }

      add_map_components();
    });


    // $('.sort_dir_trigger').click(function() {
    //   var current = $('#sort_direction').val();
    //   if (current == 'DESC') {
    //     $('#sort_direction').val('ASC');
    //     $('.sort_dir_trigger i').removeClass('fa-sort-amount-desc').addClass('fa-sort-amount-asc');
    //   } else {
    //     $('#sort_direction').val('DESC');
    //     $('.sort_dir_trigger i').removeClass('fa-sort-amount-asc').addClass('fa-sort-amount-desc');
    //   }
    //   $('#sort_direction').trigger('change');

    // });


  }); // ready

  $(document).on('click', '.show_charts', function(e) {
    e.preventDefault();
    if (keywordType == 'name') {
      alert('Charts can\'t be generated for a single park.');
      return false;
    }
    top.location.href = site_url + "/charts/" + keywordType + "/" + encodeURIComponent(searchKeyword) + "/" + sw_lat + "/" + sw_long + "/" + ne_lat + "/" + ne_long;
  });

  $(document).ajaxStart(function() {
    Pace.restart();
  });

  $(document).ready(function(){
    $('.content').show();
  })
</script>
<div class="clearfix"></div>