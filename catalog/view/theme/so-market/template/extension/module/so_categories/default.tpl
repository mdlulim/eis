<?php
	$uniqued = 'so_categories_' . rand() . time();
	
	
	if ($theme == 'theme4') {

?>
<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready(function ($) {
			;
			(function (element) {
				var $element = $(element);
				$(window).load(function () {
					$element.imagesLoaded(function () {
					});
				});
				$element.imagesLoaded(function () {

					$element.so_accordion({
						items: '.so-categories-inner',
						heading: '.so-categories-heading',
						content: '.so-categories-content',
						active_class: 'selected',
						event: '<?php echo $accmouseenter; ?>',
						delay: 300,
						duration: 500,
						active: '1'
					});

					var height_content = function () {
						$('.so-categories-inner', $element).each(function () {
							var $inner = $('.so-categories-content', $(this).filter('.selected'));
							$inner.css('height', 'auto');
							if ($inner.length) {
								var inner_height = $inner.height();
								$inner.css('height', inner_height);
							}
						});
					}
					$(window).resize(function () {
						height_content();
					});
					$(window).load(function () {
						height_content();
					});
				});
			})('#<?php echo $uniqued;?>')

		});
		//]]>

	</script>
<?php } ?>


<!--[if lt IE 9]>
<div id="<?php echo $uniqued; ?>"
     class="so-categories module <?php echo $theme; ?> <?php echo $deviceclass_sfx;?> <?php echo $columnclass_sfx?> msie lt-ie9"><![endif]-->
<!--[if IE 9]>
<div id="<?php echo $uniqued; ?>"
     class="so-categories module <?php echo $theme; ?> <?php echo $deviceclass_sfx; ?> <?php echo $columnclass_sfx?> msie"><![endif]-->
<!--[if gt IE 9]><!-->
<div id="<?php echo $uniqued; ?>" class="so-categories module <?php echo $theme; ?> <?php echo $deviceclass_sfx; ?> <?php echo $columnclass_sfx?>">
	<?php if($disp_title_module) { ?>
	<h3 class="modtitle"><?php echo $head_name; ?></h3>
	<?php } ?>
	<?php if($pre_text != '' && $pre_text != '&nbsp;'){	?>
	<div class="form-group">
		<?php echo html_entity_decode($pre_text);?>
	</div>
	<?php	}	?>
	<div class="modcontent">
		<?php if(!empty($list) && count($list)){?>
		<!--<![endif]-->
		<?php include("default_".$theme.".tpl");	?>
		<?php }else{ 
			echo $objlang->get('text_noitem');
		}?>
	</div> <!--/.modcontent-->
	<?php if($post_text != '' && $post_text != '&nbsp;'){	?>
	<div class="form-group">
		<?php echo html_entity_decode($post_text);?>
	</div>
	<?php	}	?>
</div>

