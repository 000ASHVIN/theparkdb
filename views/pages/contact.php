    <style>
    .social a i{
        color: #3f0c5f;
        font-size: 24px;
        padding: 10px;
        padding-left: 0px;
    }
    </style>
    <section id="page_heading">
    <div class="col-md-offset-3 col-md-6">
               <h1 class="title-heading"><strong>CONTACT</strong></h1>
               <p class="post-heading">Have a correction?  Submission?  Opportunity? <br /> Words of praise?</p>
    </div>
    </section>
   <section id="page_content">
        <div class="container">
            <br />
            <p class="about_us_txt">Please contact us for data services or custom analyses.</p>
            
            <br />
            <div class="col-md-offset-2 col-md-8 contact_wrapper">
            
            <div class="col-md-5 info" >
                    <div class="contact_info">
                        CONTACT INFO
                    </div>
                    <div class="call_contact  hide">
                        <span class="fa fa-phone" aria-hidden="true"></span>
                        <a href="tel:012125856587">012 125 856 587</a>
                    </div>
                    <div class="email_contact">
                        <span class="fa fa-envelope-o" aria-hidden="true"></span>
                        <a href="mailto:data@theparkdb.com">data@theparkdb.com</a><br />
                        <div class="social">
                        
                        <a href="https://www.linkedin.com/company/tpdb/about"><i class="fa fa-linkedin"></i></a>
                        <a href="https://twitter.com/theparkdb"><i class="fa fa-twitter"></i></a>
                        </div>
                    </div>
                    <div class="address_contact hide">
                        <span class="fa fa-map-marker" aria-hidden="true"></span>
                        <ul>AA office<br />
                        22 Pink Road<br />
                        Holliday city, La 2211</ul>
                    </div>
              </div>
              <div class="col-md-7 form_div">
                    
                    <p>SEND US A MESSAGE</p>
                        <form id="contact_form" method="post"> 
                                <div class="row">
                                    <div class="form-group col-md-12 form_info">
                                        <label class="control-label">Contact info</label>
                                        <input type="text" name="email" id="email" placeholder="Enter your phone or e-mail" class="form-control"/>
                                        <span class="red" id="email_err"></span>
                                    </div>
                                    <div class="form-group col-md-12 form_info">
                                        <label class="control-label">Your message</label>
                                        <textarea rows="5" name="message" id="message" class="form-control" ></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" id="submit" class="btn btn-default">SEND MESSAGE</button>
                                        <div id="alert_area1"> </div>
                                    </div>
                                </div>
                            </form>
                    
                </div>
                
            </div>
         </div>   
   </section>
   
   <script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click','#submit',function(){
            var email = $.trim($('#email').val());
            var message = $.trim($('#message').val());
           
           if(email.length == 0)
           {
            $('#email').css("border","1px solid red");
            $('#email').focus();
				return false;
           }else{
            $('#email').css("border","1px solid #ccc");
           }
           
           if(message.length == 0)
           {
            $('#message').css("border","1px solid red");
            $('#message').focus();
				return false;
           }else{
            $('#message').css("border","1px solid #ccc");
           }
           
           var values = $('#contact_form').serialize();
           
            $.ajax({
                url:'<?php echo site_url('pages/contact_form');  ?>',
                dataType:'JSON',
                type:'POST',
                data:values,
                success:function(data){
                    if(data.status == 1)
                    {
                    $('#alert_area1').empty().html('<div class="alert alert-success  alert-dismissable" id="disappear"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data.message+'</div>');
                    setTimeout(function(){$('#disappear').fadeOut('slow')},3000);
                    $('#contact_form')[0].reset();
                    }else{
                    $('#alert_area1').empty().html('<div class="alert alert-danger  alert-dismissable" id="disappear"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data.message+'</div>');
                    }
                }
            });
            return false;
        });

});
</script>