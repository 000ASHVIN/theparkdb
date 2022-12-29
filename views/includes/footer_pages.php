<div class="footer_wrapper">
  <footer>
   <div class="container text-center">
    <ul class="footer_menu">
        <li><a href="<?php echo site_url(''); ?>">HOME</a></li>
        <li><a href="<?php echo site_url('results/in/'); ?>">PARKS</a></li>
        <li><a href="<?php echo site_url('pages/about'); ?>">ABOUT</a></li>
        <li><a href="<?php echo site_url('pages/faq'); ?>">FAQ</a></li>
        <li><a href="<?php echo site_url('pages/contact'); ?>">CONTACT</a></li>
    </ul>
    <div class="foot_social">
        <a href="https://www.linkedin.com/company/tpdb/about"><i class="fa fa-linkedin"></i></a>
        <a href="https://twitter.com/theparkdb"><i class="fa fa-twitter"></i></a>
    </div>
    <div class="copyright">&copy; <?php echo date("Y");?>. The Park Database</div>
    
    <div class="to_the_top scrollToTop"><i class="glyphicon glyphicon-chevron-up"></i></div>
   </div>
   </footer>
   </div>
   <!-- Scripts -->
 <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>

 
 <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 <script src="<?php echo base_url('assets/js/ie10-viewport-bug-workaround.js');?>"></script>
  <script src="<?php echo base_url('assets/js/options.js?tim=2');?>"></script>
 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-76078912-1', 'auto');
  ga('send', 'pageview');
  
  
   $(document.body).on('click', '.scrollToTop', function(e) {
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
        return false;
});
    

 $(function(){
    $(".dropdown").hover(            
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            },
            function() {
                $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");                
            });
   $('#apply_loader').hide();         
});

$(document).on('submit','#email_sub_form', function(){
   
   var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   
   if($.trim($('#email_sub input').val()).length==0 || !regex.test($.trim($('#email_sub input').val()))){
    $('#email_sub input').css('background','#FFA2A2');
    return false;
   }
   else{
    $('#email_sub input').css('background','#FFF');
   }
   
   $.ajax({
            type: "POST",
            dataType:'json',
            url: '<?php echo site_url('results/save_email'); ?>',
            data: {email:$.trim($('#email_sub input').val())},
            success: function(result) {
                if(result.status==1)
                {
                $('#email_sub .alert_area').html('<div style="margin-top:5px;"  >'+result.message+'</div>'); 
                setTimeout(function(){$('#disappear0').fadeOut('slow');$('#email_sub').modal('hide');},2000)
                }
                else
                {               
                $('#email_sub .alert_area').empty().html('<div style="margin-top:5px;" >'+result.message+'</div>');
                
                } 
            }
        });
    
    return false;
}); 
    
    
</script>
</body>
</html>