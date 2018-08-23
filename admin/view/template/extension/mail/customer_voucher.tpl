<table style="border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="2"></td>
		<td class="heading2" align="<?php echo $config['text_align']; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Arial,Helvetica,sans-serif; font-size:16px; line-height:20px; color:<?php echo $config['body_heading_color']; ?>; margin:0; padding: 0; font-weight:bold;"><strong>
			<?php echo $title; ?>
		</strong></td>
	</tr>
	<tr style="font-size:1px; line-height:0;"><td width="2" height="3">&nbsp;</td><td height="3">&nbsp;</td></tr>
	<tr style="font-size:1px; line-height:0;"><td width="2" height="1" bgcolor="#cccccc">&nbsp;</td><td height="1" bgcolor="#cccccc">&nbsp;</td></tr>
	<tr style="font-size:1px; line-height:0;"><td width="2" height="10">&nbsp;</td><td height="10">&nbsp;</td></tr>
</table>

<?php if($image){ ?>
<div style="float: right; margin-left: 20px;">
	<a href="<?php echo $store_url; ?>" title="<?php echo $store_name; ?>">
		<img src="<?php echo $image; ?>" alt="<?php echo $store_name; ?>" border="0" style="outline:none; text-decoration:none; -ms-interpolation-mode: bicubic; display:inline;"<?php if($image_width){ echo " width='{$image_width}'"; } if($image_height){ echo " height='{$image_height}'"; } ?> />
	</a>
</div>
<?php } ?>

<p class="standard" align="<?php echo $config['text_align']; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Arial,Helvetica,sans-serif; font-size:12px; line-height:18px; color:<?php echo $config['body_font_color']; ?>; margin-top:0px; margin-bottom:8px;">
	<?php echo $text_greeting; ?>
</p>

<p class="standard" align="<?php echo $config['text_align']; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Arial,Helvetica,sans-serif; font-size:12px; line-height:18px; color:<?php echo $config['body_font_color']; ?>; margin-top:0px; margin-bottom:8px;">
	<?php echo $text_from; ?>
</p>

<?php if ($message) { ?>
	<p class="standard" align="<?php echo $config['text_align']; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Arial,Helvetica,sans-serif; font-size:12px; line-height:18px; color:<?php echo $config['body_font_color']; ?>; margin-top:0px; margin-bottom:8px;">
		<?php echo $text_message; ?>
	</p>
	<p class="standard" align="<?php echo $config['text_align']; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Arial,Helvetica,sans-serif; font-size:12px; line-height:18px; color:<?php echo $config['body_font_color']; ?>; margin-top:0px; margin-bottom:8px;">
		<?php echo $message; ?>
	</p>
<?php } ?>

<p class="link" align="<?php echo $config['text_align']; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Arial,Helvetica,sans-serif; font-size:12px; line-height:18px; color:<?php echo $config['body_font_color']; ?>; margin-top:5px; margin-bottom:15px;">
	<b><?php echo $text_redeem; ?></b><br />
	<span style="line-height:100%; font-size:120%;">&raquo;</span>
	<a href="<?php echo $store_url; ?>" style="color:<?php echo $config['body_link_color']; ?>; text-decoration:none;" target="_blank">
		<b><?php echo $store_url; ?></b>
	</a>
</p>

<p class="standard" align="<?php echo $config['text_align']; ?>" style="-ms-text-size-adjust:100%; mso-line-height-rule:exactly; font-family:Arial,Helvetica,sans-serif; font-size:12px; line-height:18px; color:<?php echo $config['body_font_color']; ?>; margin-top:0px; margin-bottom:0px;">
	<?php echo $text_footer; ?>
</p>