
<div class="module <?php echo $class_suffix; ?>">
	<?php if($disp_title_module) { ?>
		<h3 class="modtitle"><?php echo $head_name; ?></h3>
	<?php } ?>
	<?php if($pre_text != '')
		{
	?>
		<div class="form-group">
			<?php echo html_entity_decode($pre_text);?>
		</div>
	<?php
		}
	?>
	<div class="modcontent">
		<?php
		$fbcontent = "";
		if($pageid == '' ){
		$fbcontent.='Please enter your valid Page ID.';
		}else{
		$href_id = (strpos($pageid,'http') !== false )?'?href=':'?id=';
		$fbcontent .= '<iframe src="http://www.facebook.com/plugins/likebox.php'.$href_id.$pageid;
			if ( $stream ){
				$fbcontent .= '&amp;stream=true';
			}
			if ( $hide_cover ){
				$fbcontent .= '&amp;hide_cover=true';
			}
			if ( $small_header ){
				$fbcontent .= '&amp;small_header=true';
			}
			if ( $show_facepile == 0 ){
				$fbcontent .= '&amp;show_facepile=false';
			}
			if ( $height ){
				$fbcontent .= '&amp;height='.$height.'';
			}
			if ( $width ){
				$fbcontent .= '&amp;width='.$width.'"';
			}
		$fbcontent .= ' style="overflow:auto;background-color: transparent;border:none;';
		if ( $height ){
		$fbcontent .= 'height:'.$height.'px;';
		}
		if ( $width ){
		$fbcontent .= 'width:'.$width.'px;';
		}
		$fbcontent .= '" ></iframe>';
		}
		?>
		<div class="so_facebook-nav so-facebook-ip" style="width: <?php echo $width; ?>px; ">
			<?php echo $fbcontent; ?>
		</div>
	</div> <!-- /.modcontent-->
	<?php if($post_text != '')
	{
	?>
		<div class="form-group">
			<?php echo html_entity_decode($post_text);?>
		</div>
	<?php
	}
	?>
</div>
