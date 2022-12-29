<style>
.btn-default {
    font-size: 18px;
    width: 200px;
}

.show_via_regions {
    width: auto;
}


@media (max-width: 580px) {
 
  
.btn-default {
    font-size: 18px;
    width: 100%;
}

#searchbox {

    font-size: 12px;
    margin-bottom: 10px;
    width: 100%;
    background: #3f0c5f;
    border-bottom: 0px solid #fff;
    border-radius: 5px;

} 

#searchbox:focus{
  border-bottom: 0px solid #fff; 
}

#search-area {
    min-height: 580px;
    padding-top: 100px;
    background: #4e1473;
}

.search-form-wrapper {
    margin-top: 50px;
    padding: 0px;
}

#sub_form, #sub_form div{
    width: 100%;
}

}
</style>
<section class="parallax" id="search-area">
        <div class="container">
           <div class="col-md-offset-3 col-md-6 col-sm-offset-2 col-sm-8">
                <p class="pre-heading">A <strong>database</strong> of </p>
                <h1 class="title-heading"><strong>theme parks<br/></strong><em>&amp;</em><strong>attractions</strong></h1>
                <p class="post-heading">around the world</p>
                
                <div class="search-form-wrapper">
                    <form class="form-inline" id="sub_form" role="form">
					<div class="input-group">
                               <input autofocus="true" type="search" id="searchbox" class="form-control ui-autocomplete-input" name="search" placeholder="Search for a park, type, country or region" autocomplete="off">
                               <div class="input-group-btn" id="home_search_btn_holder">
                                  <button type="submit" class="btn-submit"><i class="glyphicon glyphicon-search"></i></button>
                        	   </div><!-- /btn-group -->
                    </div>
                    <button type="submit" id="sm-sub-btn" class="btn btn-default btn-submit">SEARCH</button>
					</form>
                </div>
           </div> 
          <?php 
          if($countries){
          ?>
          <div class="clearfix"></div>
           <div class="col-md-12" id="region_tabs_holder">
           <p>or browse parks by location</p>

           <!-- Nav tabs --> 
              <ul class="nav nav-tabs" role="tablist" id="region_tabs">
                <li role="presentation"><a id="asia_tab_btn" href="#asia" aria-controls="asia" role="tab" data-toggle="tab">ASIA <i class="glyphicon glyphicon-menu-down"></i></a></li>
                <li role="presentation"><a id="americas_tab_btn" href="#americas" aria-controls="americas" role="tab" data-toggle="tab">AMERICAS <i class="glyphicon glyphicon-menu-down"></i></a></li>
                <li role="presentation"><a id="europe_tab_btn" href="#europe" aria-controls="europe" role="tab" data-toggle="tab">EUROPE <i class="glyphicon glyphicon-menu-down"></i></a></li>
                <li role="presentation"><a id="africa_tab_btn" href="#africa" aria-controls="africa" role="tab" data-toggle="tab">AFRICA <i class="glyphicon glyphicon-menu-down"></i></a></li>
                <li role="presentation"><a id="ocenia_tab_btn" href="#ocenia" aria-controls="ocenia" role="tab" data-toggle="tab">MIDDLE EAST <i class="glyphicon glyphicon-menu-down"></i></a></li>
              </ul>
            
              <!-- Tab panes -->
              <div class="tab-content f16">
                <div role="tabpanel" class="tab-pane" id="asia">
                <ul>
                <?php
                $i=1;
                foreach($countries as $country)
                    if($country["continent_code"]=='AS' || $country["continent_code"]=='OC'){
                    echo '<li><a href="#" class="region_option" data-ccode="'.$country["country_code"].'"><div class="flag-box flag '.strtolower($country["country_code"]).'"></div>'.$country["country_name"].' <i class="fa fa-check-circle-o"></i></a></li>';
                    $i++;
                    if($i==10){ echo '</ul><ul>'; $i=1;};
                    }
                ?>
                </ul>
                    <div class="clearfix"></div>
                    <div class="text-center">
                    <p><a href="#" class="select_all_region"  data-cont="asia">Select all</a></p>
                    <p><a href="#" class="show_via_regions btn btn-default"  data-cont="asia">See All Attractions in Selected Countries</a></p>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="americas">
                <ul>
                <?php
                $i=1;
                foreach($countries as $country)
                    if($country["continent_code"]=='NA' || $country["continent_code"]=='SA'  ){
                    echo '<li><a href="#" class="region_option" data-ccode="'.$country["country_code"].'"><div class="flag-box flag '.strtolower($country["country_code"]).'"></div>'.$country["country_name"].' <i class="fa fa-check-circle-o"></i></a></li>';
                    $i++;
                    if($i==10){ echo '</ul><ul>'; $i=1;};
                    }
                ?>
                </ul>
                    <div class="clearfix"></div>
                    <div class="text-center">
                    <p><a href="#" class="select_all_region"  data-cont="americas">Select all</a></p>
                    <p><a href="#" class="show_via_regions btn btn-default" data-cont="americas">See All Attractions in Selected Countries</a></p>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="europe">
                <ul>
                <?php
                $i=1;
                foreach($countries as $country)
                    if($country["continent_code"]=='EU'){
                    echo '<li><a href="#" class="region_option" data-ccode="'.$country["country_code"].'"><div class="flag-box flag '.strtolower($country["country_code"]).'"></div>'.$country["country_name"].' <i class="fa fa-check-circle-o"></i></a></li>';
                    $i++;
                    if($i==10){ echo '</ul><ul>'; $i=1;};
                    }
                ?>
                </ul>
                    <div class="clearfix"></div>
                    <div class="text-center">
                    <p><a href="#" class="select_all_region"  data-cont="europe">Select all</a></p>
                    <p><a href="#" class="show_via_regions btn btn-default" data-cont="europe">See All Attractions in Selected Countries</a></p>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="africa">
                <ul>
                <?php
                $i=1;
                foreach($countries as $country)
                    if($country["continent_code"]=='AF'){
                    echo '<li><a href="#" class="region_option" data-ccode="'.$country["country_code"].'"><div class="flag-box flag '.strtolower($country["country_code"]).'"></div>'.$country["country_name"].' <i class="fa fa-check-circle-o"></i></a></li>';
                    $i++;
                    if($i==10){ echo '</ul><ul>'; $i=1;};
                    }
                ?>
                </ul>
                    <div class="clearfix"></div>
                    <div class="text-center">
                    <p><a href="#" class="select_all_region"  data-cont="africa">Select all</a></p>
                    <p><a href="#" class="show_via_regions btn btn-default" data-cont="africa">See All Attractions in Selected Countries</a></p>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="ocenia">
                <ul>
                <?php
                $i=1;
                foreach($countries as $country)
                    if($country["continent_code"]=='ME'){
                    echo '<li><a href="#" class="region_option" data-ccode="'.$country["country_code"].'"><div class="flag-box flag '.strtolower($country["country_code"]).'"></div>'.$country["country_name"].' <i class="fa fa-check-circle-o"></i></a></li>';
                    $i++;
                    if($i==10){ echo '</ul><ul>'; $i=1;};
                    }
                ?>
                </ul>
                    <div class="clearfix"></div>
                    <div class="text-center">
                    <p><a href="#" class="select_all_region"  data-cont="ocenia">Select all</a></p>
                    <p><a href="#" class="show_via_regions btn btn-default" data-cont="ocenia">See All Attractions in Selected Countries</a></p>
                    </div>
                </div>
                <div class="clearfix"></div>
              </div>
           </div>
           <?php } ?>
        </div><!-- /container -->
</section> 
<section id="about-area">
        <div class="container">
            <div class="jumper">
                <span>Read about us
                <div class="clearfix"></div>
                <i class="glyphicon glyphicon-menu-down"></i>
                </span>
            </div>
            <div class="news_section">
                <div class="row">
                    <div class="col-sm-6">
                       <h2>LATEST NEWS</h2>
                       <div>
                       <br />
                       <?php 
                       $image_path = $this->config->item('image_path');  
                       if(isMobile() && $news){
                       ?> 
                       
                       <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
                          <!-- Indicators -->
                          <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                          </ol>
                       <div class="carousel-inner" role="listbox"> 
                       <?php
                             foreach($news as $key=>$value){
                                if($value['image']){
                                $src = $image_path.'news/'.$value['image'];
                                }else{
                                $src = base_url('assets/images/placeholder-500x400.png');  
                                }
                       ?>
                       <div class="item <?php if($key==0) echo 'active'; ?>">
                         <a href="<?php echo $value['url']; ?>">
                          <img src="<?php echo $src; ?>" alt="<?php echo $value['title']; ?>"/>
                          <div class="carousel-caption">
                            <h3 class="news_title"><?php echo $value['title']; ?></h3>
                            <p>
                               <?php 
                               if (strlen($value['sub_title']) > 150) {
                                    // truncate intro
                                    $introCut = substr($value['sub_title'], 0, 150);
                                    $value['sub_title'] = substr($introCut, 0, strrpos($introCut, ' ')).'...'; 
                               }
                               echo $value['sub_title']; 
                               ?>
                            </p>
                            <div class="news_date" style="display: none;">Posted on <?php echo date('F d, Y',strtotime($value['created'])); ?></div>
                            <div class="text-center">
                            <a href="<?php echo $value['url']; ?>" class="mobile_new_link">CONTINUE READING <i class="fa fa-angle-right"></i></a>
                            </div>
                          </div>
                          </a>
                        </div>
                      
                       <?php } ?>
                        </div>
                        
                          
                        </div>
                       
                       
                       
                       <?php
                       }
                       else {
                       
                       if($news){
                            
                            foreach($news as $key=>$value){
                                if($value['image']){
                                $src = $image_path.'news/'.$value['image'];
                                }else{
                                $src = base_url('assets/images/placeholder-500x400.png');  
                                }
                       ?>
                       <a href="<?php echo $value['url']; ?>">
                       <div class="park_item news_item">
                           <div class="col-sm-5 news_image_pre_holder">
                           <div class="news_image_holder lazy"  data-src="<?php echo $src; ?>" style="background: url(<?php echo $src; ?>) no-repeat;background-position: center;background-size: cover;"></div>
                            <div class="overlay">READ</div>
                           </div>
                           <div class="col-sm-7 news_content_holder">
                               <h3 class="news_title"><?php echo $value['title']; ?></h3>
                               <p>
                               <?php 
                               if (strlen($value['sub_title']) > 150) {
                                    // truncate intro
                                    $introCut = substr($value['sub_title'], 0, 150);
                                    $value['sub_title'] = substr($introCut, 0, strrpos($introCut, ' ')).'...'; 
                               }
                               echo $value['sub_title']; 
                               ?></p>
                               <div class="news_date" style="display: none;">Posted on <?php echo date('F d, Y',strtotime($value['created'])); ?></div>
                           </div>
                       </div>
                       </a>
                       <?php } } } ?> 
                      
                      </div>
                      
                       <div class="clearfix"></div>
                       <div class="btn-holder">
                        <div class="text-center all_top_link">
                        <a href="http://www.theparkdb.com/blog/" class="btn btn-default">READ BLOG</a>
                       </div>
                       </div>
                       
                    </div>
                    
                    <div class="col-sm-6 mob_updated_list">
                        <h2>NEWLY UPDATED PARKS</h2>
                        <br /><br />
                        <div class="clearfix"></div>
                        <?php
                        if($fives){
                          
                            foreach($fives as $key => $parks)
                            {
                            $line = $parks['name'];    
                            echo '<a href="'.site_url('results/in/name/'.$parks['park_code']."/view_details").'" class="top_park_link">';
                            echo '<div class="col-md-12 park_item">';
                            echo '<div class="col-md-2 count_holder visible-lg"><div class="count">'.($key+1).'</div></div>';
                            echo '<div class="col-md-10 park_details top_six">';
                            echo '<h3 class="park_title">'.$line.'</h3>';
                            echo '<p><i class="fa fa-map-marker"></i> '.($parks["location"]);
                            if(@$parks["att"]) echo ' <i class="fa fa-group af "></i> '.number_format(round($parks["att"]));
                            if(@$parks["tkt"] > 0 ) echo ' <i class="fa fa-ticket af"></i> $'.number_format(round($parks["tkt"]));
                            if(@$parks["park_type_name"]) echo ' <i class="fa fa-bookmark af"></i> '.$parks["park_type_name"];
                            echo '</p>';
                            if($parks['action']=='Added')
                            echo '<img src="'.base_url('assets/images/new-ribbon.png').'" class="new-ribbon"/>';
                            echo '<p class="pull-right date high_Date" style="display: none;">'.date('d-m-Y',strtotime($parks["high_date"])).'</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</a>';
                            
                        ?>
                        <?php } } ?>
                        <div class="fadeout"></div>
                        <div class="clearfix"></div>
                        <div class="btn-holder">
                        <div class="text-center all_top_link">
                        <a href="javascript:void(0);" class="btn btn-default" onclick="$('body, html').animate({scrollTop:$('#searchbox').height()}); $('#searchbox').focus();">SEARCH PARKS </a>
                       </div>
                       </div>
                    </div>
                    <div class="mob_updated_list_opener">
                    <div class="btn-holder">
                        <a href="javascript:void(0);" class="btn btn-default">SEE ALL UPDATED PARKS</a>
                    </div>
                    </div>
                </div>
            </div>
        </div><!-- /container -->
</section>
<section id="top_area">
  <div class="container">
<?php 
    if(@$store_link_homepage){
?>

<div class="col-md-offset-2 col-md-8 storefront_integ">
                <h2><?php echo $store_link_homepage[0]['title'];?></h2>
<div class="clearfix"></div>  
                <div class="row">
                <div class="col-sm-5 img-area" >
                  <img src="<?php echo $image_path.'widget_img/'.$store_link_homepage[0]["image"]; ?>" class="img-responsive">
                </div>
                <div class="col-sm-7 desc-area">
                  <p>
                   <?php echo $store_link_homepage[0]['description'];?>
                  </p>
                  <a href="<?php echo $store_link_homepage[0]['btn_link'];?>" class="btn btn-default btn-lg link-area"><?php echo $store_link_homepage[0]['btn_text'];?></a>
                </div>
<div class="clearfix"></div>  
                </div>
</div><!-- /col-md-6 -->  
<div class="clearfix"></div>  
<?php
    }
?>

<!-- </section>
<section id="top_area"> -->
<div class="col-sm-offset-3 col-sm-6 about_us ">
                <h2>WHAT IS THE PARK DATABASE?</h2>
                <p class="about_us_txt">
               The Park Database aggregates and organizes data on the world's attractions.  We are the database for planners, designers, and consultants working in the attractions industry.
                </p>
</div><!-- /col-md-6 -->  
<div class="clearfix"></div>  
</div><!-- /container -->  
</section>
<?php

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
?>
<section id="countries_area">
        <div class="container text-center">
        <h2 class="white_heading">OVER <?php echo @number_format($counts["parks"]); ?> PARKS AND <?php echo @number_format($counts["rides"]); ?> RIDES IN</h2>
        </div>
    <div id="parent_div"> 
   <div class="frame" id="TouchScroller">
     <div class="flags_holders text-center">
      
      
       <div class="flag_circle first_circle" style="background: #fff url('assets/images/usa_bg.jpg') no-repeat center center;">
           <a href="<?php echo site_url('results/in/country/usa/'); ?>">
            <div class="curtain">
            <img  src="assets/images/usa_flag.png" class="lazy" alt="USA"/>
            <div class="country_name">United States (<?php echo $country_counts["USA"] ?>)</div>
            </div>
           </a>
       </div>
      
      <div class="flag_circle" style="background: #fff url('assets/images/china_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/China/'); ?>">
                <div class="curtain">
                <img  src="assets/images/china_flag.png" class="lazy" alt="CHINA"/>
                <div class="country_name">China (<?php echo $country_counts["China"] ?>)</div>
                </div>
            </a>
       </div>
        
       <div class="flag_circle" style="background: #fff url('assets/images/uae_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/United Arab Emirates/'); ?>">
                <div class="curtain">
                <img  src="assets/images/uae_flag.png" class="lazy" alt="UAE"/>
                <div class="country_name">UAE (<?php echo $country_counts["United Arab Emirates"] ?>)</div>
                </div>
            </a>
       </div>
      
       <div class="flag_circle" style="background: #fff url('assets/images/japan_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/Japan/'); ?>">
                <div class="curtain">
                <img  src="assets/images/japan_flag.png" class="lazy" alt="JAPAN"/>
                <div class="country_name">JAPAN (<?php echo $country_counts["Japan"] ?>)</div>
                </div>
            </a>
       </div>
       
       <div class="flag_circle" style="background: #fff url('assets/images/germany_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/Germany/'); ?>">
                <div class="curtain">
                <img  src="assets/images/germany_flag.png" class="lazy" alt="GERMANY"/>
                <div class="country_name">GERMANY (<?php echo $country_counts["Germany"] ?>)</div>
                </div>
            </a>
       </div>
       
       <div class="flag_circle" style="background: #fff url('assets/images/france_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/France/'); ?>">
                <div class="curtain">
                <img  src="assets/images/france_flag.png" class="lazy" alt="FRANCE"/>
                <div class="country_name">FRANCE (<?php echo $country_counts["France"] ?>)</div>
                </div>
            </a>
       </div>
       <div class="clearfix visible-lg"></div>
       
       <div class="flag_circle first_circle" style="background: #fff url('assets/images/se_bg.jpg') no-repeat center center;">
           <a href="<?php echo site_url('results/in/country/South Korea/'); ?>">
            <div class="curtain">
            <img  src="assets/images/se_flag.png" class="lazy" alt="SOUTH KOREA"/>
            <div class="country_name">SOUTH KOREA (<?php echo $country_counts["South Korea"] ?>)</div>
            </div>
           </a>
       </div>
       
       <div class="flag_circle" style="background: #fff url('assets/images/taiwan_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/Taiwan/'); ?>">
                <div class="curtain">
                <img  src="assets/images/taiwan_flag.png" class="lazy" alt="TAIWAN"/>
                <div class="country_name">TAIWAN (<?php echo $country_counts["Taiwan"] ?>)</div>
                </div>
            </a>
       </div>
       
      <div class="flag_circle" style="background: #fff url('assets/images/uk_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/United Kingdom/'); ?>">
                <div class="curtain">
                <img  src="assets/images/uk_flag.png" class="lazy" alt="UNITED KINGDOM"/>
                <div class="country_name">UNITED KINGDOM (<?php echo $country_counts["United Kingdom"] ?>)</div>
                </div>
            </a>
       </div>
       
        <div class="flag_circle" style="background: #fff url('assets/images/netherlands_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/Netherlands/'); ?>">
                <div class="curtain">
                <img  src="assets/images/netherlands_flag.png" class="lazy" alt="NETHERLANDS"/>
                <div class="country_name">NETHERLANDS (<?php echo $country_counts["Netherlands"] ?>)</div>
                </div>
            </a>
       </div>
       
        <div class="flag_circle" style="background: #fff url('assets/images/brasil_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/Brazil/'); ?>">
                <div class="curtain">
                <img  src="assets/images/brasil_flag.png" class="lazy" alt="BRAZIL"/>
                <div class="country_name">BRAZIL (<?php echo $country_counts["Brazil"] ?>)</div>
                </div>
            </a>
       </div>
       
        <div class="flag_circle" style="background: #fff url('assets/images/mexico_bg.jpg') no-repeat center center;">
            <a href="<?php echo site_url('results/in/country/Mexico/'); ?>">
                <div class="curtain">
                <img  src="assets/images/mexico_flag.png" class="lazy" alt="MEXICO"/>
                <div class="country_name">MEXICO (<?php echo $country_counts["Mexico"] ?>)</div>
                </div>
            </a>
       </div>
       
      
       <div class="clearfix"></div>
        <div class="text-center all_country_link">
        <a href="#" class="btn btn-default light-btn hide">SEE ALL COUNTRIES</a>
       </div>
   </div> 
  </div>  
  </div>   
</section>

<section id="brands_area">
   <div class="container text-center">
    <h2>BRANDS</h2>
   <div class="brands">
                 <div class="brand_link">
                <a href="<?php echo site_url('results/in/brand/disney/'); ?>"><img src="<?php echo base_url('assets/images/logos/disney-parks.png'); ?>" class="lazy" alt="Disney Parks"></a>
                 </div>
                  <div class="brand_link">
                <a href="<?php echo site_url('results/in/brand/Universal%20Studios/'); ?>"><img src="<?php echo base_url('assets/images/logos/Logo_universal-studios.png'); ?>" class="lazy" alt="Universal Studio"></a>
                 </div>
                  <div class="brand_link">
                <a href="<?php echo site_url('results/in/brand/Cedar%20Fair/'); ?>"><img src="<?php echo base_url('assets/images/logos/cedar_fair_logo_detail.jpg'); ?>" class="lazy" alt="Cedar Fair"></a>
                 </div>
                  <div class="brand_link">
                <a href="<?php echo site_url('results/in/brand/Six%20Flags/'); ?>"><img src="<?php echo base_url('assets/images/logos/New_Six_Flags_logo.png'); ?>" class="lazy" alt="Six Flags"></a>
                 </div>
                  <div class="brand_link">
                <a href="<?php echo site_url('results/in/brand/HappyValley'); ?>"><img src="<?php echo base_url('assets/images/logos/happy_valley.png'); ?>" class="lazy" alt="Happy Vally"></a>
                 </div>
                  <div class="brand_link">
                <a href="<?php echo site_url('results/in/brand/Kidzania/'); ?>"><img src="<?php echo base_url('assets/images/logos/logo_Kidzania.png'); ?>" class="lazy" alt="Kidzania"></a>
                 </div>
                  <div class="brand_link">
                <a href="<?php echo site_url('results/in/brand/Lego/'); ?>"><img src="<?php echo base_url('assets/images/logos/legoland.png'); ?>" class="lazy" alt="LegoLand"></a>
                 </div>
            </div>
   </div>
   
   </section>

<?php } ?>
<?php $this->load->view('includes/lib');?> 
<script type="text/javascript" src="<?php echo base_url('assets/js/all_suggestions.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.bcSwipe.min.js');?>"></script>

<!---search---->
<script>
var searchKeyword = 0;
var keywordType = 0;

var options =  {
    minLength: 2,
    delay: 0 ,
    source: function(request, response) {
        var results = $.ui.autocomplete.filter(suggestions, request.term);
        response(results.slice(0, 5));
    },
    select: function(event, ui) {
             event.preventDefault();
             searchKeyword = ui.item.label;
             keywordType = ui.item.t;
             if(keywordType=='name')
             searchKeyword = ui.item.p;
             
             if(keywordType=='brand_name') keywordType = 'brand';
             if(keywordType=='country_name') keywordType = 'country';
             if(keywordType=='continent_name') keywordType = 'continent';
             if(keywordType=='park_type_name') keywordType = 'park_type';
             
             var str = encodeURIComponent(searchKeyword);
             var searchK = str.replace('%2F', '-');
             
             top.location.href="<?php echo site_url('results/in/') ?>/"+keywordType+"/"+searchK;   
            },
     focus: function (event, ui) {
             event.preventDefault();
             $(this).val(ui.item.label);
            }
};
    
var autoComplete = $( "#searchbox" ).autocomplete(options);
var autoCompleteTop = $( "#search_on_top" ).autocomplete(options);                   
autoComplete.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
             var inner_html = '';
             if(item.no_results){// no result found
             inner_html ='<a class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.message+'</div></a>';
             }
             else{
             var subtitle = '';
             if(item.t == 'name')
             subtitle = 'Park';
             if(item.t == 'brand_name')
             subtitle = 'Brand';
             if(item.t == 'country_name')
             subtitle = 'Country';
             if(item.t == 'park_type_name')
             subtitle = 'Type';
             if(item.t == 'location')
             subtitle = 'Location';
             if(item.t == 'continent_name')
             subtitle = 'Continent';
             
             inner_html = '<a  class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.label+'<i class="italic-gray">&nbsp;-&nbsp;'+subtitle+'</i></div></a>';
             }
             return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append(inner_html)
             .appendTo( ul );
 };
autoComplete.keyup(function (e) {
       e.preventDefault();
       if(e.which === 13 || e.keyCode === 13) {
       $(".ui-autocomplete").hide();
       }            
}); 
     
autoCompleteTop.data( "ui-autocomplete" )._renderItem = function( ul, item ) {
             var inner_html = '';
             if(item.no_results){// no result found
             inner_html ='<a class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.message+'</div></a>';
             }
             else{
             var subtitle = '';
             if(item.t == 'name')
             subtitle = 'Park';
             if(item.t == 'brand_name')
             subtitle = 'Brand';
             if(item.t == 'country_name')
             subtitle = 'Country';
             if(item.t == 'park_type_name')
             subtitle = 'Type';
             if(item.t == 'location')
             subtitle = 'Location';
             if(item.t == 'continent_name')
             subtitle = 'Continent';
             
             inner_html = '<a  class="ui-corner-all" tabindex="-1"><div class="search_item_name">'+item.label+'<i class="italic-gray">&nbsp;-&nbsp;'+subtitle+'</i></div></a>';
             }
             return $( "<li></li>" )
             .data( "item.autocomplete", item )
             .append(inner_html)
             .appendTo( ul );
 };
autoCompleteTop.keyup(function (e) {
       e.preventDefault();
       if(e.which === 13 || e.keyCode === 13) {
       $(".ui-autocomplete").hide();
       }            
});      
                           

$('#sub_form').submit(function(e){
       e.preventDefault();
       if($.trim($('#searchbox').val()).length == 0){
        $('#searchbox').focus();
        return false;
       }
       $(".ui-autocomplete").hide();
       searchKeyword = $('#searchbox').val();
       var str = encodeURIComponent(searchKeyword);
       var searchK = str.replace('%2F', '-');
       
       keywordType = 'all';
       top.location.href="<?php echo site_url('results/in/') ?>/"+keywordType+"/"+searchK;   
}); 

$('#top_search_form').submit(function(e){
       e.preventDefault();
       if($.trim($('#search_on_top').val()).length == 0){
        $('#search_on_top').focus();
        return false;
       }
       $(".ui-autocomplete").hide();
       searchKeyword = $('#search_on_top').val();
       var str = encodeURIComponent(searchKeyword);
       var searchK = str.replace('%2F', '-');
       
       keywordType = 'all';
       top.location.href="<?php echo site_url('results/in/') ?>/"+keywordType+"/"+searchK;   
});

$(document).ready(function() {
parallaxBgInit();  
$('.carousel').bcSwipe({ threshold: 50 });
if(isMobile){
    $('#searchbox').attr('placeholder','Search for...');
}  

                    
}); //ready

//var slug = function(str) {
// return str.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
//};


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

/* ---------------------------------------------------------------------- */
/* -------------------------- Platform detect ------------------------- */
/* ---------------------------------------------------------------------- */
var isMobile;
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
    isMobile = true;
    $("html").addClass("mobile");
}
else {
    isMobile = false;
    $("html").addClass("no-mobile");
}
    
    
/* ---------------------------------------------------------------------- */
/* ----------------------  Background Parallax -------------------- */
/* ---------------------------------------------------------------------- */
function parallaxBgInit() {
    if (($(window).width() >= 1200) && (isMobile === false)) {
        $('.parallax').each(function() {
            $(this).parallax("50%", 0.2);
        });
    }
}

/* ---------------------------------------------------------------------- */
/* ----------------------  Read More Jumper -------------------- */
/* ---------------------------------------------------------------------- */
$(".jumper").on('click',function () {
 $('body, html').animate({
scrollTop:$('.about_us').height()+1660
}); 
});


$(document).on('click','.region_option',function(e){
    e.preventDefault();
   $(this).toggleClass('selected'); 
});

$(document).on('click','.select_all_region',function(e){
   e.preventDefault();
   var cont = $(this).data('cont');
   if($(this).hasClass('all_in')){
    $('#'+cont+' li a').removeClass('selected');
    $(this).removeClass('all_in');
    $(this).html('Select all');
   }
   else
   {
    $('#'+cont+' li a').addClass('selected');
    $(this).addClass('all_in');
    $(this).html('Deselect all');
   }
});     
   
$(document).on('click','.show_via_regions',function(e){
   e.preventDefault();
   var cont = $(this).data('cont');
   var selected = [];
   var lis = $('#'+cont+' li a.selected');
   $.each(lis,function(k,v){
    selected.push($(v).data('ccode'));
   });
   if(selected.length>0)
   top.location.href="<?php echo site_url('results/in/countries/'); ?>/"+encodeURIComponent(selected.join(','));
});
    
$(document).on('mouseenter', '[data-toggle="tab"]', function () {
  $(this).tab('show');
});

$(document).on('click','.mob_updated_list_opener',function(e){
    $('.mob_updated_list').css('height','auto');
    $(this).remove();
    $('.fadeout').remove();
});

$(document).mouseup(function (e)
{
    var container = $("#region_tabs_holder");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
      $('#region_tabs_holder .tab-pane').removeClass('active');
      $('#region_tabs li').removeClass('active');
    }
});
</script>