<?php
$loc = $this->session->userdata("user_ip_address");

$min_year = $this->config->item("min_year");
$max_year = $this->config->item("max_year");
$recent_att =0;
if($atts){
    for($i=$max_year;$i>=$min_year;$i--)
     {
       if($atts[0][$i]){
        $recent_att = $atts[0][$i];
        break;
       }
     }
}    

$adult_price_usd = 0;
$adult_price_native = 0;

$child_price_usd = 0;
$child_price_native = 0;

$adult_price_selected_year=0;
$child_price_selected_year=0;

$tkt_min_year = $this->config->item("tkt_min_year");
$tkt_max_year = $this->config->item("tkt_max_year");
if($tickets){
    foreach($tickets as $ticket){
        
        if($ticket["segment"]=='Adult' && $ticket["currency_id"]==144 ){ //non US but USD
            for($i = $tkt_max_year; $i >= $tkt_min_year; $i--){
            if($ticket[$i]>0 && $adult_price_usd==0 ){
             $adult_price_usd = $ticket[$i];
             $adult_price_selected_year = 'year_'.$i;
            }
            }
        }  
        
        if($ticket["segment"]=='Adult' && $ticket["currency_id"]!=144){ // non US and 
            for($i = $tkt_max_year; $i >= $tkt_min_year; $i--){
            if($ticket[$i]>0 && $adult_price_native==0 ){
             $adult_price_native = $ticket[$i];
             $adult_price_selected_year = 'year_'.$i;
            }
            }
        }  
        
        if($ticket["segment"]=='Child' && $ticket["currency_id"]==144){
            for($i = $tkt_max_year; $i >= $tkt_min_year; $i--){
            if($ticket[$i]>0 && $child_price_usd==0 ){
            $child_price_usd = $ticket[$i];
            $child_price_selected_year = 'year_'.$i;
            }
            }
        }
        
         if($ticket["segment"]=='Child' && $ticket["currency_id"]!=144){
            for($i = $tkt_max_year; $i >= $tkt_min_year; $i--){
            if($ticket[$i]>0 && $child_price_native==0 ){
            $child_price_native = $ticket[$i];
            $child_price_selected_year = 'year_'.$i;
            }
            }
        }
    }
}

$c_code = (@$ppp[0]["currency_code"]) ? $ppp[0]["currency_code"] : $details[0]["c_code"] ;

if (strpos($wiki_name,'/')) {// url
    //get the wiki_name from url
    $wiki_name = substr(strrchr($wiki_name, "/"), 1);
}
?>
<style>
#save-widget {
        width: 320px;
        box-shadow: rgba(0, 0, 0, 0.298039) 0px 1px 4px -1px;
        background-color: white;
        padding: 10px;
        font-family: Roboto, Arial;
        font-size: 13px;
        margin: 15px;
      }

</style>
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-times-circle"></i>
        </button>
        <h4 itemprop="name"  class="modal-title"><?php echo htmlspecialchars($details[0]['name']);?></h4>
      </div>
      <div class="modal-body">
       <div class="row">
       
       <div class="col-md-6">
       
      
        <h5 class="table_toggle"> <div class="pull-left">INFO</div> <i class="fa fa-angle-right fa-rotate-90 visible-xs"></i>
        <div class="clearfix"></div>
        </h5>
       <div class="toggle_target show">
        <table class="table table-responsive details table-hover table-condensed info-table">
            <tbody>
           
            <?php
            if($details[0]['location'])
            echo '<tr><th style="width: 220px;">Location:</th><td  itemprop="containedInPlace" >'.htmlspecialchars($details[0]['location']).'</td></tr>';
            
            if($details[0]['size']){
                
             if(is_numeric($details[0]['size'])){
                  
                if($details[0]['size']>99999)
                $size_rounded =  round($details[0]['size'],-4); 
                else 
                $size_rounded = round($details[0]['size'],-3); 
                   
                $size = number_format($size_rounded);        
             }
             else
             $size = htmlspecialchars($size_rounded);      
             
             echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue" ><th itemprop="name">Size:</th><td itemprop="value">'.$size.'</td></tr>';
            }
            
            if($details[0]['cost']){
             $cost = (is_numeric($details[0]['cost'])) ? number_format($details[0]['cost']) : htmlspecialchars($details[0]['cost']);    
             echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th> <span itemprop="name">Cost</span> <small>('.$details[0]["c_code"].')</small>:</th><td itemprop="value">'.$cost.'</td></tr>';
            }
           
            if($details[0]['country_name'])
            echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th itemprop="name">Country:</th><td itemprop="value">'.htmlspecialchars($details[0]['country_name']).'</td></tr>';
            
            if($details[0]['park_type_name'])
            echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th  itemprop="name">Type:</th><td itemprop="value">'.htmlspecialchars($details[0]['park_type_name']).'</td></tr>';
            
            if($details[0]['brand_name'])
            echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th itemprop="name">Brand:</th><td itemprop="value">'.htmlspecialchars($details[0]['brand_name']).'</td></tr>';
            
            if($details[0]['year_built'])
            echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th itemprop="name">Year Built:</th><td itemprop="value">'.htmlspecialchars($details[0]['year_built']).'</td></tr>';
            
            if($details[0]['thrc']>0)
            echo '<tr><th>Capacity:</th><td>'.number_format(round($details[0]['thrc'],-3)).'</td></tr>';
            
            if($details[0]['url'])
            {
                if(strlen($details[0]["url"])>40){
                    if(isMobile())
                    echo  '<tr><th>URL:</th><td><a itemprop="url"  title="'.$details[0]['url'].'" target="_blank" href="'.$details[0]['url'].'">'.htmlspecialchars(substr($details[0]['url'],0,20)).'...</a></td></tr>';
                    else
                    echo  '<tr><th>URL:</th><td><a itemprop="url"  title="'.$details[0]['url'].'" target="_blank" href="'.$details[0]['url'].'">'.htmlspecialchars(substr($details[0]['url'],0,40)).'...</a></td></tr>';
                
                }
               else
                echo  '<tr><th>URL:</th><td><a itemprop="url"   title="'.$details[0]['url'].'" target="_blank" href="'.$details[0]['url'].'">'.htmlspecialchars($details[0]['url']).'</a></td></tr>';
            }
            
            
            if($adult_price_usd){
                if($adult_price_usd && $details[0]["country_id"]=="233")
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Adult Price</span> <small itemprop="unitText">('.$ppp[0]["currency_code"].')</small>:</th><td itemprop="value">$'.number_format($adult_price_usd).'</td></tr>';
                else if($adult_price_usd && @$ppp[0][$adult_price_selected_year])
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Adult Price</span> <small itemprop="unitText">('.$ppp[0]["currency_code"].')</small>:</th><td itemprop="value">'.number_format($adult_price_usd*$ppp[0][$adult_price_selected_year]).'</td></tr>';
               
                
                if($adult_price_usd && $details[0]["country_id"]!="233")
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Adult Price</span> <small itemprop="unitText">(USD, PPP-adjusted)</small>:</th><td itemprop="value">$'.number_format($adult_price_usd).'</td></tr>';
            }
            
            if($adult_price_native){
                if($adult_price_native)
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Adult Price</span> <small itemprop="unitText">('.$c_code.')</small>:</th><td itemprop="value">'.number_format($adult_price_native).'</td></tr>';
                
                if($adult_price_native && @$ppp[0][$adult_price_selected_year])
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Adult Price</span> <small itemprop="unitText">(USD, PPP-adjusted)</small>:</th><td itemprop="value">$'.number_format($adult_price_native/$ppp[0][$adult_price_selected_year]).'</td></tr>';
            }
            
            if($child_price_usd){
             
                if($child_price_usd && $details[0]["country_id"]=="233")
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Child Price</span> <small itemprop="unitText">('.$ppp[0]["currency_code"].')</small>:</th><td itemprop="value">$'.number_format($child_price_usd).'</td></tr>';
                else if($child_price_usd && @$ppp[0][$child_price_selected_year])
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Child Price</span> <small itemprop="unitText">('.$ppp[0]["currency_code"].')</small>:</th><td itemprop="value">'.number_format($child_price_usd*$ppp[0][$child_price_selected_year]).'</td></tr>';
          
                if($child_price_usd && $details[0]["country_id"]!="233")
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Child Price</span> <small itemprop="unitText">(USD, PPP-adjusted)</small>:</th><td itemprop="value">$'.number_format($child_price_usd).'</td></tr>';
            }
            
            if($child_price_native){
                if($child_price_native)
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Child Price</span> <small itemprop="unitText">('.$c_code.')</small>:</th><td itemprop="value">'.number_format($child_price_native).'</td></tr>';
                
                if($child_price_native && @$ppp[0][$adult_price_selected_year])
                echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th><span itemprop="name">Child Price</span> <small itemprop="unitText">(USD, PPP-adjusted)</small>:</th><td itemprop="value">$'.number_format($child_price_native/$ppp[0][$adult_price_selected_year]).'</td></tr>';
            }
            
            if($recent_att >0  && $details[0]['thrc']>0 ){
                $result =  $details[0]['thrc']/($recent_att/1000); 
                echo '<tr><th>Capacity / Attendance:</th><td>'.number_format(round($result)).' <small>EU/\'000 pp</small></td></tr>';
            }
             
            if($recent_att>0 && $details[0]["size"]){
            $result =  $recent_att/$details[0]["size"]; 
            echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th itemprop="name">Attendance / Size:</th><td><span itemprop="value">'.number_format(round($result)).'</span> <small itemprop="unitText">pp/sqm</small></td></tr>';
            }
            
            if($details[0]['thrc']>0 && $details[0]["size"]>0){
            $result =  $details[0]["size"]/$details[0]['thrc']; 
            echo '<tr itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"><th itemprop="name">Size / Capacity:</th><td><span itemprop="value">'.number_format(round($result)).'</span> <small itemprop="unitText">sqm/EU</small></td></tr>';
            }
            ?>
           
           <?php
             if (!filter_var($details[0]['tripadvisor_url'], FILTER_VALIDATE_URL) === false) {
             $urlArr  = explode('-d',$details[0]['tripadvisor_url']);
             $urlArr  = explode('-',@$urlArr[1]);
             $ta_id = $urlArr[0];
             echo '<tr><td id="ta_res" class="text-center" colspan="2">';
             echo '<iframe src="'.site_url("results/taWidget/".$ta_id).'" style="width: 190px;height: 125px;" class="hide" onload="$(this).removeClass(\'hide\');"></iframe>';
             echo '</td></tr>';
             }
             
           ?>
            </tbody>
            </table>
       </div>   
           
       </div> 

       <div class="col-md-6">
           <?php
           if($related){
           ?>
           <h5 class="table_toggle"> <div class="pull-left">YOU MAY BE INTERESTED IN</div> <i class="fa fa-angle-right visible-xs"></i><div class="clearfix"></div></h5>
           <div class="toggle_target" style="margin-bottom:50px;">
           <table class="details table table-responsive table-hover">
           <?php 
           foreach($related as $item)
           echo '<tr><td><a href="'.$item["link"].'" target="_blank">'.$item["title"].' <i class="fa fa-external-link"></i></a></td></tr>'
           ?>
           </table>
           </div>
           <?php } ?>
           <?php if(@$this->session->userdata("user_ip_address") != 'CN') { ?>
           <h5 class="table_toggle"> <div class="pull-left">LOCATION</div> <i class="fa fa-angle-right visible-xs"></i><div class="clearfix"></div></h5>
           <div class="toggle_target">
           
           <iframe itemprop="hasMap" name="mapIframe" src="<?php echo site_url('results/get_map_for_view/'.$details[0]["park_id"]); ?>" class="map_on_view" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
           
           <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
            <meta itemprop="latitude" content="<?php echo $details[0]["latitude"]; ?>" />
            <meta itemprop="longitude" content="<?php echo $details[0]["longitude"]; ?>" />
          </div>
           </div>
          <?php } ?> 
           <h5 class="table_toggle" id="history" style="display: none;"> <div class="pull-left">HISTORY</div> <i class="fa fa-angle-right visible-xs"></i> <div class="clearfix"></div></h5>
           <div class="toggle_target">
                <div class="text-center margin-top-15" style="display: none;" id="wiki_loader">
                  <img src="<?php echo base_url('assets/images/ripple.gif')?>"   /><br /> Loading history...
                </div>
                <div id="wiki-page"></div>
           </div>
        </div>
        
     </div>
    
    <div class="clearfix"></div>
        
       
       <div class="row ride_holder">
       <?php  if($rides){ ?>
       <div class="col-md-8">
       
       <h5 class="table_toggle"> <div class="pull-left">RIDES</div> <i class="fa fa-angle-right visible-xs"></i>
        <div class="clearfix"></div>
        </h5>
       <div class="toggle_target">
       <table class="details table table-responsive table-hover">
           <tbody><tr><th>Name</th><th>Type</th><th>Capacity</th></tr>
           <?php
           $cpa_total = 0;
           $mostRecent= 0;
           $Recent = 0;
            foreach($rides as $value)
            {
                $curCreatedDate = strtotime($value['created']);
                $curUpdatedDate = strtotime($value['last_updated']);
                
                if ($curCreatedDate > $curUpdatedDate) $Recent = $curCreatedDate;
                else $Recent = $curUpdatedDate;
                
                
                if($Recent > $mostRecent)
                $mostRecent = $Recent;
                
                if(($value['hourly_capacity']>0))
                {
                 $cpa_total  = $cpa_total + $value['hourly_capacity'];   
                }
                $cpa = ($value['hourly_capacity']>0) ? number_format(round($value['hourly_capacity'],-1)) : '-';
                
                echo '<tr>
                <td>'.htmlspecialchars($value['ride_name']).'</td>
                <td>'.htmlspecialchars($value['ride_type']).'</td>
                <td>'.($cpa).'</td>
                </tr>';
            }
           ?>
            
           </tbody>
        </table>
       <?php  if(@$mostRecent){ ?>
       <em> Last Updated : <?php echo date("d/m/Y",$mostRecent); ?></em>
       <?php } ?>
      </div>
       
        
       </div>
       <?php } ?>
       <?php 
       if($atts){
       ?>
       <div class="col-md-4">
      <h5 class="table_toggle"> <div class="pull-left">ATTENDANCE</div> <i class="fa fa-angle-right visible-xs"></i>
        <div class="clearfix"></div>
        </h5>
       <div class="toggle_target">
            <table class="details table table-responsive table-hover">
            <tbody><tr><th>Year</th><th>Value</th></tr>
            <?php 
            for($i=$max_year;$i>=$min_year;$i--)
             {
               if($atts[0][$i])
               echo '<tr><td>'.$i.'</td><td>'.htmlspecialchars(number_format($atts[0][$i])).'</td></tr>';
             }
            ?>  
            </tbody></table>
            <?php
            $atts[0]["source"] = htmlspecialchars($atts[0]["source"]);
            $atts[0]["source"] = str_replace('\n','<br/>',$atts[0]["source"]);
            ?>
            <p><small><strong>Source</strong>:<?php echo nl2br($atts[0]["source"]); ?></small></p>
            
         </div>
       </div>
       <?php } ?>
      </div>
       
    <?php 
    if($misc){
    ?>  
    <div class="row">
    <div class="col-md-12 source_holder">
    <h5 class="table_toggle"> <div class="pull-left">SOURCES</div> <i class="fa fa-angle-right visible-xs"></i>
    <div class="clearfix"></div>
    </h5>
    <div class="toggle_target">
    <table class="details table table-responsive table-hover">
    <?php
    foreach($misc as $item)
    {
        echo '<tr>';
            if(strlen($item["label"])>0)
            {
            echo '<th style="width:200px;">'.$item["label"].'</th>';
            $colspan ='';
            }
            else 
            $colspan ='colspan="2"';
            
            if($item["type"]=='comment')
            echo '<td '.$colspan.'>'.htmlspecialchars($item["comment"]).'</td>';
            
            if($item["type"]=='url')
            echo '<td '.$colspan.'><a href="'.$item["url"].'" target="_blank">'.$item["url"].'</a></td>';
            
            if($item["type"]=='file')
            echo '<td '.$colspan.'><a href="'.site_url('results/download_misc_file/'.$item["filename"]).'" target="_blank" class="btn btn-default btn-xs">Download File</a></td>';
        
        echo '</tr>';
    }
    ?>
    </table>
    </div>
    </div>
    </div>
    
    <?php } ?>
    <div class="row hide">
          <div class="col-md-12">
           <div class="text-center">
          <h2>SCENES</h2>
          </div>
              <div class="text-center margin-top-15" style="display: none;" id="scenes_loader">
              <img src="<?php echo base_url('assets/images/ripple.gif')?>"   /><br /> Loading... Please wait.
              </div>
              <div id="scenes_res" data-cordinates="<?php echo $details[0]['latitude'].','.$details[0]['longitude'];?>" data-park="<?php echo $details[0]['name'].', '.$details[0]['location'];?>" data-search_terms="<?php if(!is_null($details[0]['search_terms'])) echo $details[0]['search_terms']; else echo '';?>">
              </div>       
       </div> 
       <div class="clearfix"></div>   
    </div>
 </div>    
<script>

function callWikipediaAPI(wikipediaPage) {
    $.getJSON('https://en.wikipedia.org/w/api.php?action=parse&format=json&callback=?', {page:wikipediaPage, prop:'text', uselang:'en'}, wikipediaHTMLResult);
}

var wikipediaHTMLResult = function(data) {
    var readData = '';
    var flag = 0;
    console.log(data);
    
    if(data.hasOwnProperty('parse')){
    
        readData = $('<div>' + data.parse.text["*"] + '</div>');
        // handle redirects
        var redirect = readData.find('li:contains("REDIRECT") a').text();
        if(redirect != '') {
        	callWikipediaAPI(redirect);
            return;
        }
        
        if(readData.find('#History.mw-headline').length !== 0){//history section exists
           //remove all content before history section
           readData.find('#History.mw-headline').parent().prevAll().each(function() {
              readData.find(this).remove();
           });
           
           //remove images
           readData.find('.thumb').remove();
           readData.find('h5').remove();
           
           //remove all content after history section
           readData.find('#History.mw-headline').parent().nextAll().each(function() {
            if (this.tagName == 'H2' || flag==1) {
             flag = 1;
             readData.find(this).remove();
            }
           });
           
           //limit the history content
           //remove all content after history section
           var i = 1;
           flag = 0;
           var limit = 0;
           readData.find('#History.mw-headline').parent().nextAll().each(function() {
            if(i==1 && this.tagName == 'H3'){
                i++;
                return true;//continue; 
            }
            else if(this.tagName == 'H3' || flag==1){
             flag = 1;
             readData.find(this).remove();
            }
            else if(limit + $(this).text().length > 1500){
                flag = 1;
                readData.find(this).remove();
            }
            else{
                limit += $(this).text().length;
            }
           });
           //remove edit options
           readData.find('.mw-editsection').remove();
           //remove supscript
           readData.find('sup').remove();
           
           //remove metadata
           readData.find('table.metadata').remove();
           
           //replace h2 with h4
           $.each(readData.find('h2,h3'), function(){
             $(this).remove();
           });
           
          
           
           //loader
           $('#wiki_loader').css('display','none');
           //show result
           $('#wiki-page').append(readData);
           var onlyTxt = (document.getElementById('wiki-page').innerText);
           $('#wiki-page').html(nl2br(onlyTxt.substr(0,520),false)+'...');
           $('#history').show();
           
           $('#wiki-page').append('<div class="clearfix" style="margin-top:7px;"></div><div class="pull-left"><small>Source: Wikipedia</small></div><div class="pull-right"><a target="_blank" href="https://en.wikipedia.org/wiki/'+WikiName+'#History">Read More</a></div>');
            
        }
        else{
            
            $('#wiki_loader').css('display','none');
        }
  }
  else
   $('#wiki_loader').css('display','none');
};
var WikiName = "<?php echo $wiki_name; ?>";
$(function(){
 $('#wiki_loader').css('display','block');
 callWikipediaAPI(WikiName);
});//ready function 

function nl2br (str, is_xhtml) {
  var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br ' + '/>' : '<br>'; // Adjust comment to avoid issue on phpjs.org display
   return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

</script>