<div class="emailContent"><?php echo $emailtemplate['content1']; ?></div>

<?php if (!empty($customer_id) && !empty($link)) { ?>
<br />
<div class="link" style="padding-top:4px;padding-bottom:4px;">
	<b><?php echo $text_link; ?></b><br />
	<a href="<?php echo $link; ?>" target="_blank"><b><?php echo $link; ?></b></a>
</div>
<?php } ?>

<?php if (!empty($download)) { ?>
<br />
<div class="link" style="padding-top:4px;padding-bottom:4px;">
	<b><?php echo $text_download; ?></b><br />
	<a href="<?php echo $download; ?>" target="_blank"><b><?php echo $download; ?></b></a>
</div>
<?php } ?>

<?php if (!empty($instruction)) { ?>
	<br />
	<div><?php echo $instruction; ?></div><br />
<?php } ?>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15" style="font-size:1px;line-height:15px;mso-margin-top-alt:1px;">&nbsp;</td></tr></table>

<?php if (isset($emailtemplate['content2'])) { ?>
<div class="emailContent"><?php echo $emailtemplate['content2']; ?></div>
<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="25" style="font-size:1px;line-height:25px;mso-margin-top-alt:1px;">&nbsp;</td></tr></table>
<?php } ?>

<?php if (isset($order_products_file) && file_exists($config['template_dir'] . $order_products_file)) include_once($config['template_dir'] . $order_products_file); ?>

<?php if (!empty($order_comment) && isset($text_new_comment)) { ?>
	<br /><b><?php echo $text_new_comment; ?></b><br />
	<div><?php echo $order_comment; ?></div><br />
<?php } ?>

<?php if (isset($emailtemplate['content3'])) { ?>
<div class="emailContent"><?php echo $emailtemplate['content3']; ?></div>
<?php } ?>