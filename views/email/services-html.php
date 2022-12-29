<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>TheParkDB</title>
    </head>
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="background-color:#efefef; font-family:Helvetica, sans-serif;">
    	<center>
        	<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="600px;" id="bodyTable" style="background-color:#efefef;font-family:Helvetica, sans-serif;color: #505050;">
            	<tr>
                	<td align="center" valign="top" id="bodyCell" style="padding-top:20px;padding-bottom: 20px;">
                    
                    	<table border="0" cellpadding="0" cellspacing="0" id="templateContainer" style="border:1px solid #BBBBBB;">
                        	<tr>
                            	<td align="center" valign="top">
                                	
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader" style="background-color:#fff;" >
                                        <tr>
                                            <td valign="top" class="preheaderContent" style="padding-top:27px; padding-right:20px; padding-bottom:40px; padding-left:20px;color:#fff;font-size:20px;line-height:125%;text-align:left;" >
                                          <a class="brand" href="<?php echo site_url('');?>">
			  		                     <img src="<?php echo base_url('assets/images/logo.png') ?>" alt="TheParkDB"/>
			  	                          </a>  </td>
                                           
                                            
                                            
                                        </tr>
                                    </table>
                                    
                                </td>
                            </tr>
                        	
                        	
                        	<tr>
                            	<td align="center" valign="top">
                                	<!-- BEGIN COLUMNS // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateColumns" style="background: #fff;">
                                      
                                <?php if($_POST['looking_for'] ==  '1') { ?>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Looking For</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                   Customized Services 
                                </td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Full Name</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $customized_servies_fullname;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Phone Or Email</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $customized_servies_email;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Location</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $customized_servies_located;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Description </strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo nl2br($customized_servies_project);?></td>     
                                </tr>
                                <?php } ?>        
                                
                                
                                 <?php if($_POST['looking_for'] ==  '2') { ?>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Looking For</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                   Data 
                                </td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Full Name</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $want_data_fullname;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Phone Or Email</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $want_data_email;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Project</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $want_data_project;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Requirements </strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo nl2br($want_data_describe);?></td>     
                                </tr>
                                <?php } ?>        
                                                    
                               
                                <?php if($_POST['looking_for'] ==  '3') { ?>
                                 <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Looking For</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                   Free assessment of existing plans or reports
                                </td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Full Name</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $plans_reports_fullname;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Phone Or Email</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $plans_reports_email;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Project location</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $plans_reports_located;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Requirements </strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo nl2br($plans_reports_describe);?></td>     
                                </tr>
                                <?php } ?>        
                                
                                
                                 <?php if($_POST['looking_for'] ==  '4') { ?>
                                 <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Looking For</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                   Another question or comment
                                </td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Full Name</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $question_comment_fullname;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Phone Or Email</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $question_comment_email;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Question or comment </strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo nl2br($question_comment_message);?></td>     
                                </tr>
                                
                                <?php } ?>        
                             <br /><br /><br /><br /><br />
                                
                                
                        	   
                        </table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>