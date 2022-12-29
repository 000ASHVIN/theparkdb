<style>
#ranking td
{
    border-top: 1px solid #ccc;
    padding: 5px;
    text-align: left;
    color: #555;
}
#ranking tr th
{
    padding: 5px;
    text-align: left;
}

#heading{
    color: #3f0c5f;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 5px;
}

a{
    color: #555;
    text-decoration: none;
}
</style>
<page backtop="25mm" backbottom="15mm" backleft="10mm" backright="5mm"> 
<page_header>
    <table style="margin-left: 35px;margin-top: 10px;">
    <tr>
    <td style="width: 620px;">
    <img src="./assets/images/logo.png" style="width: 150px;" />
    </td>
    <td style="text-align: right;width: 355px;" id="heading">TOP 50 PARKS BY VALUE - <?php echo date('F, Y',time()); ?></td>
    </tr>
    </table>
</page_header>
<page_footer>
<p style="text-align: center;color: #666;"><small>&copy; Copyright 2016. The Park Database. All Rights Reserved.</small></p>
</page_footer>

<table id="ranking" class="table ranking-table table-bordered">
        <?php 
        if($parks)
        {
        echo '<tr><th>#</th><th>Park Name</th><th>Country</th><th>Brand</th><th>Year Built</th><th>Est. Value</th></tr>';    
        foreach($parks as $key => $park){
        $count = $key+1;    
        ?>
            <tr>
                <td style="width: 20px;">
                    <?php echo $count; ?>
                </td>
                <td style="width: 350px;">
                  <div class="value"><?php echo htmlentities($park["name"]); ?></div>
                </td>
                <td style="width: 110px;">
                   <div class="value"><?php echo htmlentities($park["country_name"]); ?></div>
                </td>
                <td style="width: 120px;">
                   <div class="value"><a href="<?php echo site_url('results/in/brand/'.$park["brand_name"]); ?>"><?php echo htmlentities($park["brand_name"]); ?></a></div>
                </td>
                <td style="width: 100px;">
                   <div class="value"><?php  echo ($park["year_built"]) ?  htmlentities($park["year_built"]): '-' ; ?></div>
                </td>
                <td style="width: 160px;">
                    <div class="value">$<?php echo htmlentities(number_format(round($park["est_value_usd"],-3))); ?></div>
                </td>
            </tr>
          <?php } } ?>   
</table>
</page>