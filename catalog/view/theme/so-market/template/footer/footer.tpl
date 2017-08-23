
<footer class="footer-container typefooter-<?php echo isset($typefooter) ? $typefooter : '1'?>">
	
	<!-- FOOTER TOP -->
	<div class="footer-top">
		<div class="container">
			<div class="row">
				<!-- BOX INFOMATION --> 
				<?php if ($informations) :?>
					<div class="col-sm-6 col-md-3 box-information">
						<div class="module clearfix">
							<h3 class="footer-title"><?php echo $text_information; ?></h3>
							<div  class="modcontent" >
								<ul class="menu">
									<?php foreach ($informations as $information) { ?>
									<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
				<?php endif; ?>
				<div class="col-sm-6 col-md-3 box-information">
					<div class="module clearfix">
						<h3 class="footer-title"><?php echo $text_service; ?></h3>
						<div  class="modcontent" >
							<ul class="menu">
								<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
								<li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
								<li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
								<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
							</ul>
						</div>
					</div>
				</div>
				
				<!-- BOX MY ACOUNT -->
				<div class="col-sm-6 col-md-3 box-account">
					<div class="module clearfix">
						<h3 class="footer-title"><?php echo $text_account; ?></h3>
						<div  class="modcontent" >
							<ul class="menu">
								<li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
								<li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
								<li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
								<li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
							</ul>
						</div>
					</div>
				</div>
			
				<?php if ($footer_block1) : ?>
				<div class="col-sm-6 col-md-3  footer-custom1">
					<div class="module clearfix">
						<div  class="modcontent" >
							<?php echo $footer_block1; ?>
						</div>
					</div>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
	<!-- FOOTER CENTER -->
	<div class="footer-center">
		<?php if ($footer_block2) : ?>
			<div class="container">
				<!-- CUSTOM BLOCK 2 -->
				<div class="footer-directory-title">
					<?php echo $footer_block2; ?>
				</div>
			</div>
		<?php endif; ?>		
	</div>
	
				
	<!-- FOOTER BOTTOM -->
	<div class="footer-bottom ">
		<div class="container">
			<div class="row">
				<?php $col_copyright = ($imgpayment_status) ? 'col-sm-7' : 'col-sm-12 text-center'?>
				<div class="<?php echo $col_copyright;?>">
					<?php 
					$datetime = new DateTime();
					$cur_year	= $datetime->format('Y');
					
					echo (!isset($copyright) || !is_string($copyright) ? $powered : str_replace('{year}', $cur_year, html_entity_decode($copyright, ENT_QUOTES, 'UTF-8')));?>
				</div>

				<?php if (isset($imgpayment_status) && $imgpayment_status != 0) : ?>
				<div class="col-sm-5 text-right">
					<?php
					if ((isset($imgpayment) && $imgpayment != '') ) { ?>
						<img src="image/<?php echo  $imgpayment ?>"  alt="imgpayment">
					<?php } ?>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
	

</footer>