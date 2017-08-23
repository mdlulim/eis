<?php if(!empty($products)) { ?>
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="product-table tableStack" style="table-layout: auto;">
	<tr>
		<td>
			<table align="left" cellpadding="0" cellspacing="0" width="60%" style="table-layout:auto;width:60%;">
				<tr>
					<td>
						<table cellpadding="5" cellspacing="0" width="100%">
							<tbody>
							<?php $i = 0; ?>
							<?php foreach ($products as $product) { $i++; ?>
							<tr><td style="background:#DBDBDB;font-size:1px;line-height:1px;height:0;">&nbsp;</td></tr>
							<tr><td style="height:10px;line-height:10px;font-size:1px;">&nbsp;</td></tr>
							<tr>
								<td>
									<table border="0" cellspacing="0" cellpadding="0" width="100%" class="product-table tableStack" style="table-layout: auto;">
										<tr>
											<?php if ($product['image']) { ?>
											<td class="emailProductImage" style="width:20%;vertical-align:top;">
												<a href="<?php echo $product['url']; ?>">
													<img src="<?php echo $product['image']; ?>" alt="" style="width:100%;height:auto;display:block;" />
												</a>
											</td>
											<?php } ?>
											<td style="width:10px;"></td>
											<td>
												<table border="0" cellspacing="0" cellpadding="0" width="100%">
													<tr>
														<td class="emailProductData">
															<a href="<?php echo $product['url']; ?>" class="link">
																<b style="font-size:1.1em;font-weight:bold;"><?php echo $product['name']; ?></b>
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
													<tr>
														<td>
															<strong>
																<?php if (!$config['order_products']['quantity_column']) { ?><?php echo $product['quantity']; ?> <b>x</b><?php } ?>
																<?php echo $product['price']; ?>
															</strong>
														</td>
													</tr>
													<?php if ($config['order_products']['quantity_column']) { ?>
													<tr>
														<td height="6"></td>
													</tr>
													<tr>
														<td>
															<?php echo $text_quantity; ?>
															<strong style="font-size:1.05em;font-weight:normal;"><span style="font-weight:bold"><?php echo $product['quantity']; ?></span></strong>
														</td>
													</tr>
													<?php } ?>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><td style="height:10px;line-height:10px;font-size:1px;">&nbsp;</td></tr>
							<?php } ?>
						</table>
					</td>
					<td style="width:10px">&nbsp;</td>
				</tr>
			</table>
			<table align="left" cellpadding="0" cellspacing="0" width="40%" style="table-layout:auto;width:40%;">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0" width="100%" class="table2 orderTotal" style="border:1px solid #DBDBDB;">
							<?php if (isset($vouchers)) { ?>
							<?php $i = 0; ?>
								<tbody>
								<?php foreach ($vouchers as $voucher) { $row_style_background = ($i++ % 2) ? "#f6f6f6" :"#fafafa"; ?>
								<tr>
									<td style="padding: 5px 0 5px 6px;border-bottom:1px solid #DBDBDB"><?php echo $voucher['description']; ?></td>
									<td class="emailPrice" style="padding:2px 6px 2px 0;text-align:right;border-bottom:1px solid #DBDBDB"><?php echo $voucher['amount']; ?></td>
								</tr>
								<?php } ?>
								</tbody>
							<?php } ?>
							<?php if (isset($totals)) { ?>
							<?php $i = 0; ?>
							<tfoot>
							<?php foreach ($totals as $total) { $row_style_background = ($i++ % 2) ? "#f6f6f6" :"#fafafa"; ?>
							<tr>
								<td>
									<table cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td style="padding: 5px 0 5px 6px;<?php if (count($totals)!= $i) { ?>border-bottom:1px solid #DBDBDB;<?php } ?>" bgcolor="<?php echo $row_style_background; ?>"><b><?php echo $total['title']; ?></b></td>
											<td class="emailPrice" style="padding:2px 6px 2px 0;text-align:right;<?php if (count($totals)!= $i) { ?>border-bottom:1px solid #DBDBDB;<?php } ?>" bgcolor="<?php echo $row_style_background; ?>"><?php echo $total['text']; ?></td>
										</tr>
									</table>
								</td>
							</tr>
							<?php } ?>
							</tfoot>
							<?php } ?>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table class="emailSpacer" cellpadding="0" cellspacing="0" width="100%">
	<tr><td height="15" style="font-size:1px;line-height:15px;mso-margin-top-alt:1px;">&nbsp;</td></tr>
	<tr><td height="1" bgcolor="#DBDBDB" style="font-size:1px;line-height:1px;mso-margin-top-alt:1px;">&nbsp;</td></tr>
	<tr><td height="15" style="font-size:1px;line-height:15px;mso-margin-top-alt:1px;">&nbsp;</td></tr>
</table>
<?php } ?>