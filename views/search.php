<style>
.gm-style .gm-style-iw {
    font-weight: 200;
    font-size: 12px;
    line-height: 14px;
    overflow: hidden;
    font-family:Montserrat;
}
</style>
<!-- Main Content -->
		<div class="content-wrapper">
			<section class="properties-filters">
				
				  
						<div class="container">
                        <div class="row">
                        <div class="col-md-6">
                                <div class="filter-block-item city">
											<div class="select-box type-2">
												<input class="js-input no-select" id="base" type="text" readonly value="SIZE" placeholder="SIZE" />
												<ul>
													<li>SIZE</li>
													<li>ATTENDANCE</li>
													<li>CAPACITY</li>
                                                    <li>REVENUES</li>
                                                </ul>
											</div>
										</div>
         	             </div>
      <div class="col-md-12">
      <form id="search_form">
      <div class="input-group">
       <input type="search" id="searchbox" class="form-control" name="search" placeholder="SEARCH" />
       <div class="input-group-btn">
          <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-search"></i></button>
	   </div><!-- /btn-group -->
      </div>
      </form>
      </div>
      <div class="col-md-24 col-lg-24">
      <div class="result-count">
      
      </div>
      </div>
      </div>
	 </div>
                    
			
			</section>
           
            	<section class="">
				<div class="container">
					<div class="row">
						<div class="col-lg-24 col-md-24">
                        <br />
						<div id="map" style="width:100%; height: 600px;"></div>
						</div>
                    </div>
				</div>
			</section>
 </div><!--./wrapper-->
 
<!---search---->
<script>
var searchKeyword = 0;
var keywordType = 0;
$(document).ready(function() {
var autoComplete = $( "#searchbox" ).autocomplete({
                 //autoFocus: true,
                 minLength: 3,
                    source: function(request, response) {
                              $.ajax({
                               url: '<?php echo site_url('search/suggetions');?>',
                               data: request,
                               dataType: "json",
                               type: "POST",
                               success: function(data){
                                     response(data);  
                                }
                               });
                             },
               
                    select: function(event, ui) {
                             event.preventDefault();
                             searchKeyword = ui.item.keyword;
                             keywordType = ui.item.type;
                             filterParks();
                            },
                     focus: function (event, ui) {
                             event.preventDefault();
                             $('input#searchbox').val(ui.item.keyword);
                            }
                           });
                    autoComplete.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
                                 var inner_html = '';
                                 if(item.no_results){// no result found
                                 inner_html ='<a id="ui-id-3" class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.message+'</div></a>';
                                 }
                                 else{
                                 var subtitle = 'Park';
                                 if(item.type == 'name')
                                 subtitle = 'Park';
                                 if(item.type == 'brand_name')
                                 subtitle = 'Brand';
                                 if(item.type == 'country_name')
                                 subtitle = 'Country';
                                 if(item.type == 'park_type_name')
                                 subtitle = 'Type';
                                 if(item.type == 'location')
                                 subtitle = 'Location';
                                 
                                 inner_html = '<a id="ui-id-3" class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.keyword+'<i class="italic-gray">&nbsp;-&nbsp;'+subtitle+'</i></div></a>';
                                 }
                                 return $( "<li></li>" )
                                 .data( "item.autocomplete", item )
                                 .append(inner_html)
                                 .appendTo( ul );
                               };
                     autoComplete.keyup(function (e) {
                            e.preventDefault();
                           if(e.which === 13) {
                           $(".ui-autocomplete").hide();
                           }            
                           }); 
});
</script>
<!--submit search form-->
<script>
$(function(){
    $('#search_form').submit(function(e){
       e.preventDefault();
       if($.trim($('#searchbox').val()).length == 0){
        $('#searchbox').focus();
        return false;
       }
       searchKeyword = $('#searchbox').val();
       keywordType = 'all';
       filterParks();
      }); 
});
</script>
<!--Map Scripts -->

<div id="black" class="modal-backdrop" style="display: none;" ></div>
<div id="loading" class="loading-modal" style="display: none;">
Please wait...
</div>

<div class="rightbar">
<i class="side-close fa fa-close"></i>
<div id="park_view_res"></div>
</div>  
<script type="text/javascript" src="http://www.google.com/jsapi"></script> 
<script>
var onlyInfoWindow;
var arrayData;
var fixer = 64;
var fixerForAtt = 64;
var fixerForTkt = 64;
var fixerForCpt = 64;

var map;
var mode = '3';
var allMakers = [];
var gTotalSize=0;

var mapZoom=2; 
var mapLat=40.785611; 
var mapLng=-13.946056;

function showResultCount(count){
    $('.result-count').empty().html('Total '+count+' results found');
}

function filterParks(){
    arrayData = fetchParks();
    var results = jQuery.parseJSON(arrayData);
    console.log(results.rows.length);
    showResultCount(results.rows.length);
    init();
}

function fetchParks()
{
  return $.ajax({
  url: "<?php echo site_url('Map/getParks') ?>",
  dataType:"json",
  type:'POST',
  data:{base:$('#base').val(),filter_keyword:searchKeyword,filter_type:keywordType},
  async: false
  }).responseText;
}

var arrayData = fetchParks();
     
google.load("visualization", "1");
google.load("maps", "3", {other_params:"sensor=false"});
google.setOnLoadCallback(init);

function init() {
    
    
    var data = new google.visualization.DataTable(arrayData);    
    var mapping = {
    disableDefaultUI:false,
    scrollWheel:false,
    zoom: mapZoom,
    center: new google.maps.LatLng(mapLat,mapLng),
    //mapTypeId: google.maps.MapTypeId.SATELLITE
    mapTypeId: google.maps.MapTypeId.TERRAIN
    };
    
    map = new google.maps.Map(document.getElementById("map"), mapping);
    var bubbleMap = new Bubble(data);		
    bubbleMap.setMap(map);
    
    var mapStyles = [
        {
            
            featureType: "road", 
            stylers: [
            {visibility: "on"},
            {lightness: +20},
            ]
        }
    ];
    
    map.setOptions({styles: mapStyles,minZoom: 2, maxZoom: 15});
    google.maps.event.addListener(map, 'zoom_changed', saveMapState);
    
    map.addListener('zoom_changed', rebuildBubbles);
    google.maps.event.addListener(map, 'dragend', saveMapState);


}

function saveMapState() { 
     mapZoom=map.getZoom(); 
     var mapCentre=map.getCenter(); 
     mapLat=mapCentre.lat(); 
     mapLng=mapCentre.lng(); 
}

function rebuildBubbles()
{
    
   /* Remove All Markers */
    while(allMakers.length){
        allMakers.pop().setMap(null);
    } 
    allMakers = []; 
    zoom = mapZoom; 
    
      fixerForAtt = 16;
      fixerForAtt = Math.round(fixerForAtt*Math.pow(2,zoom)); // use 2 to the power of current zoom to calculate relative pixel size.  Base of exponent is 2 because relative size should double every time you zoom in
      
      fixerForTkt = 16;
      fixerForTkt = Math.round(fixerForTkt*Math.pow(2,zoom)); // use 2 to the power of current zoom to calculate relative pixel size.  Base of exponent is 2 because relative size should double every time you zoom in
     
      fixerForCpt = 16;
      fixerForCpt = Math.round(fixerForCpt*Math.pow(2,zoom)); // use 2 to the power of current zoom to calculate relative pixel size.  Base of exponent is 2 because relative size should double every time you zoom in
    
   
   
      fixer = 16;
      fixer = Math.round(fixer*Math.pow(2,zoom)); // use 2 to the power of current zoom to calculate relative pixel size.  Base of exponent is 2 because relative size should double every time you zoom in
       
    
    var data = new google.visualization.DataTable(arrayData);    
    var bubbleMap = new Bubble(data);		
    bubbleMap.setMap(map); 
}

 
 
$(document).ready(function(){
  // get park value
    $('.park_type').click(function(){
        $('.park_type').removeClass('active');
        $(this).addClass('active');
        var toBeUpdatedValue = $(this).attr('data-value'); 
        $('#parks_value').val(toBeUpdatedValue);  
        
        arrayData = fetchParks();
        init();
    }); 
    
    $('#base').bind("propertychange change input",function(){
        arrayData = fetchParks();
        init();
    });
     
});
 
//View Park
$(document).on("click", ".show_details", function(e) { 
         e.preventDefault();
         var keywordStr = 0;
         var keywordTypeStr = 0;
         var park_id = $(this).data("parkid");
         if((typeof searchKeyword)=="string"){
         keywordStr = searchKeyword.replace(/\s\s+/g, ' ');
         keywordStr = keywordStr.replace(/\s+/g, '-')
         .log(keywordStr);
         }
         if((typeof keywordType)=="string"){
         keywordTypeStr = keywordType.replace(/_+/g, '-')
         console.log(keywordTypeStr);
         }
         window.location = "<?php echo site_url('Lists/1'); ?>/search_"+keywordStr+"_"+keywordTypeStr+"_"+park_id;
         /*$('#black').fadeIn('fast');
         $('#loading').show();
         var park_id = $(this).data("parkid");
        
          $.ajax({
            "type": "POST",
               url:'<?php echo site_url('Lists/view_park'); ?>/'+park_id+"/1",
               dataType:'html',
               success:function(result){
                  $('#park_view_res').html(result);
                  
                  var  viewport = $( window ).width();
                 if(viewport>=1200){sidebar_left="50%";}
                 if(viewport >= 991 && viewport < 1200){sidebar_left="50%";}
                 if(viewport > 768 && viewport < 991){sidebar_left="40%";}
                 if(viewport <= 768 ){sidebar_left="10%";}
                 
                 $('body').css('overflow','hidden');
                 $(".rightbar" ).animate({left: sidebar_left}, 400);
                 $('#loading').fadeOut();   
                }
          });*/
           
    });  
   
//Sidebar Close
 $(document).on("click", ".side-close, #black", function(e){
       $( ".rightbar" ).animate({
        left: "100%",
        }, 100);
        $('#black').fadeOut();
        $('body').css('overflow','auto');
        $('#park_view_res').empty();
    });   


function roundToK(value)
{
    return Math.round(parseFloat(value)/1000)*1000;
}


</script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
<script src="<?php echo base_url('assets/js/overlay_bubble.js') ?>"></script>   