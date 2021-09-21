<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <?php $setting = setting_all();?>
  
  <link rel="icon" href="<?php echo base_url((setting_all('favicon'))?'assets/images/'.setting_all('favicon'):'assets/images/favicon.ico');?>">
  <title><?php echo (setting_all('website'))?setting_all('website'):'Dasboard';?></title>

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css'); ?>">
  <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.bootstrap.css');?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css');?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/skins/skin-black-light.min.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/skins/skin-black-light.css');?>">
    <!--  <link rel="stylesheet" href="<?php echo base_url('assets/css/blue.css');?>">-->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/buttons.dataTables.min.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/daterangepicker.css'); ?>" />
<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/js/jquery-ui.min.js'); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
  </head>
    <body class="hold-transition skin-black-light sidebar-mini" data-base-url="<?php echo base_url(); ?>">
        <div class="wrapper">

          <header class="main-header">
            <a href="<?php echo base_url(); ?>" class="logo">
             <?php $logo =  (setting_all('logo'))?setting_all('logo'):'logo.png'; 
             //print_r($_SESSION);?>
              <!-- mini logo for sidebar mini 50x50 pixels -->
              <span class="logo-mini"><img src="<?php echo base_url().'assets/images/'.$this->session->userdata('user_details')[0]->profile_pic; ?>" id="logo"></span>
              <!-- logo for regular state and mobile devices -->
              <span class="logo-lg"><img src="<?php echo base_url().'assets/images/'.$this->session->userdata('user_details')[0]->profile_pic; ?>" id="logo" style="width:40px;"></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Control Sidebar Toggle Button -->
                        <!-- <li>
                          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li> -->
                        <!-- User Account: style can be found in dropdown.less -->          

                        <li class="dropdown user user-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <?php 
                 $profile_pic =  'user.png';
                 if(isset($this->session->userdata('user_details')[0]->profile_pic) && file_exists('assets/images/'.$this->session->userdata('user_details')[0]->profile_pic))
                              {
                                 $profile_pic = $this->session->userdata('user_details')[0]->profile_pic;
                              }?>
                              <img src="<?php echo base_url().'assets/images/'.$profile_pic;?>"  class="user-image" alt="User Image">
                            <span class="hidden-xs"><?php echo isset($this->session->userdata('user_details')[0]->name)?$this->session->userdata('user_details')[0]->name:'';?></span>
                          </a>
                          <ul class="dropdown-menu" role="menu" style="width: 164px;">
                              <li><a href="<?php echo base_url('user/profile');?>"><i class="fa fa-user mr10"></i>My Account</a></li>
                              <li class="divider"></li>
                              <li><a href="<?php echo base_url('user/logout');?>"><i class="fa fa-power-off mr10"></i> Sign Out</a></li>
                          </ul>
                        </li>
                    </ul>
                </div>
            </nav>
          </header>
          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              
              <ul class="sidebar-menu">
                <li class="header"><!-- MAIN NAVIGATION --></li>
                <?php //echo '<pre>';print_r($this->router); die; ?>
                <li class="<?=($this->router->method==="profile")?"active":"not-active"?>"> 
                <a href="<?php echo base_url('user/profile');?>"> <i class="fa fa-dashboard"></i> <span>My Account</span></a>
                </li>                
                <?php $this->load->view("include/menu");?> 
                <?php if(CheckPermission("leads", "leads")){ ?>
                   <li> 
                        <a href="<?php echo base_url();?>leads/leadsTable"> <i class="fa fa-user-plus"></i> <span>Leads</span></a>
                    </li>     
                <?php } ?>
                <?php if(CheckPermission("customer", "customer")){ ?>
                   <li > 
                        <a href="<?php echo base_url();?>customer/customerTable"> <i class="fa fa-users"></i> <span>Customers</span></a>
                    </li>    
                <?php } ?>

                <?php  if(CheckPermission("products", "products")){ ?>
        <li > 
                        <a href="<?php echo base_url();?>products/productsTable"> <i class="fa fa-cog" area-hidden="true"></i> <span>Product</span></a>
                    </li>     
          <?php } ?>

          <?php if(CheckPermission("assemble", "assemble")){ ?>
        <li > 
                        <a href="<?php echo base_url();?>assemble/assembleTable"> <i class="fa fa-cogs"></i> <span>Assembly Products</span></a>
                    </li>     
          <?php } ?>

           <?php if(CheckPermission("inquiry", "inquiry")){ ?>
        <li > 
            <a href="<?php echo base_url();?>inquiry/inquiryTable"> <i class="fa fa-user-plus"></i> <span>Inquiry</span></a>
          </li>     
          <?php } ?> 
           <?php if(CheckPermission("quotation", "quotation")){ ?>
        <li > 
            <a href="<?php echo base_url();?>quotation/quotationTable"> <i class="fa fa-cart-plus"></i> <span>Quotation</span></a>
          </li>     
          <?php } ?> 
           <?php if(CheckPermission("order", "order")){ ?>
        <li > 
            <a href="<?php echo base_url();?>order/orderTable"> <i class="fa fa-reorder"></i> <span>Order</span></a>
          </li>     
          <?php } ?> 


          <?php if(CheckPermission("suppliers", "suppliers")){ ?>
                   <li > 
                        <a href="<?php echo base_url();?>suppliers/suppliersTable"> <i class="fa fa-user-secret"></i> <span>Suppliers</span></a>
                    </li>    
                <?php } ?>
          <?php if(CheckPermission("inventory", "inventory")){ ?>
                   <li > 
                        <a href="<?php echo base_url();?>inventory/inventoryTable"> <i class="fa fa-cart-arrow-down"></i> <span>Inventory</span></a>
                    </li>    
                <?php } ?>
          <?php if(CheckPermission("tags", "tags")){ ?>
                   <li > 
                        <a href="<?php echo base_url();?>tags/tagsTable"> <i class="fa fa-hashtag"></i> <span>Tags</span></a>
                    </li>    
                <?php } ?>
               <?php if(CheckPermission("make", "make")){ ?>
                   <li > 
                        <a href="<?php echo base_url();?>make/makeTable"> <i class="fa fa-cube"></i> <span>Make</span></a>
                    </li>    
                <?php } ?>
                <?php if(CheckPermission("model", "model")){ ?>
                   <li > 
                        <a href="<?php echo base_url();?>model/modelTable"> <i class="fa fa-cubes"></i> <span>Model</span></a>
                    </li>    
                <?php } ?>
               <?php

                if(CheckPermission("user", "own_read")){ ?>
                    <li class="<?=($this->router->method==="userTable")?"active":"not-active"?>"> 
                        <a href="<?php echo base_url();?>user/userTable"> <i class="fa fa-users"></i> <span>Users</span></a>
                    </li>    
                <?php }  if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){ ?>    
                    <li class="<?=($this->router->class==="setting")?"active":"not-active"?>">
                        <a href="<?php echo base_url("setting"); ?>"><i class="fa fa-wrench"></i> <span>Settings</span></a>
                    </li>
         
                   <!--  <li class="<?php //echo ($this->router->class==="Templates")?"active":"not-active"?>">
                        <a href="<?php //echo base_url("Templates"); ?>"><i class="fa fa-cubes"></i> <span>Templates</span></a>
                    </li> --> 
                  <?php }  /*if(CheckPermission("invoice", "own_read")){ ?>   
                    <li class="<?=($this->router->class==="invoice")?"active":"not-active"?>">
                        <a href="<?php echo base_url("invoice/view"); ?>"><i class="fa fa-list-alt"></i> <span>Invoice</span></a>
                    </li>

               <?php  }*/ ?>

                <!--   <li class="<?=($this->router->class==="about")?"active":"not-active"?>">
                        <a href="<?php echo base_url("about"); ?>"><i class="fa fa-info-circle"></i> <span>About Us</span></a>
                    </li> -->


              </ul>
            </section>
            <!-- /.sidebar -->
          </aside>        
