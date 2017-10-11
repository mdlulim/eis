<header id="header" class=" variant typeheader-<?php echo isset($typeheader) ? $typeheader : '1'?>">
	<!-- HEADER TOP -->
	<div class="header-top compact-hidden">
		<div class="container">
			<div class="row">
			
				<div class="header-top-left form-inline compact-hidden col-lg-5 col-md-4 col-sm-3">
					<?php
					if($phone_status){
						if (isset($contact_number) && is_string($contact_number)) {
						 echo '<div class="form-group navbar-phone" style="padding:0 10px"><i class="fa fa-phone"></i> '.html_entity_decode($contact_number, ENT_QUOTES, 'UTF-8').'</div>';
						} else {echo 'Telephone No';}
					}
					?>
					
					<?php if($welcome_message_status):?>
					<div class="form-group navbar-welcome" style="padding:0 10px;">
						<?php
							if (isset($welcome_message) && is_string($welcome_message)) {
							echo html_entity_decode($welcome_message, ENT_QUOTES, 'UTF-8');
							} else {echo 'Default welcome msg!';}
						?>
					</div>
					<?php endif; ?>
				</div>
				<div class="header-top-right collapsed-block compact-hidden col-lg-7 col-md-8 col-sm-9 col-xs-12">
					<div  class="tabBlocks" id="TabBlock-1s">
					<ul class="top-link list-inline">
						<li class="account" id="my_account"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="btn btn-xs dropdown-toggle" data-toggle="dropdown"> <span class="hidden-xs"><?php echo $text_account; ?></span> <span class="fa fa-angle-down"></span></a>
							<ul class="dropdown-menu ">
								<?php if ($logged) { ?>
								<li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
								<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
								<li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
								<li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
								<li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
								<?php } else { ?>
								<li><a href="<?php echo $register; ?>"><i class="fa fa-user"></i> <?php echo $text_register; ?></a></li>
								<li><a href="<?php echo $login; ?>"><i class="fa fa-pencil-square-o"></i> <?php echo $text_login; ?></a></li>
								<?php } ?>
							</ul>
						</li>
						<?php if($wishlist_status):?><li class="wishlist"><a href="<?php echo $wishlist; ?>" id="wishlist-total" class="top-link-wishlist" title="<?php echo $text_wishlist; ?>"><span class="hidden-xs"><?php echo $text_wishlist; ?></span></a></li><?php endif; ?>
						<?php if($checkout_status):?><li class="checkout"><a href="<?php echo $checkout; ?>" class="top-link-checkout" title="<?php echo $text_checkout; ?>"><span class="hidden-xs"><?php echo $text_checkout; ?></span></a></li><?php endif; ?>
						<?php if($login_status):?><li class="login"><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><span class="hidden-xs hidden-sm hidden-md"><?php echo $text_shopping_cart; ?></span></a></li><?php endif; ?>
						
						
					</ul>
					<?php if($lang_status):?>
						<?php echo $currency; ?>
						<?php echo $language; ?>
					<?php endif; ?>
					</div>
					
					
				</div>
				
			</div>
		</div>
	</div>
	
	<!-- HEADER CENTER -->
	<div class="header-center">
		<div class="container">
			<div class="row">
				<!-- LOGO -->
				<div class="navbar-logo col-lg-2 col-md-12 logo-header">
				   <?php  $this->soconfig->get_logo();?>
				</div>
				<div class="header-middle-right col-lg-10 col-md-12">
					<div class="middle-right-content">
						<div class="navbar-menu">
							<?php echo $content_menu; ?>
						</div>
						<div class="search-header">
							<div class="search-wrapper">
								<?php echo $content_search; ?>	
							</div>
						</div>
						<div class="minicart-header">
							<div class="shopping_cart pull-right">
								<?php echo $cart; ?> 
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<!-- Navbar switcher -->
	<?php if (!isset($toppanel_status) || $toppanel_status != 0) : ?>
	<?php if (!isset($toppanel_type) || $toppanel_type != 2 ) :  ?>
	<div class="navbar-switcher-container">
		<div class="navbar-switcher">
			<span class="i-inactive">
				<i class="fa fa-caret-down"></i>
			</span>
			 <span class="i-active fa fa-times"></span>
		</div>
	</div>
	<?php endif; ?>
	<?php endif; ?>
</header>