<?php if(!empty($products)) { ?>
<table cellpadding="5" cellspacing="0" width="100%" class="tableOrderDefault tableOrder">
	<thead>
		<tr>
			<th width="50%" bgcolor="#ededed" class="textCenter" style="text-align:center;"><?php echo $text_product; ?></th>
			<?php if ($config['order_products']['quantity_column']) { ?><th bgcolor="#ededed" align="center" class="textCenter tableColumnQuantity" style="text-align:center;"><b><?php echo $text_quantity; ?></b></th><?php } ?>
			<th bgcolor="#ededed" align="right" class="textRight tableColumnPrice" style="text-align:right;"><?php echo $text_price; ?></th>
			<th bgcolor="#ededed" align="right" class="textRight tableColumnPrice" style="text-align:right;"><?php echo $text_total; ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 0; ?>
		<?php foreach ($products as $product) { $row_style_background = ($i++ % 2) ? "#f6f6f6" :"#fafafa"; ?>
			<tr>
				<td bgcolor="<?php echo $row_style_background; ?>">
					<table border="0" cellspacing="0" cellpadding="0" width="100%" class="product-table tableStack" style="table-layout: auto;">
						<tr>
							<td>
								<?php if ($product['image']) { ?>
								<table align="left" cellpadding="0" cellspacing="0" width="20%" style="table-layout:auto;max-width:20%;width:auto;display:inline;float:left;">
									<tr>
										<td class="emailProductImage" style="width:1%;padding:0 10px 0 0">
											<a href="<?php echo $product['url']; ?>">
												<img src="<?php echo $product['image']; ?>" alt="" style="float:left;inline:inline;margin-right:5px;" />
											</a>
										</td>
									</tr>
								</table>
								<table align="left" cellpadding="0" cellspacing="0" width="76%" style="table-layout:auto;width:66;display:inline;float:left;">
									<tr>
										<td style="font-size:1px;line-height:6px;height:6px;">&nbsp;</td>
									</tr>
									<tr>
										<td class="emailProductData">
											<a href="<?php echo $product['url']; ?>" class="link">
												<b style="font-size:1.1em;font-weight:bold;"><?php echo $product['name']; ?></b>
											</a>
										</td>
									</tr>
									<?php if ($product['model']) { ?>
									<tr>
										<td style="font-size:1px;line-height:3px;height:3px;">&nbsp;</td>
									</tr>
									<tr>
										<td>
											<div class="list-product-options" title="<?php echo $text_model; ?>" style="font-size:0.85em;"><?php echo $product['model']; ?></div>
										</td>
									</tr>
									<?php } ?>
								</table>
								<?php } else { ?>
								<td class="emailProductData">
									<a href="<?php echo $product['url']; ?>" class="link">
										<b style="font-size:1.1em;font-weight:bold;"><?php echo $product['name']; ?></b>
									</a>
									<?php if ($product['model']) { ?>
										<div class="list-product-options" title="<?php echo $text_model; ?>" style="font-size:0.85em;line-height:16px;"><?php echo $product['model']; ?></div>
									<?php } ?>
								</td>
								<?php } ?>
							</td>
						</tr>
					</table>
					<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td>
								<?php /*<div style="font-size:12px;"><?php echo $product['description']; ?></div>*/ ?>

								<?php if (!empty($product['option'])) { ?>
								<div class="list-product-options" style="font-size:0.85em;line-height:16px;">
									<?php foreach ($product['option'] as $option) { ?>
									&raquo; <strong><?php echo $option['name']; ?>:</strong>&nbsp;<?php echo $option['value']; ?><?php if ($option['price']) echo "&nbsp;(".$option['price'].")"; ?><br />
									<?php } ?>
								</div>
								<?php } ?>
							</td>
						</tr>
					</table>
				</td>
				<?php if ($config['order_products']['quantity_column']) { ?>
				<td bgcolor="<?php echo $row_style_background; ?>" align="center" class="textCenter tableColumnQuantity" style="text-align:center;">
					<?php echo $product['quantity']; ?>
				</td>
				<?php } ?>
				<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight tableColumnPrice" style="text-align:right;">
					<?php if ($config['order_products']['quantity_column']) { ?>
						<span class="tableColumnPriceLabel" style="mso-hide:all;display:none;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"><?php echo $product['quantity']; ?> <b>x</b></span>
					<?php } else { ?>
						<?php echo $product['quantity']; ?> <b>x</b>
					<?php } ?>
					<?php echo $product['price']; ?>
				</td>
				<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight tableColumnPrice" style="text-align:right;">
					<?php echo $product['total']; ?>
				</td>
			</tr>
		<?php } ?>

		<?php if (isset($vouchers)) { ?>
			<?php foreach ($vouchers as $voucher) { $row_style_background = ($i++ % 2) ? "#f6f6f6" :"#fafafa"; ?>
			<tr>
				<td bgcolor="<?php echo $row_style_background; ?>"><?php echo $voucher['description']; ?></td>
				<?php if ($config['order_products']['quantity_column']) { ?>
					<td bgcolor="<?php echo $row_style_background; ?>" class="tableColumnQuantity" style="border-left:none"<?php if ($config['order_products']['quantity_column']) { ?> colspan="2"<?php } ?>></td>
				<?php } ?>
				<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight emailPrice" style="text-align:right;"><?php echo $voucher['amount']; ?></td>
			</tr>
			<?php } ?>
		<?php } ?>
	</tbody>
	<?php if (isset($totals)) { ?>
	<tfoot>
		<?php foreach ($totals as $total) {
			$row_style_background = ($i++ % 2) ? "#f6f6f6" :"#fafafa"; ?>
		<tr>
			<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight" colspan="<?php echo ($config['order_products']['quantity_column']) ? '3' : '2'; ?>" style="text-align:right;"><b><?php echo $total['title']; ?></b></td>
			<td bgcolor="<?php echo $row_style_background; ?>" align="right" class="textRight emailPrice" style="text-align:right;"><?php echo $total['text']; ?></td>
		</tr>
		<?php } ?>
	</tfoot>
	<?php } ?>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15" style="font-size:1px;line-height:15px;mso-margin-top-alt:1px;">&nbsp;</td></tr></table>
<?php } ?>