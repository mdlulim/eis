<?php echo $header; ?>
<style>
@font-face {
	font-family: 'anyoldicon';
	src:url('../fonts/anyoldicon/anyoldicon.eot');
	src:url('../fonts/anyoldicon/anyoldicon.eot?#iefix') format('embedded-opentype'),
		url('../fonts/anyoldicon/anyoldicon.woff') format('woff'),
		url('../fonts/anyoldicon/anyoldicon.ttf') format('truetype'),
		url('../fonts/anyoldicon/anyoldicon.svg#anyoldicon') format('svg');
	font-weight: normal;
	font-style: normal;
}

/* General grid styles */
.cbp-ig-grid {
	list-style: none;
	padding: 0 0 50px 0;
	margin: 0;
}

/* Clear floats */
.cbp-ig-grid:before, 
.cbp-ig-grid:after { 
	content: " "; 
	display: table; 
}

.cbp-ig-grid:after { 
	clear: both; 
}

/* grid item */
.cbp-ig-grid li {
	width: 33%;
	float: left;
	/*height: 420px;*/
	text-align: center;
	border-top: 1px solid #ddd;
}

/* we are using a combination of borders and box shadows to control the grid lines */
.cbp-ig-grid li:nth-child(-n+3){
	border-top: none;
}

.cbp-ig-grid li:nth-child(3n-1),
.cbp-ig-grid li:nth-child(3n-2) {
	box-shadow: 1px 0 0 #ddd;
}

/* anchor style */
.cbp-ig-grid li > a {
	display: block;
	height: 100%;
	color: #47a3da;
	-webkit-transition: background 0.2s;
	-moz-transition: background 0.2s;
	transition: background 0.2s;
  padding-top: 30px;
}

/* the icon with pseudo class for icon font */
.cbp-ig-icon {
	padding: 30px 0 0 0;
	display: block;
	-webkit-transition: -webkit-transform 0.2s;
	transition: -moz-transform 0.2s;
	transition: transform 0.2s;
}

.cbp-ig-icon:before {
	font-family: 'anyoldicon';
	font-size: 14em;
	speak: none;
	font-style: normal;
	font-weight: normal;
	font-variant: normal;
	text-transform: none;
	line-height: 1;
	-webkit-font-smoothing: antialiased;
}

.cbp-ig-icon-shoe:before {
	content: "\e000";
}

.cbp-ig-icon-ribbon:before {
	content: "\e001";
}

.cbp-ig-icon-milk:before {
	content: "\e002";
}

.cbp-ig-icon-whippy:before {
	content: "\e003";
}

.cbp-ig-icon-spectacles:before {
	content: "\e004";
}

.cbp-ig-icon-doumbek:before {
	content: "\e007";
}

/* title element */
.cbp-ig-grid .cbp-ig-title {
	margin: 20px 0 10px 0;
	padding: 20px 0 0 0;
	font-size: 2em;
	position: relative;
	-webkit-transition: -webkit-transform 0.2s;
	-moz-transition: -moz-transform 0.2s;
	transition: transform 0.2s;
}

.cbp-ig-grid .cbp-ig-title:before {
	content: '';
	position: absolute;
	background: #47a3da;
	width: 160px;
	height: 6px;
	top: 0px;
	left: 50%;
	margin: -10px 0 0 -80px;
	-webkit-transition: margin-top 0.2s; /* top or translate does not seem to work in Firefox */
	-moz-transition: margin-top 0.2s;
	transition: margin-top 0.2s;
}

.cbp-ig-grid .cbp-ig-category {
	text-transform: uppercase;
	display: inline-block;
	font-size: 1em;
	letter-spacing: 1px;
	color: #fff;
	-webkit-transform: translateY(10px);
	-moz-transform: -moz-translateY(10px);
	-ms-transform: -ms-translateY(10px);
	transform: translateY(10px);
	opacity: 0;
	-webkit-transition: -webkit-transform 0.3s, opacity 0.2s;
	-moz-transition: -moz-transform 0.3s, opacity 0.2s;
	-webkit-transition: transform 0.3s, opacity 0.2s;
}

.cbp-ig-grid li:hover .cbp-ig-category,
.touch .cbp-ig-grid li .cbp-ig-category {
	opacity: 1;
	-webkit-transform: translateY(0px);
	-moz-transform: translateY(0px);
	-ms-transform: translateY(0px);
	transform: translateY(0px);
}

/* Hover styles */

.cbp-ig-grid li > a:hover {
	background: #47a3da;
}

.cbp-ig-grid li > a:hover .cbp-ig-icon {
	-webkit-transform: translateY(10px);
	-moz-transform: translateY(10px);
	-ms-transform: translateY(10px);
	transform: translateY(10px);
}

.cbp-ig-grid li > a:hover .cbp-ig-icon:before,
.cbp-ig-grid li > a:hover .cbp-ig-title {
	color: #fff;
}

.cbp-ig-grid li > a:hover .cbp-ig-title {
	-webkit-transform: translateY(-30px);
	-moz-transform: translateY(-30px);
	-ms-transform: translateY(-30px);
	transform: translateY(-30px);
}

.cbp-ig-grid li > a:hover .cbp-ig-title:before {
	background: #fff;
	margin-top: 80px;
}


@media screen and (max-width: 62.75em) {
	.cbp-ig-grid li {
		width: 50%;
	}

	/* reset the grid lines */
	.cbp-ig-grid li:nth-child(-n+3){
		border-top: 1px solid #ddd;
	}

	.cbp-ig-grid li:nth-child(3n-1),
	.cbp-ig-grid li:nth-child(3n-2) {
		box-shadow: none;
	}

	.cbp-ig-grid li:nth-child(-n+2){
		border-top: none;
	}

	.cbp-ig-grid li:nth-child(2n-1) {
		box-shadow: 1px 0 0 #ddd;
	}
}

@media screen and (max-width: 41.6em) { 
	.cbp-ig-grid li {
		width: 100%;
	}

	.cbp-ig-grid li:nth-child(-n+2){
		border-top: 1px solid #ddd;
	}

	.cbp-ig-grid li:nth-child(2n-1) {
		box-shadow: none
	}

	.cbp-ig-grid li:first-child {
		border-top: none;
	}
}

@media screen and (max-width: 25em) { 
	.cbp-ig-grid {
		font-size: 80%;
	}

	.cbp-ig-grid .cbp-ig-category {
		margin-top: 20px;
	}
}
</style>
<!--end style-->
<div id="container" class="container j-container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?><?php echo $column_right; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <!--h2 class="secondary-title"><?php echo $text_my_account; ?></h2>
      <div class="content my-account">
      <ul class="list-unstyled">
        <li><a href="<?php echo $edit; ?>"><?php echo $text_edit; ?></a></li>
        <li><a href="<?php echo $password; ?>"><?php echo $text_password; ?></a></li>
        <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
        <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      </ul>
      </div-->
      <?php if (isset($credit_cards) && $credit_cards) { ?>
      <h2><?php echo $text_credit_card; ?></h2>
      <ul class="list-unstyled">
        <?php foreach ($credit_cards as $credit_card) { ?>
        <li><a href="<?php echo $credit_card['href']; ?>"><?php echo $credit_card['name']; ?></a></li>
        <?php } ?>
      </ul>
      <?php } ?>
      <!--h2 class="secondary-title"><?php echo $text_my_orders; ?></h2>
      <div class="content my-orders">
      <ul class="list-unstyled">
        <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
        <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
        <?php if ($reward) { ?>
        <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
        <?php } ?>
        <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
        <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
        <li><a href="<?php echo $recurring; ?>"><?php echo $text_recurring; ?></a></li>
      </ul>
      </div>
      <h2 class="secondary-title"><?php echo $text_my_newsletter; ?></h2>
      <div class="content my-newsletter">
      <ul class="list-unstyled">
        <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
      </ul>
      </div-->
      <?php echo $content_bottom; ?></div>
    </div>
  <!-- test block -->
  <ul class="cbp-ig-grid">
	<li>
		<a href="<?php echo $edit; ?>">
			<span class="fa fa-user fa-5x" style="font-size: 5em;"></span>
			<h3 class="cbp-ig-title">My Account</h3>
			<span class="cbp-ig-category"></span>
		</a>
	</li>
	<li>
		<a href="<?php echo $order; ?>">
			<span class="fa  fa-history fa-5x" style="font-size: 5em;"></span>
			<h3 class="cbp-ig-title">Order History</h3>
			<span class="cbp-ig-category"></span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="fa fa-file-text fa-5x" style="font-size: 5em;"></span>
			<h3 class="cbp-ig-title">Import Stocksheet</h3>
			<span class="cbp-ig-category"></span>
		</a>
	</li>
	<li>
		<a href="<?php echo $password; ?>">
			<span class="fa fa-key fa-5x" style="font-size: 5em;"></span>
			<h3 class="cbp-ig-title">Reset Password</h3>
			<span class="cbp-ig-category"></span>
		</a>
	</li>
	<li>
		<a href="#">
			<span class="fa fa-question-circle fa-5x" style="font-size: 5em;"></span>
			<h3 class="cbp-ig-title">FAQs</h3>
			<span class="cbp-ig-category"></span>
		</a>
	</li>
	<li>
		<a href="<?php echo $logout; ?>">
			<span class="fa fa-power-off fa-5x" style="font-size: 5em;"></span>
			<h3 class="cbp-ig-title">Logout</h3>
			<span class="cbp-ig-category"></span>
		</a>
	</li>
</ul>
<?php echo $footer; ?>