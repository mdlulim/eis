<div class="emailContent"><?php echo $emailtemplate['content1']; ?></div>

<?php if (!empty($order_comment)) { ?>
	<br /><b><?php echo $text_new_comment; ?></b>
	<br /><?php echo $order_comment; ?><br />
<?php } ?>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15" style="font-size:1px;line-height:15px;mso-margin-top-alt:1px;">&nbsp;</td></tr></table>

<?php if (isset($emailtemplate['content2'])) { ?>
<div class="emailContent"><?php echo $emailtemplate['content2']; ?></div>
<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15" style="font-size:1px;line-height:15px;mso-margin-top-alt:1px;">&nbsp;</td></tr></table>
<?php } ?>

<?php if (!empty($products)) { ?>
<table cellpadding="5" cellspacing="0" width="100%" class="tableOrderDefault tableOrder">
<thead>
	<tr>
        <th width="50%" bgcolor="#ededed" align="center" class="textCenter" style="text-align:center;"><b><?php echo $text_product; ?></b></th>
		<th bgcolor="#ededed" align="center" class="textCenter tableColumnQuantity" style="text-align:center;"><b><?php echo $text_quantity; ?></b></th>
        <th bgcolor="#ededed" align="right" class="textRight tableColumnPrice" style="text-align:right;"><b><?php echo $text_price; ?></b></th>
        <th bgcolor="#ededed" align="right" class="textRight tableColumnTotal" style="text-align:right;"><b><?php echo $text_total; ?></b></th>
	</tr>
</thead>
<tbody>
	<?php $i = 0; ?>
	<?php foreach ($products as $product) { $row_style_background = ($i++ % 2) ? "#f6f6f6" :"#fafafa"; ?>
	<tr>
		<td bgcolor="<?php echo $row_style_background; ?>">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" class="product-table tableStack" style="table-layout: auto;">
				<tr>
					<td class="emailProductData">
						<a href="<?php echo $product['url']; ?>" class="link">
							<b style="font-size:1.1em;font-weight:bold;"><?php echo $product['name']; ?></b>
						</a>
						<?php if ($product['model']) { ?>- <span style="font-size:0.85em;line-height:16px;"><?php echo $product['model']; ?></span><?php } ?>
					</td>
				</tr>
				<tr>
					<td class="emailProductData" style="padding-top:6px;">
						<table border="0" cellspacing="0" cellpadding="0" style="width:auto">
							<?php if (!empty($product['option'])) { ?>
								<?php foreach ($product['option'] as $option) { ?>
								<tr>
									<td>&raquo; <strong><?php echo $option['name']; ?>:</strong>&nbsp;<?php echo $option['value']; ?><?php if ($option['price']) echo "&nbsp;(".$option['price'].")"; ?></td>
								</tr>
								<?php } ?>
							<?php } ?>

							<?php if (!empty($product['sku'])) { ?>
								<tr>
									<td style="font-size:0.9em;padding:2px 0;"><b><?php echo $text_sku; ?>:</b></td>
									<td style="padding:2px 0 2px 6px;"><?php echo $product['sku']; ?></td>
								</tr>
							<?php } ?>

							<?php if (!empty($product['product_id'])) { ?>
								<tr>
									<td style="font-size:0.9em;padding:2px 0;"><b><?php echo $text_id; ?>:</b></td>
									<td style="padding:2px 0 2px 6px;"><?php echo $product['product_id']; ?></td>
								</tr>
							<?php } ?>

							<?php if (!empty($product['stock_quantity'])) { ?>
								<tr>
									<td style="font-size:0.9em;padding:2px 0;"><b><?php echo $text_stock_quantity; ?>:</b></td>
									<td style="padding:2px 0 2px 6px;"><span style="color:<?php if ($product['stock_quantity'] <= 0) { echo '#FF0000'; } elseif ($product['stock_quantity'] <= 5) { echo '#FFA500'; } else { echo '#008000'; }?>"><?php echo $product['stock_quantity']; ?></span></td>
								</tr>
								<?php if ($product['stock_backorder']) { ?>
								<tr>
									<td style="font-size:0.9em;padding:2px 0;"><b><?php echo $text_backorder_quantity; ?>:</b></td>
									<td style="padding:2px 0 2px 6px;"><?php echo $product['stock_backorder']; ?></td>
								</tr>
								<?php } ?>
							<?php } ?>
						</table>
					</td>
				</tr>
			</table>
		</td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="center" class="textCenter tableColumnQuantity" style="text-align:center;">
			<?php echo $product['quantity']; ?>
		</td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight tableColumnPrice" style="text-align:right;">
			<?php echo $product['price']; ?>
		</td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight tableColumnPrice" style="text-align:right;">
			<?php echo $product['total']; ?>
		</td>
	</tr>
	<?php } ?>

	<?php if (!empty($vouchers)) { ?>
	<?php foreach ($vouchers as $voucher) { $row_style_background = ($i++ % 2) ? "#f6f6f6" :"#fafafa"; ?>
	<tr>
        <td bgcolor="<?php echo $row_style_background; ?>"><?php echo $voucher['description']; ?></td>
        <td bgcolor="<?php echo $row_style_background; ?>" class="tableColumnQuantity" style="border-left:none"></td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight tableColumnPrice" style="text-align:right;"><?php echo $voucher['amount']; ?></td>
	</tr>
	<?php }
	} ?>
</tbody>
<?php if (isset($totals)) { ?>
<tfoot>
	<?php foreach ($totals as $total) {
		$row_style_background = ($i++ % 2) ? "#f6f6f6" :"#fafafa"; ?>
	<tr>
        <td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight" colspan="3" style="text-align:right;border-left:none;"><b><?php echo $total['title']; ?></b></td>
		<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight tableColumnPrice" style="text-align:right;"><?php echo $total['text']; ?></td>
	</tr>
	<?php } ?>
</tfoot>
<?php } ?>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15" style="font-size:1px;line-height:15px;mso-margin-top-alt:1px;">&nbsp;</td></tr></table>
<?php } ?>

<?php if (!empty($order_link)) { ?>
	<div class="link" style="padding-top:4px;padding-bottom:4px;"><b><?php echo $text_order_link; ?></b><br /><a href="<?php echo $order_link; ?>" target="_blank"><b><?php echo $order_link; ?></b></a></div>
<?php } ?>

<?php if (isset($emailtemplate['content3'])) { ?>
<div class="emailContent"><?php echo $emailtemplate['content3']; ?></div>
<?php } ?>