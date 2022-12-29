
<section id="other_page_search_area">
        <div class="container">
            <div class="col-md-offset-3 col-md-6 text-center">
               <h1 class="title-heading"><strong>RANKINGS</strong></h1>
            </div>
        </div>
</section>
<section>
    <div class="top_tabs ranking_tabs">
     <!-- Nav tabs -->
      <div class="container">
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#by_value" aria-controls="by_value" role="tab" data-toggle="tab"><strong>TOP 50</strong> <br />THEME PARKS BY VALUE</a></li>
        <li role="presentation"><a href="<?php echo site_url('ranking/parks_by_attendance'); ?>"><strong>TOP 50</strong> <br />THEME PARKS BY ATTENDANCE</a></li>
       
      </ul>
      </div>
    </div>
    <div class="container">
        <!-- Tab panes -->
        <div class="row">
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="by_value">
        
        <div class="text-center ranking_bottom_link">
            <a  target="_blank"  href="<?php echo site_url('ranking/generate_ranking_by_value_pdf'); ?>" class="btn btn-default">EXPORT AS PDF</a>
         <!-- Go to www.addthis.com/dashboard to customize your tools -->
            <div class="addthis_sharing_toolbox"></div>
            </div>
        
        
        <table class="table ranking-table">
        <?php 
        if($parks)
        {
        foreach($parks as $key => $park){
        $count = $key+1;    
        ?>
            <tr>
                <td style="width: 50px;">
                    <div class="visible-lg"><div class="count"><?php echo $count; ?></div></div>
                </td>
                <td>
                    <div class="label">Name</div>
                    <div class="value"><a href="<?php echo site_url('results/in/name/'.$park["park_code"].'/view_details'); ?>"><?php echo htmlentities($park["name"]); ?></a></div>
                </td>
                <td>
                    <div class="label">Country</div>
                    <div class="value"><a href="<?php echo site_url('results/in/country/'.$park["country_name"]); ?>"><?php echo htmlentities($park["country_name"]); ?></a></div>
                </td>
                <td>
                    <div class="label">Brand</div>
                    <div class="value"><a href="<?php echo site_url('results/in/brand/'.$park["brand_name"]); ?>"><?php echo htmlentities($park["brand_name"]); ?></a></div>
                </td>
                <td>
                    <div class="label">Year Built</div>
                    <div class="value"><?php  echo ($park["year_built"]) ?  htmlentities($park["year_built"]): '-' ; ?></div>
                </td>
                <td>
                    <div class="label">Est. Value</div>
                    <div class="value">$<?php echo htmlentities(bd_nice_number(round($park["est_value_usd"],-3))); ?></div>
                </td>
            </tr>
          <?php } } ?>   
        </table>
        
            
            
        
        </div>
        
        
      </div>
      </div>
    
    </div><!-- /container -->
</section>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5740d795022c9844"></script>
