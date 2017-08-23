<div class="emailContent"><?php echo $emailtemplate['content1']; ?></div>

<?php if (isset($order_products_file) && file_exists($config['template_dir'] . $order_products_file)) include_once($config['template_dir'] . $order_products_file); ?>

<?php if (!empty($comment)) { ?>
<div>
	<b><?php echo $text_update_comment; ?></b><br/>
	<div><?php echo $comment; ?><br/></div>
</div>
<?php } ?>

<?php if (isset($emailtemplate['content2'])) { ?>
<div class="emailContent"><?php echo $emailtemplate['content2']; ?></div>
<?php } ?>