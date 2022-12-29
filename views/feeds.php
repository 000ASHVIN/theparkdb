<style type="text/css">
* { box-sizing: border-box; }
/* ---- grid ---- */

.grid {
  background: #DDD;
}

/* clear fix */
.grid:after {
  content: '';
  display: block;
  clear: both;
}

/* ---- .grid-item ---- */

.grid-sizer,
.grid-item {
  width: 25%;
}

.grid-item {
  float: left;
}

.grid-item img {
  display: block;
  max-width: 100%;
}
</style>
<?php if(!@$bingFeeds){?>
<div class="alert alert-danger col-sm-24 col-md-24 col-lg-24">
<p>No scenes available at this moment.</p>
</div>
<?php } else{?>

<!-- bing feeds----->
<div class="grid">
<div class="grid-sizer"></div>
<div class="gutter-sizer"></div>
                     <?php
                     if($bingFeeds){
                     $count = 0;
                     foreach($bingFeeds as $feed)
                      {
                        if(++$count>12) 
                        break;
                        ?>
                       <div class="grid-item">
                       <a  itemprop="image"  href="<?php echo 'https://www.bing.com/images/search?q='.$q; ?>" target="_blank">
                       <div class="scene_curtain"></div>
                       <i class="fa fa-external-link"></i>
                       <img src="<?php echo $feed; ?>">
                       </a>
                       </div>
                       <?php } } ?>
                       

</div>
<p class="credit">Images From Bing</p>
<?php }?>
<script>
$(document).ready(function(){
 // init Masonry
var $grid = $('.grid').masonry({
  itemSelector: '.grid-item',
  columnWidth: '.grid-sizer',
  gutter: '.gutter-sizer',
  percentPosition: true
});
// layout Isotope after each image loads
$grid.imagesLoaded().progress( function() {
  $grid.masonry();
});     

});//ready
</script>