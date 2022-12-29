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
                                      
                                        
                                                    
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>E-mail</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 3px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo $email;?></td>     
                                </tr>
                                <tr>
                                	<td class="leftColumnContent" style="width: 50%;padding-bottom: 37px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <strong>Message</strong> </td>
                               	<td class="leftColumnContent" style="width: 50%;padding-bottom: 37px;font-size:13px;line-height:150%;padding-top:0;padding-right:20px;padding-left:20px;text-align:left;background: #fff;">
                                    <?php echo nl2br(htmlspecialchars($message));?></td>     
                                </tr>
                            
                        	
                        </table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>
    </body>
</html>