<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php echo $title;?></title>
    <meta name="description" content="Here goes description" />
    <meta name="author" content="author name" />
    <link rel="shortcut icon" href="#" type="image/x-icon" />

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Style CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/nouislider.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/screen.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.multiselect.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>" />
    
    
   	<script src="<?php echo base_url('assets/js/jquery.js');?>"></script>
</head>
<body data-smooth-scroll="on">

	<!-- Page Wrapper -->
	<div id="page">
		<!-- Header -->
		<header>
			<!-- Navigation -->
			<nav class="main_menu">
				<ul>
					<li class="home current-menu-item"><a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i>HOME</a></li>
					<li class="listing"><a href="#"><i class="fa fa-star"></i>ABOUT</a></li>
					<li class="property"><a href="#"><i class="fa fa-question"></i>FAQ</a></li>
					<li class="agents"><a href="#"><i class="fa fa-phone"></i>CONTACT</a></li>
				</ul>
			</nav>
        <div class="left-block col-md-8">
        			<!-- Identity image -->
        			<a href="<?php echo site_url(); ?>" class="brand">
        				<img src="<?php echo base_url('assets/img/logo.png');?>" alt="logo" />
        			</a>
                 </div>  
        	<!-- Social Block & Login -->
			<div class="right-block col-md-6">
			 <span class="menu-toggle cmn-toggle-switch cmn-toggle-switch__htx pull-right">
    				<span>toggle menu</span>
    			</span>
				
                	<!-- Menu Toggle -->
               <ul class="social-block pull-right">
					<li><a href="#"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter"></i></a></li>
					<li><a href="#"><i class="fa fa-instagram"></i></a></li>
					<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
				</ul>
			</div>
            <div class="btn-group view_options" role="group" aria-label="...">
             </div>
           
		</header>