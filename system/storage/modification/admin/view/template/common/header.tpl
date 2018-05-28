<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<script type="text/javascript" src="view/javascript/jquery/jquery-2.1.1.min.js"></script>

          <?php if (isset($pim_status) && $pim_status) {?>
          <!-- Power Image Manager -->
          <link rel="stylesheet" href="view/javascript/jquery/jquery-ui-1.11.4.custom/jquery-ui.css" />
          <script src="view/javascript/jquery/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
          <script type="text/javascript" src="view/javascript/pim/pim.min.js"></script>          
          <link rel="stylesheet" type="text/css" media="screen" href="view/stylesheet/pim/pim.min.css">
          <link rel="stylesheet" type="text/css" media="screen" href="view/stylesheet/pim/theme.css">
            <?php if ($lang) { ?>
             <script type="text/javascript" src="view/javascript/pim/i18n/<?php echo $lang;?>.js"></script>  
            <?php } ?>        	
          <!-- Power Image Manager -->        
          <?php } ?>
        
<script type="text/javascript" src="view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="view/stylesheet/bootstrap.css" type="text/css" rel="stylesheet" />
<link href="view/javascript/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<script src="view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
<script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<link type="text/css" href="view/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
<?php foreach ($styles as $style) { ?>
<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<link href="http://dashbundle.co.za/image/catalog/Dashlogic-icon-2.png" rel="icon" />
</head>
<body class="teee">
<div id="container">
<header id="header" class="navbar navbar-static-top">
  <div class="navbar-header">
    <?php if ($logged) { ?>
    <!-- <a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a> -->
    <?php } ?>
    <a href="<?php echo $home; ?>" class="navbar-brand" style="height:44px; padding-top:12.5px;"><img src="view/image/logo.png" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></a></div>
  <?php if ($logged) { ?>
  <ul class="nav pull-right">
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><?php if($alerts > 0) { ?><span class="label label-danger pull-left"><?php echo $alerts; ?></span><?php } ?> <i class="fa fa-bell fa-lg"></i></a>
      <ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
        <li class="dropdown-header"><?php echo $text_order; ?></li>
        <li><a href="<?php echo $processing_status; ?>" style="display: block; overflow: auto;"><span class="label label-warning pull-right"><?php echo $processing_status_total; ?></span><?php echo $text_processing_status; ?></a></li>
        <li><a href="<?php echo $complete_status; ?>"><span class="label label-success pull-right"><?php echo $complete_status_total; ?></span><?php echo $text_complete_status; ?></a></li>
        <li><a href="<?php echo $return; ?>"><span class="label label-danger pull-right"><?php echo $return_total; ?></span><?php echo $text_return; ?></a></li>
       
        <?php if($login_user_group_name == "Sales Manager") { ?>
        <li class="divider"></li>
        <li class="dropdown-header"><?php echo $text_quotes; ?></li>
        <li><a href="<?php echo $quotes_header; ?>"><span class="label label-success pull-right"><?php echo $order_quotes_total_all; ?></span><?php echo $text_approvedquotes; ?></a></li>
        <li><a href="<?php echo $quotes_waiting_header; ?>"><span class="label label-danger pull-right"><?php echo $order_quotes_total_all_waiting; ?></span><?php echo $text_approval; ?></a></li>
        
        <?php } else { ?>
        
        <li class="divider"></li>
        <li class="dropdown-header"><?php echo $text_quotes; ?></li>
        <li><a href="<?php echo $quotes_header; ?>"><span class="label label-success pull-right"><?php echo $order_quotes_total_all; ?></span><?php echo $text_approvedquotes; ?></a></li>
        <li><a href="<?php echo $quotes_waiting_header; ?>"><span class="label label-danger pull-right"><?php echo $order_quotes_total_all_waiting; ?></span><?php echo $text_approval; ?></a></li>
        
        <?php } ?>
        
         <?php if($login_user_group_name == "Admin") { ?>
        <li class="divider"></li>
        <li class="dropdown-header"><?php echo $text_quotes; ?></li>
        <li><a href="<?php echo $quotes_header; ?>"><span class="label label-success pull-right"><?php echo $order_quotes_total_all; ?></span><?php echo $text_approvedquotes; ?></a></li>
        <li><a href="<?php echo $quotes_waiting_header; ?>"><span class="label label-danger pull-right"><?php echo $order_quotes_total_all_waiting; ?></span><?php echo $text_approval; ?></a></li>
        
        <?php } ?>
        
        <li class="divider"></li>
        <li class="dropdown-header"><?php echo $text_product; ?></li>
        <li>
          <a href="<?php echo $product; ?>">
            <span class="label <?=($product_total > 0) ? 'label-danger' : 'label-default'; ?> pull-right">
              <?php echo $product_total; ?>
            </span>
            <?php echo $text_stock; ?>
          </a>
        </li>
        <li>
          <a href="<?php echo $review; ?>">
            <span class="label <?=($review_total > 0) ? 'label-danger' : 'label-default'; ?> pull-right">
              <?php echo $review_total; ?>
            </span>
              <?php echo $text_review; ?>
          </a>
        </li>
         <?php if($login_user_group_name != "Sales Manager") { ?>
        <li class="divider"></li>
        <li class="dropdown-header"><?php echo $text_affiliate; ?></li>
        <li><a href="<?php echo $affiliate_approval; ?>"><span class="label label-danger pull-right"><?php echo $affiliate_total; ?></span><?php echo $text_approval; ?></a></li>
        <?php } ?>
      </ul>
    </li>
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" style="padding-right:3px;"><i class="fa fa-globe fa-lg"></i>  View Stores<img src="view/image/down-arrow.png" height="23" width="19" style="margin-left:15px;"></a>
      <ul class="dropdown-menu dropdown-menu-right">
        <!--<li class="dropdown-header"><?php echo $text_store; ?></li>-->
        <?php foreach ($stores as $store) { ?>
        <li><a href="<?php echo $store['href']; ?>" target="_blank"><?php echo $store['name']; ?></a></li>
        <?php } ?>
      </ul>
    </li>
    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-question fa-lg" style="background-color: #6D6D6D;border-radius: 1pc;color: white;    padding: 6px;"></i></a>
      <ul class="dropdown-menu dropdown-menu-right">
        <li class="dropdown-header"><?php echo $text_help; ?></li>
        <!--<li><a href="http://www.dashlogic.co.za" target="_blank"><?php echo $text_homepage; ?></a></li>-->
        <li><a href="https://help.saleslogic.io/portal/kb" target="_blank"><?php echo $text_documentation; ?></a></li>
        <li><a href="https://help.saleslogic.io/portal/newticket" target="_blank"><?php echo $text_support; ?></a></li>
      </ul>
    </li>
    <li><a href="<?php echo $logout; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout; ?></span> <i class="fa fa-sign-out fa-lg"></i></a></li>
  </ul>
  <?php } ?>
</header>
