<?php if(!empty($products)) { ?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="tableOrderClean tableStack" style="table-layout: auto;">
	<tr>
	<tr><td height="1" bgcolor="#DBDBDB" style="font-size:1px;line-height:1px;mso-margin-top-alt:1px;">&nbsp;</td></tr>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td bgcolor="#DBDBDB" style="font-size:1px;line-height:0;width:1px;padding:0;background:#DBDBDB">&nbsp;</td>
					<td style="font-size:1px;line-height:0;width:2%;padding:0;">&nbsp;</td>
					<td>
						<table cellpadding="0" cellspacing="0" width="100%">
							<tbody>
							<tr><td style="height:4px;line-height:4px;padding:0;font-size:1px;">&nbsp;</td></tr>
							<?php $i = 0; foreach ($products as $product) { $i++; ?>
							<tr><td style="height:10px;line-height:10px;padding:0;font-size:1px;">&nbsp;</td></tr>
							<tr>
								<td>
									<table border="0" cellspacing="0" cellpadding="0" width="100%" class="product-table tableStack" style="table-layout: auto;">
										<tr>
											<?php if ($product['image']) { ?>
											<td class="emailProductImage" style="width:15%;vertical-align:top;text-align:center;">
												<a href="<?php echo $product['url']; ?>">
													<img src="<?php echo $product['image']; ?>" alt="" style="margin:0 auto;"/>
												</a>
											</td>
											<td style="width:5%"></td>
											<?php } ?>
											<td>
												<table border="0" cellspacing="0" cellpadding="0" width="100%">
													<tr>
														<td class="emailProductData">
															<a href="<?php echo $product['url']; ?>" class="link">
																<strong style="font-size:1.1em;font-weight:bold;"><?php echo $product['name']; ?></strong>
															</a>
															<?php if ($product['model']) { ?>
															<span class="list-product-options" title="<?php echo $text_model; ?>" style="font-size:0.85em;line-height:16px;">- <?php echo $product['model']; ?></span>
															<?php } ?>
															<?php if (!empty($product['option'])) { ?>
															<div class="list-product-options" style="font-size:0.85em;line-height:16px;">
																<?php foreach ($product['option'] as $option) { ?>
																&raquo; <strong><?php echo $option['name']; ?>:</strong>&nbsp;<?php echo $option['value']; ?><?php if ($option['price']) echo "&nbsp;(".$option['price'].")"; ?><br />
																<?php } ?>
															</div>
															<?php } ?>
															<?php /*<div style="font-size:0.85em;"><?php echo $product['description']; ?></div>*/ ?>
														</td>
													</tr>
													<tr>
														<td height="8"></td>
													</tr>
													<?php if ($config['order_products']['quantity_column']) { ?>
													<tr>
														<td><?php echo $text_quantity; ?> <strong><?php echo $product['quantity']; ?></strong></td>
													</tr>
													<?php } ?>
													<tr>
														<td>
															<strong>
																<?php if (!$config['order_products']['quantity_column']) { ?><?php echo $product['quantity']; ?> <b>x</b><?php } ?> <?php echo $product['price']; ?>
															</strong>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><td style="height:10px;line-height:10px;padding:0;font-size:1px;">&nbsp;</td></tr>
							<tr><td bgcolor="#EEEEEE" style="font-size:1px; line-height:1px;height:1px;padding:0;background:#EEEEEE">&nbsp;</td></tr>
							<?php } ?>
							<tr><td style="height:10px;line-height:10px;padding:0;font-size:1px;">&nbsp;</td></tr>
						</table>
					</td>
					<td style="font-size:1px;line-height:0;width:2%;padding:0;">&nbsp;</td>
					<td bgcolor="#DBDBDB" style="font-size:1px;line-height:0;width:1px;padding:0;background:#DBDBDB">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td bgcolor="#DBDBDB" style="font-size:1px;line-height:0;width:1px;padding:0;background:#DBDBDB">&nbsp;</td>
					<td style="font-size:1px;line-height:0;width:2%;padding:0;">&nbsp;</td>
					<td>
						<table cellpadding="0" cellspacing="0" width="100%" class="orderTotal">
							<?php if (isset($vouchers)) { ?>
							<tbody>
							<?php foreach ($vouchers as $voucher) { ?>
							<tr><td style="height:2px;line-height:2px;font-size:1px;">&nbsp;</td></tr>
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td style="width:30%;padding-right:6px;"><b style="font-size:0.9em"><?php echo $voucher['description']; ?></b></td>
											<td class="emailPrice" style="text-align:left;"><?php echo $voucher['amount']; ?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><td style="height:2px;line-height:2px;font-size:1px;">&nbsp;</td></tr>
							<tr><td bgcolor="#EEEEEE" style="font-size:1px; line-height:1px;height:1px;padding:0;background:#EEEEEE">&nbsp;</td></tr>
							<?php } ?>
							</tbody>
							<?php } ?>

							<?php if (isset($totals)) { ?>
							<tfoot>
							<?php foreach ($totals as $total) { ?>
							<tr><td style="height:4px;line-height:4px;font-size:1px;">&nbsp;</td></tr>
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td style="width:30%;padding-right:6px;"><b style="font-size:0.9em"><?php echo $total['title']; ?></b></td>
											<td class="emailPrice" style="text-align:left;"><?php echo $total['text']; ?></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><td style="height:4px;line-height:4px;font-size:1px;">&nbsp;</td></tr>
							<?php } ?>
							<tr><td style="height:12px;line-height:12px;font-size:1px;">&nbsp;</td></tr>
							</tfoot>
							<?php } ?>
						</table>
					</td>
					<td style="font-size:1px;line-height:0;width:2%;padding:0;">&nbsp;</td>
					<td bgcolor="#DBDBDB" style="font-size:1px;line-height:0;width:1px;padding:0;background:#DBDBDB">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="1" bgcolor="#DBDBDB" style="font-size:1px;line-height:1px;mso-margin-top-alt:1px;">&nbsp;</td></tr>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%"><tr><td height="15" style="font-size:1px;line-height:15px;mso-margin-top-alt:1px;">&nbsp;</td></tr></table>
<?php } ?>