<link rel="stylesheet" href="<?php echo base_url('assets/css/unslider.css');?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/unslider-dots.css');?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/upload.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css'); ?>"/>
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.wordrotator.css'); ?>"/>
<style type="text/css">
input{
  width:200px;
  border:none;
  border-bottom:1px solid #3f0c5f;
  color: #3f0c5f;
  font-style: bold;
}
.project{
  width:510px;
}

.storefront_integ p.simple {
    font-size: 16px;
    line-height: 26px;
    color: #000000;
    font-weight: 300;
    text-align: justify;
    margin-top: 0.7em;
    margin-bottom: 1em;
    font-family: 'Raleway', sans-serif;
    padding-right: 20px;
}
</style>
<section id="services_page_heading" >
	<div class="col-md-offset-3 col-md-6">
			   <h1 class="title-heading"><strong>OUR SERVICES</strong></h1>
         <h3 class="title-subheading">Our team helps <span class="word-subheading" id="tile"></span> make sense<br /> of attractions and leisure projects.</h3>
         <p class="title_txt title_txt_service">By utilizing our significant base of proprietary technology and knowledge, we provide value-add analyses on markets, competitors, project economics, and feasibility. <strong>It is our mission to see attractions planned and built in an effective, sustainable, and feasible manner.</strong></p>
	</div>

</section>
<section id="page_content"  style="overflow: auto;">
	<div class="container">

<?php 
    if(@$store_link_servicepage){
?>

<div class="col-sm-offset-2 col-sm-8 storefront_integ">
                <h2><?php echo $store_link_servicepage[0]['title'];?></h2>
<div class="clearfix"></div>  
                <div class="row">
                <div class="col-sm-5 img-area" >
                  <img src="<?php echo $image_path.'widget_img/'.$store_link_servicepage[0]["image"]; ?>" class="img-responsive">
                </div>
                <div class="col-sm-7 desc-area">
                  <p class="simple">
                   <?php echo $store_link_servicepage[0]['description'];?>
                  </p>
                  <a href="<?php echo $store_link_servicepage[0]['btn_link'];?>" class="btn btn-default btn-lg link-area"><?php echo $store_link_servicepage[0]['btn_text'];?></a>
                </div>
<div class="clearfix"></div>  
                </div>
</div><!-- /col-md-6 -->  
<div class="clearfix"></div>  
<?php
    }
?>

		<div class="col-xs-12 col-md-offset-3 col-md-6 services hidden">
			<h2>Planning an Attractions Project?</h2>
            <p class="services_txt">
		    Contact our analytics team for an independent, free assessment of the economic and sizing guidance you need from seasoned industry veterans.  Reducing uncertainty early helps you make better and more timely decisions.  This is our function.  

            </p>
               
            <div id="services_ques">
              <a class="btn btn-default get_start link-area" >GET STARTED</a>
            </div>
            <div class="clearfix"></div>
		</div>
        <div class="clearfix"></div>
	</div>   
</section>
<section class="page_contentx" >
  <div class="container">
    <div class="services">
      <h2>We Help</h2>
      <div class="clearfix"></div>
        <div class="col-sm-6 services_hep_holder" style="margin-top: 30px;">
          <div class="col-xs-2"> <img src="<?php echo base_url('assets/images/rocket.png') ?>"></div>
          <div class="col-xs-10">
            <p class="help_txt"><strong>Developers:</strong></p>
            <ul class="service_list">
              <li>
               <span> <i class="fa fa-circle"></i> Understand the economics of your project </span>
              </li>
              <li>
               <span> <i class="fa fa-circle"></i> Conduct feasibility studies, or audit existing reports</span>
              </li>
              <li>
               <span> <i class="fa fa-circle"></i> Guide you through preliminary development </span>
              </li>
            </ul>
          </div>
      
      </div>
        
        <div class="col-sm-6 services_hep_holder" style="margin-top: 30px;">
          <div class="col-xs-2"><img src="<?php echo base_url('assets/images/case.png') ?>"></div>
          <div class="col-xs-10">
            <p class="help_txt"><strong>Brand Owners:</strong></p>
            <ul class="service_list">
              <li>
               <span>  <i class="fa fa-circle"></i> Develop business plans, or audit existing ones</span>
              </li>
              <li>
               <span>  <i class="fa fa-circle"></i> Understand the value of your brand </span>
              </li>
              <li>
                <span>  <i class="fa fa-circle"></i> Vet potential licensees  </span>
              </li>
            </ul>
          </div>
        </div>
        

  
        <div class="col-sm-6 services_hep_holder" style="margin-top: 30px;">
          <div class="col-xs-2"><img src="<?php echo base_url('assets/images/maze.png') ?>"></div>
          <div class="col-xs-10">
            <p class="help_txt"><strong>Designers and planners:</strong></p>
            <ul class="service_list">
              <li>
               <span> <i class="fa fa-circle"></i> Design pitch documents </span>
              </li>
              <li>
               <span> <i class="fa fa-circle"></i> Calibrate sizing </span>
              </li>
              <li>
               <span> <i class="fa fa-circle"></i> Develop master plans</span>
              </li>
            </ul>
          </div>
        </div>
       
  
  
  
        <div class="col-sm-6 services_hep_holder" style="margin-top: 30px;">
          <div class="col-xs-2"><img src="<?php echo base_url('assets/images/bar.png') ?>"></div>
          <div class="col-xs-10">
            <p class="help_txt"><strong>Investors and researchers:</strong></p>
            
            <ul class="service_list">
              <li>
                <span>  <i class="fa fa-circle"></i> Aid your equity research </span>
              </li>
              <li>
               <span> <i class="fa fa-circle"></i> Audit existing models</span>
              </li>
              <li>
               <span> <i class="fa fa-circle"></i> Receive structured data </span>
              </li>
              <li>
               <span> <i class="fa fa-circle"></i> Issue opinion letters </span>
              </li>
            </ul>
          </div>
        </div>  
        
          
      <div id="services_ques">
        <a  class="btn btn-default get_start link-area">GET STARTED</a>
      </div>
    </div>
  </div>   
</section> 
<section  class="page_contentx" id="ask_content" style="overflow: auto;">
<div class="col-md-6 col-md-offset-3 text-center hidden">
		<div class="page_foo"><strong>Customized Reports:</strong> need something else?  <br />Have a need only for data?</div>
		<a class="btn btn-default get_start" href="#">ASK US</a>
	</div>

    <div class="col-sm-offset-2 col-sm-8 services">
      <h2>STILL NEED HELP?</h2>
            <p class="services_txt">
        Contact our analytics team for an independent, free assessment of the economic and sizing guidance you need from seasoned industry veterans.  Reducing uncertainty early helps you make better and more timely decisions.  This is our function.  

            </p>
               
            <div id="services_ques" style="margin-bottom: 0px;">
              <a class="btn btn-default get_start link-area" style="margin-bottom: 0px;" >GET STARTED</a>
            </div>
            <div class="clearfix"></div>
    </div>
</section> 


<div class="modal fade service_quote" tabindex="-1" role="dialog" id="view_park"  data-backdrop="static" >
  <div class="modal-dialog" role="document">
    <div class="modal-content" >
     <form class="service_quote_form" id="service_quote_form" enctype="multipart/form-data">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fa fa-times-circle"></i>
        </button>
        <h4 class="modal-title">SEND US A MESSAGE</h4>
      </div>
      <div class="modal-body">
        <div class="form-group" style="margin-left: 5px;">
        <h6>I am looking for..</h6>
        <div class="btn-group ash" data-toggle="buttons" role="group">
          <label class="btn button_toggle active" >
            <input type="radio" name="looking_for" class="form-control" value="1" checked/>
            <span>Customized servies</span>
          </label>
          <label class="btn button_toggle" style="margin-left: 15px;">
            <input type="radio" name="looking_for" class="form-control" value="2" />
           <span> Want data </span>
          </label>
          <label class="btn button_toggle" style="margin-left: 15px;">
            <input type="radio" name="looking_for" class="form-control" value="3" />
            <span>Free assessment of existing plans or reports</span>
          </label>
          <label class="btn button_toggle" style="margin-left: 15px;">
            <input type="radio" name="looking_for" class="form-control"  value="4" />
           <span> Another question or comment </span>

          </label>                       
        </div>
      </div>
      <div id="append_hidden_file"></div>
      <div class="form-group customized_servies" id="customized1">
        <p>My name is <input type="text" style="border-top-style: none;" id="customized_servies_fullname"  name="customized_servies_fullname" placeholder="Your name"><span class="hidden-xs">,</span> and you can reply to me at <input type="text" id="customized_servies_email" name="customized_servies_email" placeholder="Enter your phone or email"></p>
        <p>My project is located in  <input type="text" class="project" name="customized_servies_located" id="customized_servies_located" placeholder="Country">.</p>

        <p class="hide">Project description and service specification</p>
        <textarea class="form-control" id="customized_servies_project" name="customized_servies_project" cols="30" style="height: 190px;width:100%;" placeholder="Project description and service specification" ></textarea>
      </div>

       <div class="form-group want_data" id="customized2" style="display:none">
        <p>My name is <input type="text" id="want_data_fullname" name="want_data_fullname" placeholder="Your name"><span class="hidden-xs">,</span> and you can reply to me at <input type="text" id="want_data_email" name="want_data_email" placeholder="Enter your phone or email"></p>
        <p>I would like a quote for   <input type="text" id="want_data_project" class="project" name="want_data_project" placeholder="Project">.</p>

        <p class="hide">Describe data requirements</p>
        <textarea class="form-control" cols="30" id="want_data_describe" name="want_data_describe" style="height: 190px;width:100%;" placeholder="Describe your requirements" ></textarea>
      </div>

         <div class="form-group plans_reports" id="customized3" style="display:none">
        <p>My name is <input type="text" id="plans_reports_fullname" name="plans_reports_fullname" placeholder="Your name"><span class="hidden-xs">,</span> and you can reply to me at <input type="text" id="plans_reports_email"  name="plans_reports_email" placeholder="Enter your phone or email"></p>
        <p>My project is located in  <input type="text" id="plans_reports_located" class="project" name="plans_reports_located" placeholder="Country">.</p>

        <p class="hide">Project description and service specification</p>
        <textarea class="form-control" cols="30" id="plans_reports_describe" name="plans_reports_describe" style="height: 190px;width:100%;" placeholder="Project description and service specification" ></textarea>
      </div>

         <div class="form-group question_comment" id="customized4" style="display:none">
        <p>My name is <input type="text" id="question_comment_fullname" name="question_comment_fullname" placeholder="Your name"><span class="hidden-xs comma">,</span> and you can reply to me at <input type="text" id="question_comment_email" name="question_comment_email" placeholder="Enter your phone or email"></p>

        <p class="hide">Your question or comment </p>
        <textarea class="form-control" cols="30" id="question_comment_message" name="question_comment_message" style="height: 190px;width: 100%;" placeholder="Your question or comment " ></textarea>
      </div>

      <div class="row">
        <div class="col-md-12">
              <div class="demo_container">
                    <div class="demo_example">
                      
                            <div class="upload"></div>
                            <div class="filelists">
                                
                                <ol class="filelist complete">
                                </ol>
                                
                                <ol class="filelist queue">
                                </ol>
                                
                            </div>
                      
                    </div>
                
                </div>

        </div>
      </div>


      <div class="clearfix"></div>
      </div>
      <div class="modal-footer">
        <div class="row">
     
          <div class="col-md-3 sub0holder">
            <button type="submit" class="btn btn-default sub-btn">SEND MESSAGE</button>
          </div>
          
          <div class="col-md-9 service_privacy" >
          <div class="media">
              <img class="mr-3 pull-left" src="<?php echo base_url('assets/images/lock.png'); ?>" >
              <div class="media-body">
                
                 We take your privacy seriously, and will not share your information with any 3rd party without your permission. Our multi-level corporate security policies and procedures ensure prevention from loss, misuse or unauthorized distribution of any business-sensitive information you share with us. 
                     
                </div>
            </div>
            </div>
            <div class="clearfix"><br /></div>
            <div class="col-md-12" >
           <div id="alert_area1" style="margin-top: 10px;"></div>
           </div>
        </div>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?php echo base_url('assets/js/icheck.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/unslider.min.js');?>"></script>
<script src="<?php echo base_url('assets/js/core.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/upload.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.wordrotator.min.js'); ?>"></script>

<script>


$(document).ready(function(){
   
   	$("#tile").wordsrotator({
					words: ['developers', 'licensors', 'investors', 'equity researchers', 'designers', 'planners'],
					animationIn: "fadeInDown",
					animationOut: "fadeOutDown",
					speed: 2000
				});

 /*    
        $('.banner').unslider({
      speed: 900,               //  The speed to animate each slide (in milliseconds)
      delay: 5000,              //  The delay between slide animations (in milliseconds)
      keys: true,               //  Enable keyboard (left, right) arrow shortcuts
      dots: true,               //  Display dot navigation
      autoplay: true,
      arrows: false
        });
    */    

  $('input[name="looking_for"]').on('change',function(){
   var value_looking = $('input[name="looking_for"]:checked').val();

   if(value_looking == '1'){
    $('#customized1').removeAttr('style');
    $('#customized2').css('display','none');
    $('#customized3').css('display','none');
    $('#customized4').css('display','none');

    $('#question_comment_fullname').val('');
    $('#question_comment_email').val('');
    $('#question_comment_message').val('');

    $('#plans_reports_fullname').val('');
    $('#plans_reports_email').val('');
    $('#plans_reports_located').val('');
    $('#plans_reports_describe').val('');
    
    
    $('#want_data_fullname').val('');
    $('#want_data_email').val('');
    $('#want_data_describe').val('');
    $('#want_data_project').val('');
    
    
   }
   if(value_looking == '2'){
    $('#customized2').removeAttr('style');
    $('#customized1').css('display','none');
    $('#customized3').css('display','none');
    $('#customized4').css('display','none');

    $('#question_comment_fullname').val('');
    $('#question_comment_email').val('');
    $('#question_comment_message').val('');

    $('#plans_reports_fullname').val('');
    $('#plans_reports_email').val('');
    $('#plans_reports_located').val('');
    $('#plans_reports_describe').val('');
    
    
    $('#customized_servies_fullname').val('');
    $('#customized_servies_email').val('');
    $('#customized_servies_located').val('');
    $('#customized_servies_project').val('');
    
   }
   if(value_looking == '3'){
    $('#customized3').removeAttr('style');
    $('#customized2').css('display','none');
    $('#customized1').css('display','none');
    $('#customized4').css('display','none');

    $('#question_comment_fullname').val('');
    $('#question_comment_email').val('');
    $('#question_comment_message').val('');

    $('#customized_servies_fullname').val('');
    $('#customized_servies_email').val('');
    $('#customized_servies_located').val('');
    $('#customized_servies_project').val('');
    
    
    $('#want_data_fullname').val('');
    $('#want_data_email').val('');
    $('#want_data_describe').val('');
    $('#want_data_project').val('');
    
   }
   if(value_looking == '4'){
    $('#customized4').removeAttr('style');
    $('#customized2').css('display','none');
    $('#customized3').css('display','none');
    $('#customized1').css('display','none');


    $('#plans_reports_fullname').val('');
    $('#plans_reports_email').val('');
    $('#plans_reports_located').val('');
    $('#plans_reports_describe').val('');
    $('#customized_servies_fullname').val('');
    $('#customized_servies_email').val('');
    $('#customized_servies_located').val('');
    $('#customized_servies_project').val('');
    
    
    $('#want_data_fullname').val('');
    $('#want_data_email').val('');
    $('#want_data_describe').val('');
    $('#want_data_project').val('');

   }
   
  });

  $(document).on('submit','#service_quote_form',function(){
         var value_looking = $('input[name="looking_for"]:checked').val();

           if(value_looking == '1'){
               if($.trim($('#customized_servies_fullname').val()).length == 0)
               {
                $('#customized_servies_fullname').css("border","1px solid red");
                $('#customized_servies_fullname').focus();
            return false;
               }else{
                $('#customized_servies_fullname').css("border","1px solid #ccc");
               }
               
                
                if($.trim($('#customized_servies_email').val()).length == 0)
                {
                $('#customized_servies_email').css("border","1px solid red");
                $('#customized_servies_email').focus(); return false;
                }
                else{
                $('#customized_servies_email').css("border","1px solid #ccc");
                }
                
               if($.trim($('#customized_servies_located').val()).length == 0)
               {
                $('#customized_servies_located').css("border","1px solid red");
                $('#customized_servies_located').focus();
            return false;
               }else{
                $('#customized_servies_located').css("border","1px solid #ccc");
               }
               
               if($.trim($('#customized_servies_project').val()).length < 10)
               {
                $('#customized_servies_project').css("border","1px solid red");
                $('#customized_servies_project').focus();
            return false;
               }else{
                $('#customized_servies_project').css("border","1px solid #ccc");
               }
               
              
           }
           if(value_looking == '2'){
              if($.trim($('#want_data_fullname').val()).length == 0)
               {
                $('#want_data_fullname').css("border","1px solid red");
                $('#want_data_fullname').focus();
            return false;
               }else{
                $('#want_data_fullname').css("border","1px solid #ccc");
               }
               
                
                if($.trim($('#want_data_email').val()).length == 0)
                {
                $('#want_data_email').css("border","1px solid red");
                $('#want_data_email').focus(); return false;
                }
                else{
                $('#want_data_email').css("border","1px solid #ccc");
                }
                
               if($.trim($('#want_data_project').val()).length == 0)
               {
                $('#want_data_project').css("border","1px solid red");
                $('#want_data_project').focus();
            return false;
               }else{
                $('#want_data_project').css("border","1px solid #ccc");
               }
               
               if($.trim($('#want_data_describe').val()).length < 10)
               {
                $('#want_data_describe').css("border","1px solid red");
                $('#want_data_describe').focus();
            return false;
               }else{
                $('#want_data_describe').css("border","1px solid #ccc");
               }
            
           }
           if(value_looking == '3'){
              if($.trim($('#plans_reports_fullname').val()).length == 0)
               {
                $('#plans_reports_fullname').css("border","1px solid red");
                $('#plans_reports_fullname').focus();
            return false;
               }else{
                $('#plans_reports_fullname').css("border","1px solid #ccc");
               }
               
                
                if($.trim($('#plans_reports_email').val()).length == 0)
                {
                $('#plans_reports_email').css("border","1px solid red");
                $('#plans_reports_email').focus(); return false;
                }
                else{
                $('#plans_reports_email').css("border","1px solid #ccc");
                }
                
               if($.trim($('#plans_reports_located').val()).length == 0)
               {
                $('#plans_reports_located').css("border","1px solid red");
                $('#plans_reports_located').focus();
            return false;
               }else{
                $('#plans_reports_located').css("border","1px solid #ccc");
               }
               
               if($.trim($('#plans_reports_describe').val()).length < 10)
               {
                $('#plans_reports_describe').css("border","1px solid red");
                $('#plans_reports_describe').focus();
            return false;
               }else{
                $('#plans_reports_describe').css("border","1px solid #ccc");
               }
            
           }
           if(value_looking == '4'){
              if($.trim($('#question_comment_fullname').val()).length == 0)
               {
                $('#question_comment_fullname').css("border","1px solid red");
                $('#question_comment_fullname').focus();
            return false;
               }else{
                $('#question_comment_fullname').css("border","1px solid #ccc");
               }
               
                
                if($.trim($('#question_comment_email').val()).length == 0)
                {
                $('#question_comment_email').css("border","1px solid red");
                $('#question_comment_email').focus(); return false;
                }
                else{
                $('#question_comment_email').css("border","1px solid #ccc");
                }
                
               if($.trim($('#question_comment_message').val()).length == 0)
               {
                $('#question_comment_message').css("border","1px solid red");
                $('#question_comment_message').focus();
            return false;
               }else{
                $('#question_comment_message').css("border","1px solid #ccc");
               }
           }
           var values = $('#service_quote_form').serialize();
           
            $.ajax({
                url:'<?php echo site_url('pages/services_form');  ?>',
                dataType:'json',
                type:'POST',
                data:values,
                success:function(data){
                    if(data.status == 1)
                    {
                    $('#alert_area1').empty().html('<div class="alert alert-success  alert-dismissable" id="disappear"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data.message+'</div>');
                    setTimeout(function(){$('#disappear').fadeOut('slow')},3000);
                    $('#service_quote_form')[0].reset();
                     $('#append_hidden_file').empty();
                    $('.complete').empty();

                    }else{
                    $('#alert_area1').empty().html('<div class="alert alert-danger  alert-dismissable" id="disappear"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data.message+'</div>');
                    }
                }
            });
            return false;
        });




   $('.get_start').click(function(){
        
        $('#view_park').modal('show');
   }); 
   
  
   
   
});



                   Formstone.Ready(function() {
                        $(".upload").upload({
                                maxSize: 1073741824,
                                postData: onBeforeSend,
                                action : "<?php echo site_url('pages/ImageuploadDzone') ?>"
                            }).on("start.upload", onStart)
                            .on("complete.upload", onComplete)
                            .on("filestart.upload", onFileStart)
                            .on("fileprogress.upload", onFileProgress)
                            .on("filecomplete.upload", onFileComplete)
                            .on("fileerror.upload", onFileError)
                            .on("queued.upload", onQueued);

                        $(".filelist.queue").on("click", ".cancel", onCancel);
                        $(".cancel_all").on("click", onCancelAll);
                    });

                    function onCancel(e) {
                        //console.log("Cancel");
                        var index = $(this).parents("li").data("index");
                        $(this).parents("form").find(".upload").upload("abort", parseInt(index, 10));
                    }

                    function onCancelAll(e) {
                        //console.log("Cancel All");
                        $(this).parents("form").find(".upload").upload("abort");
                    }

                    function onBeforeSend(formData, file) {
                        //console.log("Before Send");
                        formData.append("test_field", "test_value");
                        // return (file.name.indexOf(".jpg") < -1) ? false : formData; // cancel all jpgs
                        //console.log(formData );
                        return formData;
                    }

                    function onQueued(e, files) {
                        //console.log("Queued");
                        var html = '';
                        //console.log(files);
                        for (var i = 0; i < files.length; i++) {
                            html += '<li data-index="' + files[i].index + '"><span class="content"><span class="file">' + files[i].name + '</span><span class="cancel">Cancel</span><span class="progress">Queued</span></span><span class="bar"></span></li>';
                        }

                        $(this).parents("form").find(".filelist.queue").append(html);
                    }

                    function onStart(e, files) {
                        //console.log("Start");
                        $(this).parents("form").find(".filelist.queue")
                            .find("li")
                            .find(".progress").text("Waiting");
                    }

                    function onComplete(e) {
                        //console.log("Complete");
                        // All done!
                    }

                    function onFileStart(e, file) {
                        //console.log("File Start");
                        $(this).parents("form").find(".filelist.queue")
                            .find("li[data-index=" + file.index + "]")
                            .find(".progress").text("0%");
                    }

                    function onFileProgress(e, file, percent) {
                        //console.log("File Progress");
                        var $file = $(this).parents("form").find(".filelist.queue").find("li[data-index=" + file.index + "]");

                        $file.find(".progress").text(percent + "%")
                        $file.find(".bar").css("width", percent + "%");
                    }

                    function onFileComplete(e, file, response) {
                        //console.log("File Complete");

                        if (response.trim() === "" || response.toLowerCase().indexOf("error") > -1) {
                            $(this).parents("form").find(".filelist.queue")
                                .find("li[data-index=" + file.index + "]").addClass("error")
                                .find(".progress").text(response.trim());
                        } else {
                            var $target = $(this).parents("form").find(".filelist.queue").find("li[data-index=" + file.index + "]");
                            $target.find(".file").text(file.name);
                            $target.find(".progress").remove();
                            $target.find(".cancel").remove();
                            $target.appendTo($(this).parents("form").find(".filelist.complete"));
                        }

                       $('#append_hidden_file').append("<input type='hidden' class='file_name' name='file_name[]' value='"+response+"'>");

                    }

                    function onFileError(e, file, error) {
                        console.log("File Error");
                        $(this).parents("form").find(".filelist.queue")
                            .find("li[data-index=" + file.index + "]").addClass("error")
                            .find(".progress").text("Error: " + error);
                    }



                </script>

