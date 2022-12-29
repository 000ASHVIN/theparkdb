<section id="page_heading">
    <div class="col-md-offset-3 col-md-6">
               <h1 class="title-heading"><strong><?php echo strtoupper($page[0]->heading); ?></strong></h1>
               <p class="post-heading"><?php echo ($page[0]->sub_heading); ?></p>
    </div>
    </section>
   <section id="page_content" class="mobile-padding-top-60">
        <div class="container">
          <div class="col-md-offset-3 col-md-6 about_us">
                <?php 
                echo $page[0]->content;
                ?>
            </div>
         </div>   
   </section>   