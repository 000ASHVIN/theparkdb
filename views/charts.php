<?php
$filterKeyword = (@$keyword_data["filterKeyword"]) ? addslashes($keyword_data["filterKeyword"]) : 0 ;
$filterType = (@$keyword_data["filterType"]) ? addslashes($keyword_data["filterType"]) : 0 ;
$latitude = (@$keyword_data[0]["latitude"]) ? $keyword_data[0]["latitude"] : 40.785611; 
$longitude = (@$keyword_data[0]["longitude"]) ? $keyword_data[0]["longitude"] : -13.946056;
?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.dataTables.min.css');?>" />
<style>
.ui-multiselect-checkboxes {
   height:auto!important;
   max-height: 200px;
}


#stacked_chart_1,#stacked_chart_2,#bubble_chart_1{
    width:100%; height:500px;
    font-size: 12px!important;
    line-height: 13px!important;
    text-align: left!important;
}
#stacked_chart_2{
    margin-bottom: 50px;
}


.charts-tooltip{
     text-align: left!important;
     font-size: 5px!important;
}
.dataTables_paginate span {
    display:none;
}
.ranking-table td{
    color: #3f0c5f;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 5px;
    text-align: left;
    padding: 15px 10px!important;
}
.ranking-table > thead > tr > th {
    vertical-align: bottom;
    border-bottom: 0px solid #ddd; 
    padding: 10px 10px;
    font-weight: normal;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #ddd;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: #3f0c5f !important;
    border: 1px solid #fff;
    background-color: #fff;
    background: #fff;
}

#summary_listing{
    margin-top: 50px;
}


</style>
<section id="other_page_search_area">
    <div class="container">
         <div class="col-md-offset-3 col-md-6">
             <div class="search-form-wrapper">
                    <form class="form-inline" id="sub_form" role="form">
					<div class="input-group">
                               <input autofocus="true" type="search" id="searchbox" class="form-control ui-autocomplete-input" name="search" value="<?php if($filterKeyword) echo $filterKeyword; ?>"  placeholder="Search for a park, type, country or region" autocomplete="off">
                               <div class="input-group-btn">
                                  <button type="submit" class="btn-submit"><i class="glyphicon glyphicon-search"></i></button>
                        	   </div><!-- /btn-group -->
                    <a href="#" class="reset_filters"><small>Reset</small></a>
                    </div>
					</form>
              </div>
          </div>
    </div>
</section>
<section id="fake_tabs">
    <div class="col-md-6 tab-link inactive-tab show_map">MAP VIEW</div>
    <div class="col-md-6 tab-link active-tab">SUMMARY</div>
    <div class="clearfix"></div>
</section>
<section>
	<div class="container">
		<div class="row">
            
           	<div class="col-lg-12 col-md-12 text-center chart_1">
            <h2>SUMMARY</h2>
            <div><img src="<?php echo base_url('assets/images/ripple.gif'); ?>" id="loading0"  /> Loading.... </div>
            <div style="display:none;" class="table-responsive">
            
                 <table id="summary_listing" class="table ranking-table table-hover">
                        <thead>
                            <tr>
                                   <th style="width:250px;">Name</th>
                                   <th>Location</th>
                                   <th>Attendance</th>
                                   <th>Adult Ticket Price (Native/$)</th>
                                   <th>Capacity (THRC)</th>
                                   <th>Size</th>
                             </tr>
                        </thead>
                 </table>
            </div>
           	</div>
            
			<div class="col-lg-12 col-md-12 text-center chart_1">
            <h2>ATTENDANCE</h2>
            <div><img src="<?php echo base_url('assets/images/ripple.gif'); ?>" id="loading1"  /> Loading.... </div>
            <div id="stacked_chart_1">
            </div>
			</div>
            
            <div class="col-lg-12 col-md-12 text-center chart_2">
            <h2>Estimated Revenues</h2>
            <div><img src="<?php echo base_url('assets/images/ripple.gif'); ?>" id="loading2"  /> Loading.... </div>
			<div id="bubble_chart_1">
            </div>
			</div>
            
            <div class="col-lg-12 col-md-12 text-center chart_3">
            <h2>Capacity</h2>
            <div><img src="<?php echo base_url('assets/images/ripple.gif'); ?>" id="loading3"  /> Loading.... </div>
			<div id="stacked_chart_2">
            </div>
			</div>
            
            <div id="no-data" class="alert alert-info" style="display: none;">No data found. Please try another search term.</div>
        </div>
	</div>
</section>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js');?>"></script>      
<script type="text/javascript" src="https://www.google.com/jsapi"></script>   
<script type="text/javascript" src="<?php echo site_url('search/all_suggestions');?>"></script>    
<script>
var searchKeyword = '<?php echo $filterKeyword; ?>';
var keywordType = '<?php echo $filterType; ?>';
var mapLat= <?php echo $latitude; ?>; 
var mapLng= <?php echo $longitude; ?>;
var parksWithData =[];
var parksWithDataThird =[];
var summaryData = [];
var DtObj;
var flag_ = <?php if($bounds[0]==0 && $bounds[1]==0 && $bounds[2] == 0 && $bounds[3] == 0) echo 0; else echo 1;?>;
var first = 1;
//var chart;
google.load('visualization', '1', {packages: ['corechart']});


$(document).ready(function(){
    get_parks_with_data();
   

    
    
var autoCompleteOptions = {
 minLength: 2,
 source: function(request, response) {
        var results = $.ui.autocomplete.filter(suggestions, request.term);
        response(results.slice(0, 5));
    },
    select: function(event, ui) {
        
            event.preventDefault();
            searchKeyword = ui.item.label;
            keywordType = ui.item.t;
            if(keywordType == 'name' || keywordType == 'location' ||
                    keywordType == 'country_name' || keywordType == 'continent_name')
                 {
                   mapLat = ui.item.lt;
                   mapLng = ui.item.lg;
                 } 
            if(keywordType=='name')
            searchKeyword = ui.item.p;
             
            get_parks_with_data();
          
    },
    focus: function (event, ui) {
             event.preventDefault();
             $( "#searchbox" ).val(ui.item.label);
             $( "#search_on_top" ).val(ui.item.label);
    }
};
    
var autoComplete = $( "#searchbox" ).autocomplete(autoCompleteOptions);
var autoCompleteTop = $( "#search_on_top" ).autocomplete(autoCompleteOptions);
                 
autoComplete.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
             var inner_html = '';
             if(item.no_results){// no result found
                inner_html ='<a id="ui-id-3" class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.message+'</div></a>';
             }
             else{
                 var subtitle = '';
                 if(item.t == 'name')subtitle = 'Park';
                 if(item.t == 'brand_name')subtitle = 'Brand';
                 if(item.t == 'country_name')subtitle = 'Country';
                 if(item.t == 'park_type_name')subtitle = 'Type';
                 if(item.t == 'location')subtitle = 'Location';
                 if(item.t == 'continent_name')subtitle = 'Continent';
                 inner_html = '<a id="ui-id-3" class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.label+'<i class="italic-gray">&nbsp;-&nbsp;'+subtitle+'</i></div></a>';
             }
             return $( "<li></li>" ).data( "item.autocomplete", item ).append(inner_html).appendTo( ul );
};
autoComplete.keyup(function (e) {
       e.preventDefault();
       if(e.which === 13 || e.keyCode === 13)  $(".ui-autocomplete").hide();
}); 

autoCompleteTop.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
             var inner_html = '';
             if(item.no_results){// no result found
                inner_html ='<a id="ui-id-3" class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.message+'</div></a>';
             }
             else{
                 var subtitle = '';
                 if(item.t == 'name')subtitle = 'Park';
                 if(item.t == 'brand_name')subtitle = 'Brand';
                 if(item.t == 'country_name')subtitle = 'Country';
                 if(item.t == 'park_type_name')subtitle = 'Type';
                 if(item.t == 'location')subtitle = 'Location';
                 if(item.t == 'continent_name')subtitle = 'Continent';
                 inner_html = '<a id="ui-id-3" class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.label+'<i class="italic-gray">&nbsp;-&nbsp;'+subtitle+'</i></div></a>';
             }
             return $( "<li></li>" ).data( "item.autocomplete", item ).append(inner_html).appendTo( ul );
};
autoCompleteTop.keyup(function (e) {
       e.preventDefault();
       if(e.which === 13 || e.keyCode === 13)  $(".ui-autocomplete").hide();
}); 

$('#sub_form').submit(function(e){
       e.preventDefault();
       if($.trim($('#searchbox').val()).length == 0){
        $('#searchbox').focus();
        return false;
       }
        $(".ui-autocomplete").hide();
       searchKeyword = $('#searchbox').val();
        
        if(searchKeyword.length==2 || (searchKeyword.split(',').length>1))
        keywordType = 'countries';
        else
        keywordType = 'all';
       
       get_parks_with_data();
     
});
    
$('#top_search_form').submit(function(e){
       e.preventDefault();
       if($.trim($('#search_on_top').val()).length == 0){
        $('#search_on_top').focus();
        return false;
       }
        $(".ui-autocomplete").hide();
       searchKeyword = $('#search_on_top').val();
       if(searchKeyword.length==2 || (searchKeyword.split(',').length>1))
        keywordType = 'countries';
        else
        keywordType = 'all';
       
       get_parks_with_data();
       
});    
    
    
    
//reset all filters
  $('.reset_filters').click(function(e){
     e.preventDefault();    
     searchKeyword = '<?php echo $filterKeyword; ?>';
     keywordType = '<?php echo $filterType; ?>'; 
     if(searchKeyword!="0")
     $('#searchbox').val(searchKeyword);
     $('#search_on_top').val(searchKeyword);
     get_parks_with_data();
    
        
  }); 
});

$(document).on('click','.show_map',function(e){
    e.preventDefault();
    top.location.href="<?php echo site_url('results/in/') ?>/"+keywordType+"/"+encodeURIComponent(searchKeyword);  
}); 
    

function get_parks_with_data()
{
    
    
    $('#loading1').parent().show();
    $('#loading2').parent().show();
    $('#loading3').parent().show();
    $('#loading0').parent().show();
    $('#summary_listing').parent().css('display','none');  
      
      if(keywordType=='country_name') keywordType = 'country';
      if(keywordType=='continent_name') keywordType = 'continent';
      if(keywordType=='park_type_name') keywordType = 'park_type';
      if(keywordType=='brand_name') keywordType = 'brand';

    var sData = {
            "filterType" : keywordType,
            "filterKeyword" : searchKeyword,
            "lat" : mapLat,
            "long" : mapLng
    };
    
    if(first == 1 && flag_ == 1){
    sData.bounds =   {'sw':[<?php echo $bounds[0];?>,<?php echo $bounds[1];?>],'ne':[<?php echo $bounds[2];?>,<?php echo $bounds[3];?>]};
    }
    $.ajax({
           "type": "POST",
           url:'<?php echo site_url('charts/getParksWithData'); ?>',
           dataType:'json',
           async:true,
           data:sData,
           success:function(result){
               if(result.status==1){
                 $('#no-data').hide();
                 parksWithData = result.ParksWithData.forFirst;
                 parksWithDataThird = result.ParksWithData.forThird;
                 summaryData = result.ParksWithData.forSummary;
                
                 if(!DtObj) drawDatatable(); 
                 else { 
                    $('#loading0').parent().hide();
                    $('#summary_listing').parent().css('display','block'); 
                    DtObj.clear().rows.add(summaryData).draw();
                 }
                 drawStackedChart();
                 drawBubbleChart();
                 drawStackedChart2();
               }
               first = 0;
           } 
         });
}

function drawStackedChart() {
      
     
      var data =[['Park', 'Attendance']];
      $.each(parksWithData,function(k,val){
        if(parseInt(val["att"])>0){
        var tempArr = [val["name"],parseInt(val["att"])];
        data.push(tempArr);
        }
      }); 
      
      
      if(data.length<2){$('.chart_1').hide();return false;} 
      else{
      $('.chart_1').show();
      $('#loading1').parent().hide();
      }
      var data = google.visualization.arrayToDataTable(data);
      
      
      var formatter = new google.visualization.NumberFormat({pattern: '###,###'});
      formatter.format(data, 1);    
      
      var options = {
        title: '',
        fontName:'Raleway',
        hAxis: {
          title: null,
          direction:-1, slantedText:true, slantedTextAngle:90
        },
        vAxis: {
          title: 'Attendance'
        },
        legend: null,
        chartArea:{left:130,top:50,bottom:150,width:"100%",height:"250px"},
        colors: ['#3f0c5f']

      };

      var chart = new google.visualization.ColumnChart(document.getElementById('stacked_chart_1'));
      chart.draw(data, options);
      

}

function drawDatatable() {
      $('#loading0').parent().hide();
      $('#summary_listing').parent().css('display','block');
      
      DtObj = $('#summary_listing').DataTable({
        "bFilter" : false,               
        "bLengthChange": false,
        "iDisplayLength":5,
        "bSort": false,
        data: summaryData,
        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
            var name = '';
            name += '<a href="<?php echo site_url('results/in/name'); ?>/'+aData[6]+'/view_details">'+aData[0]+'</a>'; 
            
            $('td:eq(0)', nRow).html( name);
            
            var location = '';
            location += '<a href="<?php echo site_url('results/in/location'); ?>/'+aData[1]+'">'+aData[1]+'</a>'; 
            
            $('td:eq(1)', nRow).html( location);
            },
      });
      
       
}

function drawStackedChart2() {
      
      var data =[['Park', 'Capacity']];
      $.each(parksWithDataThird,function(k,val){
        if(parseInt(val["capacity"])>0){
        var tempArr = [val["name"],parseInt(val["capacity"])];
        data.push(tempArr);
        }
      }); 
      
        if(data.length<2){
           $('.chart_3').hide();
           //checking if no data is available
           if( $('.chart_1').css('display')=='none'  && $('.chart_2').css('display')=='none' &&  $('.chart_3').css('display')=='none'  )
           $('#no-data').css('display','block');
           return false;
        } 
        else{
        $('#loading3').parent().hide();    
        $('.chart_3').show();
        }
    
      var data = google.visualization.arrayToDataTable(data);
      
      
      var formatter = new google.visualization.NumberFormat({pattern: '###,###'});
      formatter.format(data, 1);    
      
      var options = {
        title: '',
        fontName:'Raleway',
        hAxis: {
          title: null,
          direction:-1, slantedText:true, slantedTextAngle:90
        },
        vAxis: {
          title: 'Capacity'
        },
        legend: null,
        chartArea:{left:130,top:50,bottom:150,width:"100%",height:"250px"},
        colors: ['#3f0c5f']

      };

      var chart = new google.visualization.ColumnChart(document.getElementById('stacked_chart_2'));
      chart.draw(data, options);

    
   

}

function roundToK(value)
{
    return Math.round(parseFloat(value)/1000)*1000;
}


function drawBubbleChart()
{
    var data =[['Name', 'Attendance        ', 'Ticket Price($)','Park Name        ','Revenue($)    ']];
      $.each(parksWithData,function(k,val){
        if(parseInt(val["att"])>0 && parseFloat(val["tkt"])>0 ){
        var tempArr = [val["name"],parseInt(val["att"]),parseFloat(val["tkt"]), val["name"] , (parseFloat(val["tkt"])*parseInt(val["att"]))  ];
        data.push(tempArr);
        }
      }); 
    
    if(data.length<2){$('.chart_2').hide();return false;} 
    else{
    $('.chart_2').show();
    $('#loading2').parent().hide();
    }
    
     var data = google.visualization.arrayToDataTable(data);
     var formatter = new google.visualization.NumberFormat({pattern: '###,#00'});
     var currency_formatter = new google.visualization.NumberFormat({pattern: '$###,###'});
     
     
     formatter.format(data, 1); 
     currency_formatter.format(data, 4);
     
         
      var options = {
        title: '',
        fontName:'Raleway',
        hAxis: {title: 'Attendance',fontName:'Raleway'},
        vAxis: {title: 'Adult Ticket Price (USD)',fontName:'Raleway'},
        bubble: {textStyle: {fontSize: 11}},colors: ['#F5D76E', 'E74C3C','#F64747','#BE90D4','#81CFE0','#1BBC9B','#F39C12','#ABB7B7','#4183D7','#87D37C','#03C9A9','#F89406','#F64747','#D2527F']
        ,chartArea:{left:130,top:50,right:250,width:"100%",height:"250px"},
      };

      var chart2 = new google.visualization.BubbleChart(document.getElementById('bubble_chart_1'));
      chart2.draw(data, options);
}

/* ---------------------------------------------------------------------- */
/* -------------------------- Display Top Search Form ------------------------- */
/* ---------------------------------------------------------------------- */
var distance = $('#searchbox').offset().top,
$window = $(window);
$window.scroll(function() {
    if ( $window.scrollTop() >= distance-20 ) {
        $('#top_search_form').fadeIn('slow');
    }
    else{
        $('#top_search_form').fadeOut('slow');
    }
});

    
</script>        