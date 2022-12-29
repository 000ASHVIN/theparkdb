<!DOCTYPE html>
<!-- Microdata markup added by Google Structured Data Markup Helper. -->
<html lang="en">
  <head>
  
   	<meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php echo $title;?></title>
    <meta name="description" content="The Park Database aggregates and organizes data on the world's attractions. We are the database for planners, designers, and consultants working in the attractions industry." />
    <meta name="author" content="theparkdb.com" />
    <link rel="shortcut icon" href="#" type="image/x-icon" />
    <meta name="google-site-verification" content="XutobjZD7kfwz0JKCXsZFW4pyfvgqnZa84etAyUhDJ4" />
    
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#8200f8">

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
   <script src="<?php echo base_url('assets/js/pace.min.js');?>"></script>
    <!-- Custom Fonts CSS -->
     <?php if(@$this->session->userdata("user_ip_address") == 'CN' ) { ?>
    <link href='https://fonts.useso.com/css?family=Lora:400,400italic,700,700italic|Raleway:400,700,500' rel='stylesheet' type='text/css'>
    <?php } else { ?>
    <link href='https://fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic|Raleway:400,700,500' rel='stylesheet' type='text/css'>
    <?php } ?>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"> 
    
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/nouislider.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.multiselect.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/jquery.mCustomScrollbar.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/pace-theme-minimal.css');?>" />
     
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/custom_ver11.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/table.css');?>" />
    <link href="<?php echo base_url('assets/css/skins/square/purple.css'); ?>" rel="stylesheet">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
 <?php if(@$this->session->userdata("user_ip_address") == 'CN' ) { ?>
    <script src="https://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
    <?php } else { ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php } ?>   
 
 <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
 <script src="<?php echo base_url('assets/js/jquery-ui.min.js');?>"></script>
 <script async="" defer="" src="//survey.g.doubleclick.net/async_survey?site=tsur5d4e6u2bufqqocpjy6c6q4"></script>
 
<?php
if(strpos( $_SERVER['HTTP_HOST'], 'www.theparkdb.com') !== false){
?>   

 
<?php
}
else{
?> 
 <!-- Hotjar Tracking Code for http://test.theparkdb.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:883518,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
<?php } ?>
 <style>
 .foot_social{
    margin-bottom: 20px;
 }
 .foot_social a{
    color: #fff;
    font-size: 24px;
    padding: 7px;
 }
 
 footer {
    height: 314px;
}
 </style>
  </head>

  <body>
<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo site_url(); ?>">
          <?php if($this->uri->segment(2)=='services'){ ?>
          <img src="<?php echo base_url('assets/images/logo_services.png'); ?>" alt="TheParkDatabase" class="logo s_logo" />
          <?php } else { ?>
          <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="TheParkDatabase" class="logo" />
          <?php } ?>
          </a>
        </div>
       
        <div id="navbar">
          <ul class="nav navbar-nav navbar-right">
            <li>
                <form class="form-inline" role="form" id="top_search_form">
    			<div class="input-group">
                   <input name="search_on_top" id="search_on_top" placeholder="Search..."  autocomplete="off" />
                   <div class="input-group-btn">
                      <button type="submit" class="btn-submit"><i class="glyphicon glyphicon-search"></i></button>
            	   </div><!-- /btn-group -->
                </div>
                
    			</form>
            </li>
            <li class="hidden-sm hidden-xs"><a href="<?php echo site_url(); ?>">HOME</a></li>
            <li class="visible-sm visible-xs"><a href="https://www.linkedin.com/company/tpdb/about"><i class="fa fa-linkedin"></i></a></li>
			<li class="visible-sm visible-xs"><a href="https://twitter.com/theparkdb"><i class="fa fa-twitter"></i></a></li>
            <li class=""><a href="https://store.theparkdb.com/" id="services_link">STORE</a></li>
            <li class="hidden-sm hidden-xs"><a href="<?php echo base_url('blog'); ?>">BLOG</a></li>
            <li class="dropdown" style="display: none;">
            <a href="#" data-toggle="dropdown" class="rank_link hidden-sm hidden-xs">RANKINGS</a>
            <ul class="dropdown-menu rank_dd">
                <li><a href="<?php echo site_url('ranking/parks_by_value'); ?>">BY VALUE</a></li>
                <li><a href="<?php echo site_url('ranking/parks_by_attendance'); ?>">BY ATTENDANCE</a></li>
            </ul>
            </li>
            <li class="hidden-sm hidden-xs"><a href="https://www.linkedin.com/company/tpdb/about"><i class="fa fa-linkedin"></i></a></li>
			<li class="hidden-sm hidden-xs"><a href="https://twitter.com/theparkdb"><i class="fa fa-twitter"></i></a></li>
            <li>
              <span class="menu-toggle cmn-toggle-switch cmn-toggle-switch__htx pull-right">
    				<span>toggle menu</span>
    		</span> 
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <!-- HAMBURGER -->
	<nav class="main_menu">
		<ul>
			<li class="home current-menu-item"><a href="<?php echo site_url(''); ?>"><i class="fa fa-home"></i>HOME</a></li>
            <li class="hidden"><a href="<?php echo site_url('pages/services'); ?>"><i class="fa fa-database"></i>SERVICES</a></li>
            <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="rank_link"><i class="fa fa-bar-chart"></i>RANKINGS</a>
            <ul class="dropdown-menu rank_dd">
                <li><a href="<?php echo site_url('ranking/parks_by_value'); ?>">BY VALUE</a></li>
                <li><a href="<?php echo site_url('ranking/parks_by_attendance'); ?>">BY ATTENDANCE</a></li>
              </ul>
            </li>
            <li class="visible-sm visible-xs"><a href="<?php echo base_url('blog'); ?>"><i class="fa fa-comments-o"></i>BLOG</a></li>
			<li><a href="<?php echo site_url('/pages/about'); ?>"><i class="fa fa-star"></i>ABOUT</a></li>
			<li><a href="<?php echo site_url('/pages/faq'); ?>"><i class="fa fa-question"></i>FAQ</a></li>
			<li><a href="<?php echo site_url('/pages/contact'); ?>"><i class="fa fa-phone"></i>CONTACT</a></li>
		</ul>
        
	</nav>
    <div class="clearfix"></div>
 </header>   
