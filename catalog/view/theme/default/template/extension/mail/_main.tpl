<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="x-apple-disable-message-reformatting">
	<meta name="author" content="Opencart-Templates" />
	<title><?php echo $title;?></title>

	<style type="text/css">
		.ReadMsgBody {width:100%;}
		.ExternalClass {width:100%;}
		.ExternalClass * {line-height:100%;}

		table { border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;table-layout:fixed;}
		table table { table-layout:auto;}

		#emailTemplate {
			-ms-text-size-adjust:100%;
			font-family:<?php echo $config['body_font_family'];?>;
			font-size:<?php echo $config['body_font_size'];?>px;
			font-weight:normal;
			line-height:1.6;
			color:<?php echo $config['body_font_color'];?>;
		}
		#emailTemplate td {
			border-collapse:collapse;
			padding:0;
		}

		#emailTemplate img {
			-ms-interpolation-mode:bicubic;/* Make Microsoft apps scale images properly. */
			display:block;
			width:auto;
			max-width:100% !important;
			/* height:auto;break Outlook.com online with image disabled */
			line-height:100%;
			border:none;
			outline:none;
			text-decoration:none;
		}

		#emailTemplate .emailHeadText p,
		#emailTemplate .emailHeaderHtml p {
			font-size:inherit;
			font-weight:normal;
			line-height:1;
			margin:0;
			padding:0;
		}
		#emailTemplate .emailHeadText a,
		#emailTemplate .emailHeaderHtml a {
			display:inline-block;
			white-space:nowrap;
			word-spacing:0;
			font-size:inherit;
			font-weight:normal;
		}
		#emailTemplate .emailHeaderHtml a {
			color:#f5f5f5;
		}

		#emailTemplate .emailFooterText p {
			font-family:<?php echo $config['body_font_family'];?>;
			font-size:<?php echo $config['footer_font_size'];?>px;
			color:<?php echo $config['footer_font_color'];?>;
			display:inline-block;
			padding-bottom:0;
		}
		#emailTemplate .emailFooterText a {
			color:<?php echo $config['footer_font_color'];?>;
		}

		<?php if ($config['email_responsive']):?>
		@media all and (max-width:650px) {
		<?php /* #emailTemplate img[class=emailStretch] { width:100% !important;height:auto !important;max-width:<?php echo $config['email_width'];?>px !important;display:block !important } */ ?>
		#emailTemplate .mainContainer { max-width:none !important;width:100% !important;margin-left:0 !important;margin-right:0 !important }
			#emailTemplate .emailShadow { display:none !important;}
			#emailTemplate .emailHeaderHeight { height:auto !important;}
			#emailTemplate .emailHeaderWrap { background-size:auto 100% !important;}
			#emailTemplate td.emailLogo { padding:20px 0 !important;}
			#emailTemplate td.emailLogo img { max-width:90% !important;}
			#emailTemplate .heading1, #emailTemplate .heading2, #emailTemplate .title { font-size:16px !important;line-height:20px !important;}
			#emailTemplate .heading3 { font-size:14px !important;}
			#emailTemplate .emailFooterText p { font-size:11px !important }
		}

		@media all and (max-width:425px) {
			#emailTemplate .mobile-hide {
				display:none !important;
			}

			#emailTemplate .tableStack table {
				width:100% !important;
				max-width:100% !important;
			}

			#emailTemplate .tableInfo.tableStack table,
			#emailTemplate .tableInfo .tableStack table{
				border-top:1px solid #E0E0E0 !important;
			}
			#emailTemplate .tableInfo.tableStack table:first-child,
			#emailTemplate .tableInfo .tableStack table:first-child {
				border-top:none !important;
			}

			#emailTemplate .tableColumnQuantity	{
				display:none !important;
			}
			#emailTemplate .tableColumnPrice .tableColumnPriceLabel {
				display:block !important;
				max-height:none !important;
				max-width:none !important;
				opacity:1 !important;
			}
			#emailTemplate .tableOrder thead > tr > th {
				width:auto;
			}
			#emailTemplate .productImage {
				float:none !important;
				display:block !important;
			}
			#emailTemplate .emailMainText,
			#emailTemplate .emailShowcaseInner { padding-left:15px !important;padding-right:15px !important }
			#emailTemplate .clearMobile { clear:both !important }
			#emailTemplate .emailShowcaseItem { width:50% !important;max-width:none !important;}
			#emailTemplate .emailShowcaseItem > table { width:100% !important }
		}

		<?php /* Replace logo with background image for mobile
@media all and (max-device-width:489px) {
	#emailTemplate td.emailLogo span {
		background-image:url(http://www.sample.com/mobile.jpg) !important;
	    background-repeat:no-repeat !important;
	    background-position:center center !important;
		display:block !important;
		width:100px !important;
		height:100px !important;
	}
	#emailTemplate img.emailLogo { visibility:hidden !important }
}
*/?>
		  <?php endif;?>
	</style>
</head>
<body text="<?php echo $config['body_font_color'];?>" link="<?php echo $config['body_link_color'];?>" alink="<?php echo $config['body_link_color'];?>" vlink="<?php echo $config['body_link_color'];?>" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100%;margin:0!important;padding:0!important;-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;font-family:Arial, Helvetica, sans-serif;-webkit-text-size-adjust:100%;">
<?php if (!empty($preheader_preview)) { ?>
<div style="mso-hide:all;display:none !important;font-size:1px;color:#333333;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;"><?php echo $preheader_preview;?></div>
<?php } ?>
<div id="emailTemplate" style="background-color:<?php echo $config['body_bg_color'];?>;font-family:<?php echo $config['body_font_family'];?>;font-size:<?php echo $config['body_font_size'];?>px;line-height:1.6;color:<?php echo $config['body_font_color'];?>;width:100% !important;min-width:100%;margin:0 !important;padding:0 !important;font-smoothing:antialiased;-webkit-font-smoothing:antialiased;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;">
	<table class="emailStyle emailStyle<?php echo ucwords($config['style']);?>" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="<?php echo $config['body_bg_color'];?>" style="<?php if($config['body_bg_image']) { ?>background-image:url('<?php echo $config['body_bg_image'];?>');<?php } ?><?php if($config['body_bg_image_repeat']) { ?>background-repeat:<?php echo $config['body_bg_image_repeat'];?>;<?php } ?><?php if($config['body_bg_image_position']) { ?>background-position:<?php echo $config['body_bg_image_position'];?>;<?php } ?>height:100% !important;margin:0;padding:0;width:100% !important;">
		<?php if ($config['head_text'] || (isset($config['shadow_top']) && $config['shadow_top']['length'])):?>
		<tr>
			<td class="emailWrapper" style="border-collapse:collapse;padding:0;font-size:<?php echo $config['body_font_size'];?>px;line-height:1.4;vertical-align:middle;font-family:<?php echo $config['body_font_family'];?>;color:<?php echo $config['body_font_color'];?>;text-align:<?php echo $config['text_align'];?>;">
				<table class="emailHead" border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td align="<?php echo $config['page_align'];?>" valign="top"<?php if($config['head_section_bg_color']){ ?> bgcolor="<?php echo $config['head_section_bg_color'];?>" style="background:<?php echo $config['head_section_bg_color'];?>"<?php } ?>>
						<?php if ($config['page_align'] == 'center') { ?><center>
							<!--[if mso]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $config['email_full_width'];?>" style="width:<?php echo $config['email_full_width'];?>;"><tr><td>
							<![endif]--><?php } ?>
							<div class="mainContainer" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>">
								<table class="mainContainer" width="100%" cellpadding="0" cellspacing="0" border="0" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>">
									<?php if ($config['head_text']):?>
									<tr>
										<td>
											<table border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:fixed">
												<tr>
													<td width="10" style="font-size:1px;">&nbsp;</td>
													<td class="emailHeadText" style="line-height:1.4;vertical-align:middle;font-family:<?php echo $config['body_font_family'];?>;color:<?php echo $config['body_font_color'];?>;font-size:12px;font-weight:bold;word-spacing:2px;text-align:right;"><?php echo $config['head_text'];?></td>
													<td width="10" style="font-size:1px;">&nbsp;</td>
												</tr>
											</table>
										</td>
									</tr>
									<?php endif;?>
									<tr>
										<td>
											<?php if (isset($config['shadow_top']) && $config['shadow_top']['overlap']):?>
											<table class="emailShadow" border="0" cellspacing="0" cellpadding="0" width="100%">
												<tr>
													<?php if(!empty($config['shadow_top']['left_img'])){ ?>
													<td width="<?php echo $config['shadow_top']['left_img_width'];?>" height="<?php echo $config['shadow_top']['left_img_height'];?>" valign="top" style="font-size:1px;line-height:0;mso-margin-top-alt:1px;">
														<img src="<?php echo $config['shadow_top']['left_img'];?>" width="<?php echo $config['shadow_top']['left_img_width'];?>" height="<?php echo $config['shadow_top']['left_img_height'];?>" alt="" style="display:inline-block;width:auto;max-width:100% !important;line-height:100%;" />
													</td><?php } ?>
													<td valign="top" style="font-size:1px;line-height:0;mso-margin-top-alt:1px;">
														<table class="emailShadowTop" border="0" cellspacing="0" cellpadding="0" width="100%">
															<?php if(!empty($config['shadow_top']['bg'])) echo $config['shadow_top']['bg'];?>
															<tr>
																<td height="<?php echo $config['shadow_top']['overlap'];?>" bgcolor="<?php echo $config['header_bg_color'];?>" style="background:<?php echo $config['header_bg_color'];?>;height:<?php echo $config['shadow_top']['overlap'];?>px;font-size:1px;line-height:<?php echo $config['shadow_top']['overlap'];?>px;mso-margin-top-alt:1px;">&nbsp;</td>
															</tr>
														</table>
													</td>
													<?php if(!empty($config['shadow_top']['right_img'])){ ?>
													<td width="<?php echo $config['shadow_top']['right_img_width'];?>" height="<?php echo $config['shadow_top']['right_img_height'];?>" valign="top" style="font-size:1px;line-height:0;mso-margin-top-alt:1px;">
														<img src="<?php echo $config['shadow_top']['right_img'];?>" width="<?php echo $config['shadow_top']['right_img_width'];?>" height="<?php echo $config['shadow_top']['right_img_height'];?>" alt="" style="display:inline-block;width:auto;max-width:100% !important;line-height:100%;" />
													</td><?php } ?>
												</tr>
											</table>
											<?php endif;?>
										</td>
									</tr>
								</table>
							</div>
							<?php if ($config['page_align'] == 'center') { ?><!--[if mso]>
							</td></tr></table>
							<![endif]-->
						</center><?php } ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php endif;?>
		<?php if ($config['header_height']):?>
		<tr>
			<div class="emailWrapper" width="100%">
				<table class="emailHeader" border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td align="<?php echo $config['page_align'];?>" valign="top"<?php if($config['header_section_bg_color']){ ?> bgcolor="<?php echo $config['header_section_bg_color'];?>" style="background:<?php echo $config['header_section_bg_color'];?>"<?php } ?>>
							<?php if ($config['page_align'] == 'center') { ?><center>
							<!--[if mso]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $config['email_full_width'];?>" style="width:<?php echo $config['email_full_width'];?>;"><tr><td>
							<![endif]--><?php } ?>
							<div class="mainContainer" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>">
								<?php if (!empty($config['header_spacing'][0])):?>
								<table class="emailSpacing" border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr><td height="<?php echo $config['header_spacing'][0];?>" valign="top" style="height:<?php echo $config['header_spacing'][0];?>px;font-size:0;line-height:<?php echo $config['header_spacing'][0];?>px;">&nbsp;</td></tr>
								</table>
								<?php endif;?>
								<table class="mainContainer emailTableShadow emailHeaderHeight" width="100%" cellpadding="0" cellspacing="0" border="0" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>table-layout:auto !important;">
									<tr>
										<?php if (isset($config['shadow_left']['bg'])) echo $config['shadow_left']['bg'];?>
										<td>
											<div class="emailHeaderWrap" style="<?php if ($config['header_bg_image']) { ?>background-image:url('<?php echo $config['header_bg_image'];?>');<?php } ?><?php if ($config['header_bg_color']) { ?>background-color:<?php echo $config['header_bg_color'];?>;<?php } ?>background-repeat:no-repeat;background-size:100% auto;<?php if ($config['border_radius']) { ?><?php if ($config['header_border_radius'] && count($config['header_border_radius']) == 4) { ?>border-radius:<?php echo $config['header_border_radius'][0];?>px <?php echo $config['header_border_radius'][1];?>px <?php echo $config['header_border_radius'][2];?>px <?php echo $config['header_border_radius'][3];?>px;<?php } ?><?php if (count($config['header_border_top']) == 2 && $config['header_border_top'][0]) { ?>border-top:<?php echo $config['header_border_top'][0];?>px solid <?php echo $config['header_border_top'][1];?>;<?php } ?><?php if (count($config['header_border_bottom']) == 2 && $config['header_border_bottom'][0]) { ?>border-bottom:<?php echo $config['header_border_bottom'][0];?>px solid <?php echo $config['header_border_bottom'][1];?>;<?php } ?><?php if (count($config['header_border_right']) == 2 && $config['header_border_right'][0]) { ?>border-right:<?php echo $config['header_border_right'][0];?>px solid <?php echo $config['header_border_right'][1];?>;<?php } ?><?php if (count($config['header_border_left']) == 2 && $config['header_border_left'][0]) { ?>border-left:<?php echo $config['header_border_left'][0];?>px solid <?php echo $config['header_border_left'][1];?>;<?php } ?><?php } ?>">
												<table border="0" cellspacing="0" cellpadding="0" width="100%"<?php if ($config['header_bg_color']) { ?> bgcolor="<?php echo $config['header_bg_color'];?>;"<?php } ?> style="<?php if ($config['header_bg_color']) { ?>background:<?php echo $config['header_bg_color'];?>;<?php } ?><?php if ($config['header_border_radius'] && count($config['header_border_radius']) == 4) { ?>border-radius:<?php echo $config['header_border_radius'][0];?>px <?php echo $config['header_border_radius'][1];?>px <?php echo $config['header_border_radius'][2];?>px <?php echo $config['header_border_radius'][3];?>px;<?php } ?>">
													<?php if (!$config['border_radius'] && count($config['header_border_top']) == 2 && $config['header_border_top'][0]) { ?>
													<tr>
														<td height="<?php echo $config['header_border_top'][0];?>" bgcolor="<?php echo $config['header_border_top'][1];?>" style="background:<?php echo $config['header_border_top'][1];?>;height:<?php echo $config['header_border_top'][0];?>px;font-size:1px;line-height:<?php echo $config['header_border_top'][0];?>px;mso-margin-top-alt:1px;">&nbsp;</td>
													</tr>
													<?php } ?>
													<tr>
														<td class="emailHeaderHeight" valign="middle" align="<?php echo $config['logo_align'];?>" style="<?php if($config['header_height']) { ?>height:<?php echo $config['header_height'];?>px;<?php } ?>">
															<table border="0" cellspacing="0" cellpadding="0" width="100%">
																<tr>
																	<?php if (!$config['border_radius'] && count($config['header_border_left']) == 2 && $config['header_border_left'][0]) { ?>
																		<td width="<?php echo $config['header_border_left'][0];?>" bgcolor="<?php echo $config['header_border_left'][1];?>" style="background:<?php echo $config['header_border_left'][1];?>;font-size:1px;">&nbsp;</td>
																	<?php } ?>
																	<td>
																		<?php if ($config['header_bg_image']) { ?>
																		<!--[if gte mso 9]>
																		<v:image xmlns:v="urn:schemas-microsoft-com:vml" id="HeaderImage" style='behavior:url(#default#VML);display:inline-block;height:<?php echo $config['header_height'];?>px;width:<?php echo $config['email_width'];?>;border:0;' src="<?php echo $config['header_bg_image'];?>"/>
																		<v:shape xmlns:v="urn:schemas-microsoft-com:vml" id="HeaderText" style='behavior:url(#default#VML);display:inline-block;position:absolute;visibility:visible;height:<?php echo $config['header_height']-10;?>px;width:<?php echo $config['email_width'];?>;background-color:transparent;top:5px;left:5px;border:0;z-index:2;' stroked='f'>
																		<div>
																		<![endif]-->
																		<?php } ?>
																		<table class="emailHeaderHeight tableStack" cellspacing="0" cellpadding="0" border="0" width="100%" style="<?php if($config['header_height']) { ?>height:<?php echo $config['header_height'];?>px;<?php } ?>">
																			<tr>
																				<td width="10">&nbsp;</td>
																				<td>
																					<table cellpadding="0" cellspacing="0"<?php if (!empty($config['header_html'])) { ?> align="left" width="60%"<?php } ?> style="width:<?php if (!empty($config['header_html'])) { ?>60%<?php } else { ?>100%<?php } ?>">
																						<tbody>
																						<tr>
																							<td class="emailHeaderHeight emailLogo" valign="middle" align="<?php echo $config['logo_align'];?>" style="text-align:<?php echo $config['logo_align'];?>;vertical-align:middle;padding:0 30px 0 30px;font-size:<?php echo $config['logo_font_size'];?>px;line-height:1.4;font-family:<?php echo $config['body_font_family'];?>;color:<?php echo $config['logo_font_color'];?>;<?php if($config['header_height']) { ?>height:<?php echo $config['header_height'];?>px;<?php } ?>">
																								<a href="<?php echo $store_url;?>" target="_blank" title="<?php echo $store_name;?>" style="display:block;font-size:<?php echo $config['logo_font_size'];?>px;font-weight:bold;color:<?php echo $config['logo_font_color'];?>;">
																									<span id="emailLogoHolder">
																										<?php if (isset($config['logo'])) { ?>
																										<img class="emailStretch" src="<?php echo $config['logo'];?>" alt="<?php echo $store_name;?>" border="0" height="<?php echo $config['logo_height'];?>" width="<?php echo $config['logo_width'];?>" style="display:inline;height:auto;width:auto;max-width:100% !important;line-height:100%;" />
																										<?php } else { ?>
																										<?php echo $store_name;?>
																										<?php } ?>
																									</span>
																									<?php if (!empty($emailtemplate['tracking_img'])) { ?>
																									<img src="<?php echo $emailtemplate['tracking_img'];?>" width="1" height="1" style="border:0;" alt="" style="display:inline-block;width:auto;max-width:100% !important;line-height:100%;" />
																									<?php } ?>
																								</a>
																							</td>
																						</tr>
																						</tbody>
																					</table>

																					<?php if (!empty($config['header_html'])) { ?>
																					<table align="right" cellpadding="0" cellspacing="0" width="40%" style="width:40%;">
																						<tbody>
																						<tr>
																							<td height="8" style="font-size:0;line-height:8px">&nbsp;</td>
																						</tr>
																						<tr>
																							<td class="emailHeaderHtml" style="color:#DBDBDB;vertical-align:top;font-size:12px;font-weight:bold;word-spacing:2px;text-align:right;line-height:1.4;font-family:<?php echo $config['body_font_family'];?>;">
																								<?php echo $config['header_html'];?>
																							</td>
																						</tr>
																						<tr>
																							<td height="8" style="font-size:0;line-height:8px">&nbsp;</td>
																						</tr>
																						</tbody>
																					</table>
																					<?php } ?>
																				</td>
																				<td width="10" style="font-size:1px;">&nbsp;</td>
																			</tr>
																		</table>
																		<?php if ($config['header_bg_image']) { ?>
																		<!--[if gte mso 9]>
																		</div>
																		</v:shape>
																		<![endif]-->
																		<?php } ?>
																	</td>
																	<?php if (!$config['border_radius'] && count($config['header_border_right']) == 2 && $config['header_border_right'][0]) { ?>
																		<td width="<?php echo $config['header_border_right'][0];?>" bgcolor="<?php echo $config['header_border_right'][1];?>" style="background:<?php echo $config['header_border_right'][1];?>;font-size:1px;">&nbsp;</td>
																	<?php } ?>
																</tr>
															</table>
														</td>
													</tr>
													<?php if (!$config['border_radius'] && count($config['header_border_bottom']) == 2 && $config['header_border_bottom'][0]) { ?>
													<tr>
														<td height="<?php echo $config['header_border_bottom'][0];?>" bgcolor="<?php echo $config['header_border_bottom'][1];?>" style="background:<?php echo $config['header_border_bottom'][1];?>;height:<?php echo $config['header_border_bottom'][0];?>px;font-size:1px;line-height:<?php echo $config['header_border_bottom'][0];?>px;mso-margin-top-alt:1px;">&nbsp;</td>
													</tr>
													<?php } ?>
												</table>
											</div>
										</td>
										<?php if (isset($config['shadow_right']['bg'])) echo $config['shadow_right']['bg'];?>
									</tr>
								</table>
								<?php if (!empty($config['header_spacing'][1])):?>
								<table class="emailSpacing" border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr><td height="<?php echo $config['header_spacing'][1];?>" valign="top" style="height:<?php echo $config['header_spacing'][1];?>px;font-size:0;line-height:<?php echo $config['header_spacing'][1];?>px;">&nbsp;</td></tr>
								</table>
								<?php endif;?>
							</div>
							<?php if ($config['page_align'] == 'center') { ?><!--[if mso]>
							</td></tr></table>
							<![endif]-->
							</center><?php } ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<td class="emailWrapper" width="100%">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td align="<?php echo $config['page_align'];?>" valign="top"<?php if($config['body_section_bg_color']){ ?> bgcolor="<?php echo $config['body_section_bg_color'];?>" style="background:<?php echo $config['body_section_bg_color'];?>;"<?php } ?>>
							<?php if ($config['page_align'] == 'center') { ?><center>
							<!--[if mso]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $config['email_full_width'];?>" style="width:<?php echo $config['email_full_width'];?>;"><tr><td>
							<![endif]--><?php } ?>
							<div class="mainContainer" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>">
								<?php if (!empty($config['page_spacing'][0])):?>
								<table class="emailSpacing" border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr><td height="<?php echo $config['page_spacing'][0];?>" valign="top" style="height:<?php echo $config['page_spacing'][0];?>px;font-size:0;line-height:<?php echo $config['page_spacing'][0];?>px;">&nbsp;</td></tr>
								</table>
								<?php endif;?>
								<table class="mainContainer emailTableShadow" width="100%" cellpadding="0" cellspacing="0" border="0" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>table-layout:auto!important;">
									<tr>
										<?php if (isset($config['shadow_left']['bg'])) echo $config['shadow_left']['bg'];?>
										<td>
											<div class="emailPageWrap" style="<?php if ($config['border_radius']) { ?><?php if (count($config['page_border_top']) == 2 && $config['page_border_top'][0]) { ?>border-top:<?php echo $config['page_border_top'][0];?>px solid <?php echo $config['page_border_top'][1];?>;<?php } ?><?php if (count($config['page_border_bottom']) == 2 && $config['page_border_bottom'][0]) { ?>border-bottom:<?php echo $config['page_border_bottom'][0];?>px solid <?php echo $config['page_border_bottom'][1];?>;<?php } ?><?php if (count($config['page_border_right']) == 2 && $config['page_border_right'][0]) { ?>border-right:<?php echo $config['page_border_right'][0];?>px solid <?php echo $config['page_border_right'][1];?>;<?php } ?><?php if (count($config['page_border_left']) == 2 && $config['page_border_left'][0]) { ?>border-left:<?php echo $config['page_border_left'][0];?>px solid <?php echo $config['page_border_left'][1];?>;<?php } ?><?php if ($config['page_border_radius'] && count($config['page_border_radius']) == 4) { ?>border-radius:<?php echo $config['page_border_radius'][0];?>px <?php echo $config['page_border_radius'][1];?>px <?php echo $config['page_border_radius'][2];?>px <?php echo $config['page_border_radius'][3];?>px;<?php } ?><?php } ?>">
												<table border="0" cellspacing="0" cellpadding="0" width="100%" <?php if($config['body_bg_color']){ ?> bgcolor="<?php echo $config['body_bg_color'];?>"<?php } ?> style="<?php if($config['body_bg_color']){ ?>background:<?php echo $config['page_bg_color'];?>;<?php } ?><?php if ($config['page_border_radius'] && count($config['page_border_radius']) == 4) { ?>border-radius:<?php echo $config['page_border_radius'][0];?>px <?php echo $config['page_border_radius'][1];?>px <?php echo $config['page_border_radius'][2];?>px <?php echo $config['page_border_radius'][3];?>px;<?php } ?>">
													<?php if (!$config['border_radius'] && count($config['page_border_top']) == 2 && $config['page_border_top'][0]) { ?>
													<tr>
														<td height="<?php echo $config['page_border_top'][0];?>" bgcolor="<?php echo $config['page_border_top'][1];?>" style="background:<?php echo $config['page_border_top'][1];?>;height:<?php echo $config['page_border_top'][0];?>px;font-size:1px;line-height:<?php echo $config['page_border_top'][0];?>px;mso-margin-top-alt:1px;">&nbsp;</td>
													</tr>
													<?php } ?>
													<tr>
														<td>
															<table border="0" cellspacing="0" cellpadding="0" width="100%">
																<?php if (!$config['border_radius'] && count($config['page_border_left']) == 2 && $config['page_border_left'][0]) { ?>
																<td width="<?php echo $config['page_border_left'][0];?>" bgcolor="<?php echo $config['page_border_left'][1];?>" style="background:<?php echo $config['page_border_left'][1];?>;font-size:1px;">&nbsp;</td>
																<?php } ?>
																<td align="<?php echo $config['text_align'];?>" class="emailMainText emailtemplateSpacing" style="padding:<?php echo ($config['page_padding'] && count($config['page_padding']) == 4) ? $config['page_padding'][0] . 'px ' . $config['page_padding'][1] . 'px ' . $config['page_padding'][2] . 'px ' . $config['page_padding'][3] . 'px' :'10px 17px 5px 17px';?>;-ms-text-size-adjust:100%;font-size:<?php echo $config['body_font_size'];?>px;font-family:<?php echo $config['body_font_family'];?>;color:<?php echo $config['body_font_color'];?>;font-weight:normal;line-height:1.6;word-wrap:break-word;vertical-align:middle;text-align:<?php echo $config['text_align'];?>;">
																	{CONTENT}
																	<?php if ($config['page_footer_text']) { ?>
																	<div>
																		<?php echo $config['page_footer_text'];?>
																	</div>
																	<?php } ?>
																</td>
																<?php if (!$config['border_radius'] && count($config['page_border_right']) == 2 && $config['page_border_right'][0]) { ?>
																<td width="<?php echo $config['page_border_right'][0];?>" bgcolor="<?php echo $config['page_border_right'][1];?>" style="background:<?php echo $config['page_border_right'][1];?>;font-size:1px;">&nbsp;</td>
																<?php } ?>
															</table>
														</td>
													</tr>
													<?php if (!$config['border_radius'] && count($config['page_border_bottom']) == 2 && $config['page_border_bottom'][0]) { ?>
													<tr>
														<td height="<?php echo $config['page_border_bottom'][0];?>" bgcolor="<?php echo $config['page_border_bottom'][1];?>" style="background:<?php echo $config['page_border_bottom'][1];?>;height:<?php echo $config['page_border_bottom'][0];?>px;font-size:1px;line-height:<?php echo $config['page_border_bottom'][0];?>px;mso-margin-top-alt:1px;">&nbsp;</td>
													</tr>
													<?php } ?>
												</table>
											</div>
										</td>
										<?php if (isset($config['shadow_right']['bg'])) echo $config['shadow_right']['bg'];?>
									</tr>
								</table>
								<?php if (!empty($config['page_spacing'][1])):?>
								<table class="emailSpacing" border="0" cellspacing="0" cellpadding="0" width="100%">
									<tr><td height="<?php echo $config['page_spacing'][1];?>" valign="top" style="height:<?php echo $config['page_spacing'][1];?>px;font-size:0;line-height:<?php echo $config['page_spacing'][1];?>px;">&nbsp;</td></tr>
								</table>
								<?php endif;?>
							</div>
							<?php if ($config['page_align'] == 'center') { ?><!--[if mso]>
							</td></tr></table>
							<![endif]-->
							</center><?php } ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php if ($emailtemplate['showcase'] && !empty($showcase_selection)):?>
		<tr>
			<td class="emailWrapper" width="100%" style="position:relative;z-index:9;">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td class="emailShowcaseWrapper" align="<?php echo $config['page_align'];?>" valign="top" style="<?php if ($config['showcase_section_bg_color']) { ?>background:<?php echo $config['showcase_section_bg_color'];?>;<?php } ?>">
							<?php if ($config['page_align'] == 'center') { ?><center>
								<!--[if mso]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $config['email_full_width'];?>" style="width:<?php echo $config['email_full_width'];?>;"><tr><td>
								<![endif]--><?php } ?>
								<div class="mainContainer" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>">
									<table class="mainContainer emailTableShadow" width="100%" cellpadding="0" cellspacing="0" border="0" align="<?php echo $config['page_align'];?>"  style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>table-layout:auto;position:relative;z-index:11;">
										<tr>
											<?php if (isset($config['shadow_left']['bg'])) echo $config['shadow_left']['bg'];?>
											<td>
												<div class="emailShowcaseWrap" style="<?php if ($config['border_radius']) { ?><?php if ($config['showcase_border_radius'] && count($config['showcase_border_radius']) == 4) { ?>border-radius:<?php echo $config['showcase_border_radius'][0];?>px <?php echo $config['showcase_border_radius'][1];?>px <?php echo $config['showcase_border_radius'][2];?>px <?php echo $config['showcase_border_radius'][3];?>px;<?php } ?><?php if (count($config['showcase_border_top']) == 2 && $config['showcase_border_top'][0]) { ?>border-top:<?php echo $config['showcase_border_top'][0];?>px solid <?php echo $config['showcase_border_top'][1];?>;<?php } ?><?php if (count($config['showcase_border_bottom']) == 2 && $config['showcase_border_bottom'][0]) { ?>border-bottom:<?php echo $config['showcase_border_bottom'][0];?>px solid <?php echo $config['showcase_border_bottom'][1];?>;<?php } ?><?php if (count($config['showcase_border_right']) == 2 && $config['showcase_border_right'][0]) { ?>border-right:<?php echo $config['showcase_border_right'][0];?>px solid <?php echo $config['showcase_border_right'][1];?>;<?php } ?><?php if (count($config['showcase_border_left']) == 2 && $config['showcase_border_left'][0]) { ?>border-left:<?php echo $config['showcase_border_left'][0];?>px solid <?php echo $config['showcase_border_left'][1];?>;<?php } ?><?php } ?>">
													<table border="0" cellspacing="0" cellpadding="0" width="100%"<?php if ($config['showcase_bg_color']) { ?> bgcolor="<?php echo $config['showcase_bg_color'];?>;"<?php } ?> style="<?php if ($config['showcase_bg_color']) { ?>background:<?php echo $config['showcase_bg_color'];?>;<?php } ?><?php if ($config['showcase_border_radius'] && count($config['showcase_border_radius']) == 4) { ?>border-radius:<?php echo $config['showcase_border_radius'][0];?>px <?php echo $config['showcase_border_radius'][1];?>px <?php echo $config['showcase_border_radius'][2];?>px <?php echo $config['showcase_border_radius'][3];?>px;<?php } ?>">
														<?php if (!$config['border_radius'] && count($config['showcase_border_top']) == 2 && $config['showcase_border_top'][0]) { ?>
														<tr>
															<td height="<?php echo $config['showcase_border_top'][0];?>" bgcolor="<?php echo $config['showcase_border_top'][1];?>" style="background:<?php echo $config['showcase_border_top'][1];?>;height:<?php echo $config['showcase_border_top'][0];?>px;font-size:1px;line-height:<?php echo $config['showcase_border_top'][0];?>px;mso-margin-top-alt:1px;">&nbsp;</td>
														</tr>
														<?php } ?>
														<tr>
															<td>
																<table border="0" cellspacing="0" cellpadding="0" width="100%">
																	<tr>
																		<?php if (!$config['border_radius'] && count($config['showcase_border_left']) == 2 && $config['showcase_border_left'][0]) { ?>
																		<td width="<?php echo $config['showcase_border_left'][0];?>" bgcolor="<?php echo $config['showcase_border_left'][1];?>" style="background:<?php echo $config['showcase_border_left'][1];?>;font-size:1px;">&nbsp;</td>
																		<?php } ?>
																		<td class="emailShowcaseInner" style="<?php if ($config['showcase_padding'] && count($config['showcase_padding']) == 4) { echo 'padding:' . $config['showcase_padding'][0] . 'px ' . $config['showcase_padding'][1] . 'px ' . $config['showcase_padding'][2] . 'px ' . $config['showcase_padding'][3] . 'px;'; } ?>">
																			<table border="0" cellspacing="0" cellpadding="0" width="100%">
																				<?php if ($config['showcase_title']) { ?>
																				<tr>
																					<td align="<?php echo $config['text_align'];?>" class="emailShowcase" style="width:100%;padding-bottom:0">
																						<table cellpadding="0" cellspacing="0" border="0" width="100%">
																							<tr>
																								<td width="2" style="font-size:1px;"></td>
																								<td class="heading3" align="<?php echo $config['text_align'];?>" style="font-size:16px;font-weight:normal;line-height:18px;-ms-text-size-adjust:100%;font-family:<?php echo $config['body_font_family'];?>;color:<?php echo $config['body_heading_color'];?>;vertical-align:middle;font-family:<?php echo $config['body_font_family'];?>;text-align:<?php echo $config['text_align'];?>;"><strong><?php echo $config['showcase_title'];?></strong></td>
																							</tr>
																							<tr><td width="2" height="3" style="font-size:1px;line-height:3px;">&nbsp;</td>
																								<td height="3" style="font-size:1px;line-height:1px;">&nbsp;</td></tr>
																							<tr><td width="2" height="1" bgcolor="#DBDBDB" style="font-size:1px;line-height:1px;">&nbsp;</td>
																								<td height="1" bgcolor="#DBDBDB" style="font-size:1px;line-height:1px;">&nbsp;</td></tr>
																							<tr><td width="2" height="4" style="font-size:1px;line-height:4px;">&nbsp;</td>
																								<td height="4" style="font-size:1px;line-height:1px;">&nbsp;</td></tr>
																						</table>
																					</td>
																				</tr>
																				<?php } ?>
																				<tr>
																					<td align="<?php echo $config['text_align'];?>" class="emailShowcase">
																						<table border="0" cellspacing="0" cellpadding="0" width="100%">
																							<tr>
																								<td align="left" class="emailShowcaseItems" style="font-size:0%;">
																									<?php foreach($showcase_selection as $row) { ?>
																									<!--[if mso]>
																									<table align="left" border="0" cellspacing="0" cellpadding="0" width="<?php echo $config['showcase_item_width_outlook'];?>" style="width:<?php echo $config['showcase_item_width_outlook'];?>;"><tr><td align="left">
																									<![endif]-->
																									<div class="emailShowcaseItem emailtemplateSpacing" style="display:inline-block;max-width:25%;width:<?php echo $config['showcase_item_width'];?>;vertical-align:top;">
																										<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="font-size:<?php echo $config['body_font_size'];?>px;">
																											<tr>
																												<td valign="bottom" align="center" class="productTitle" style="font-weight:bold;font-size:<?php echo $config['body_font_size'];?>px;line-height:16px;vertical-align:bottom;height:50px;text-align:center;font-family:<?php echo $config['body_font_family'];?>;color:<?php echo $config['body_font_color'];?>;">
																													<a href="<?php echo $row['url'];?>" target="_blank" title="<?php echo $row['preview'];?>" style="font-size:0.9em;color:<?php echo $config['body_font_color'];?>;text-decoration:none;">
																														<?php echo $row['name_short'];?>
																													</a>
																												</td>
																											</tr>
																											<?php /* if ($row['rating']) { ?>
																											<tr><td class="rating">
																													<?php if ($row['reviews'] > 1) { ?>(<?php echo $row['reviews'];?>)<?php } ?>
																												</td></tr>
																											<?php } */ ?>
																											<tr>
																												<td class="price" style="font-size:<?php echo $config['body_font_size'];?>px;text-align:center;height:20px;line-height:18px;padding:3px 0 2px 0;vertical-align:top;font-family:<?php echo $config['body_font_family'];?>;color:<?php echo $config['body_font_color'];?>;">
																													<?php if (isset($row['price'])) { ?>
																													<div class="price-inner" style="font-size:0.95em;display:inline-block;*display:inline;zoom:1;border-top:1px dotted #ccc;padding:0 2px 0 2px;">
																														<?php if (!$row['special']) { ?>
																														<?php echo $row['price'];?>
																														<?php } else { ?>
																														<span class="price-old" style="color:#FF0000;text-decoration:line-through;"><?php echo $row['price'];?></span> <strong class="price-new" style="font-weight:bold"><?php echo $row['special'];?></strong>
																														<?php } ?>
																													</div>
																													<?php } else { echo '&nbsp;';}?>
																												</td>
																											</tr>
																											<?php if ($row['image']){ ?>
																											<tr>
																												<td valign="top" align="center" class="img" style="text-align:center;height:110px;vertical-align:top;font-size:<?php echo $config['body_font_size'];?>px;line-height:1.4;font-family:<?php echo $config['body_font_family'];?>;color:<?php echo $config['body_font_color'];?>;">
																													<a href="<?php echo $row['url'];?>" class="emailtemplateNoDisplay" target="_blank" title="<?php echo $row['preview'];?>" style="color:<?php echo $config['body_font_color'];?>;text-decoration:none;">
																														<img class="showcaseImg" src="<?php echo str_replace(' ','%20', $row['image']);?>" width="100" height="100" alt="" style="border-radius:4px;margin:0 auto;display:block;max-width:100% !important;line-height:100%;" />
																													</a>
																												</td>
																											</tr>
																											<?php } ?>
																										</table>
																									</div>
																									<!--[if mso]>
																									</td></tr></table>
																									<![endif]-->
																									<?php } ?>
																								</td>
																							</tr>
																						</table>
																					</td>
																				</tr>
																			</table>
																		</td>
																		<?php if (!$config['border_radius'] && count($config['showcase_border_right']) == 2 && $config['showcase_border_right'][0]) { ?>
																		<td width="<?php echo $config['showcase_border_right'][0];?>" bgcolor="<?php echo $config['showcase_border_right'][1];?>" style="background:<?php echo $config['showcase_border_right'][1];?>;font-size:1px;">&nbsp;</td>
																		<?php } ?>
																	</tr>
																</table>
															</td>
														</tr>
														<?php if (!$config['border_radius'] && count($config['showcase_border_bottom']) == 2 && $config['showcase_border_bottom'][0]) { ?>
														<tr>
															<td height="<?php echo $config['showcase_border_bottom'][0];?>" bgcolor="<?php echo $config['showcase_border_bottom'][1];?>" style="background:<?php echo $config['showcase_border_bottom'][1];?>;height:<?php echo $config['showcase_border_bottom'][0];?>px;font-size:1px;line-height:<?php echo $config['showcase_border_bottom'][0];?>px;mso-margin-top-alt:1px;">&nbsp;</td>
														</tr>
														<?php } ?>
													</table>
												</div>
											</td>
											<?php if (isset($config['shadow_right']['bg'])) echo $config['shadow_right']['bg'];?>
										</tr>
									</table>
								</div>
								<?php if ($config['page_align'] == 'center') { ?><!--[if mso]>
								</td></tr></table>
								<![endif]-->
							</center><?php } ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php endif;?>
		<?php if (isset($config['shadow_bottom']) && $config['shadow_bottom']['length']):?>
		<tr>
			<td class="emailWrapper" width="100%" style="margin-top:-8px;position:relative;z-index:10;">
				<table border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td align="<?php echo $config['page_align'];?>" valign="top">
							<?php if ($config['page_align'] == 'center') { ?><center>
								<!--[if mso]>
								<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $config['email_full_width'];?>" style="width:<?php echo $config['email_full_width'];?>;"><tr><td>
								<![endif]--><?php } ?>
								<div class="mainContainer" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>">
									<table class="emailShadow emailTableShadow" border="0" cellspacing="0" cellpadding="0" width="100%" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>table-layout:auto!important;">
										<tr>
											<?php if(!empty($config['shadow_bottom']['left_img'])){ ?>
											<td width="<?php echo $config['shadow_bottom']['left_img_width'];?>" height="<?php echo $config['shadow_bottom']['left_img_height'];?>" valign="top" style="font-size:1px;line-height:0;mso-margin-top-alt:1px;">
												<img src="<?php echo $config['shadow_bottom']['left_img'];?>" width="<?php echo $config['shadow_bottom']['left_img_width'];?>" height="<?php echo $config['shadow_bottom']['left_img_height'];?>" alt="" border="0" style="display:inline-block;width:auto;max-width:100% !important;line-height:100%;" />
											</td><?php } ?>
											<td valign="top" style="font-size:1px;line-height:0;mso-margin-top-alt:1px;">
												<table class="emailShadowBottom emailTableShadow" border="0" cellspacing="0" cellpadding="0" width="100%" style="table-layout:auto!important;">
													<?php if ($config['shadow_bottom']['overlap']):?>
													<tr><td height="<?php echo $config['shadow_bottom']['overlap'];?>" bgcolor="<?php echo $config['page_bg_color'];?>" style="background:<?php echo $config['page_bg_color'];?>;font-size:1px;line-height:<?php echo $config['shadow_bottom']['overlap'];?>px;mso-margin-top-alt:1px;">&nbsp;</td></tr>
													<?php endif;?>
													<?php echo $config['shadow_bottom']['bg'];?>
												</table>
											</td>
											<?php if(!empty($config['shadow_bottom']['right_img'])){ ?>
											<td width="<?php echo $config['shadow_bottom']['right_img_width'];?>" height="<?php echo $config['shadow_bottom']['right_img_height'];?>" valign="top" style="font-size:1px;line-height:0;mso-margin-top-alt:1px;">
												<img src="<?php echo $config['shadow_bottom']['right_img'];?>" width="<?php echo $config['shadow_bottom']['right_img_width'];?>" height="<?php echo $config['shadow_bottom']['right_img_height'];?>" alt="" border="0" style="display:inline-block;width:auto;max-width:100% !important;line-height:100%;" />
											</td><?php } ?>
										</tr>
									</table>
								</div>
								<?php if ($config['page_align'] == 'center') { ?><!--[if mso]>
								</td></tr></table>
								<![endif]-->
							</center><?php } ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<td class="emailWrapper" width="100%">
				<?php if (!empty($config['footer_spacing'][0])):?>
				<table class="emailSpacing" border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr><td height="<?php echo $config['footer_spacing'][0];?>" valign="top" style="height:<?php echo $config['footer_spacing'][0];?>px;font-size:0;line-height:<?php echo $config['footer_spacing'][0];?>px;">&nbsp;</td></tr>
				</table>
				<?php endif;?>
				<table class="emailFooter" border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td class="emailFooterCell" align="<?php echo $config['page_align'];?>" valign="top"<?php if($config['footer_section_bg_color']){ ?> bgcolor="<?php echo $config['footer_section_bg_color'];?>" style="background:<?php echo $config['footer_section_bg_color'];?>;"<?php } ?>>
							<?php if ($config['page_align'] == 'center') { ?><center>
							<!--[if mso]>
							<table align="center" border="0" cellspacing="0" cellpadding="0" width="<?php echo $config['email_full_width'];?>" style="width:<?php echo $config['email_full_width'];?>;"><tr><td>
							<![endif]--><?php } ?>
							<div class="mainContainer" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>">
								<table class="mainContainer" width="100%" cellpadding="0" cellspacing="0" border="0" align="<?php echo $config['page_align'];?>" style="<?php if ($config['page_align'] == 'center' && $config['email_responsive']){ ?> width:100%;max-width:<?php echo $config['email_full_width'];?>;margin-left:auto;margin-right:auto;<?php } else { ?>width:<?php echo $config['email_full_width'];?>;max-width:none;float:<?php echo $config['page_align'];?>;<?php } ?>">
									<tr>
										<td width="100%">
											<div class="emailFooterWrap" style="<?php if ($config['border_radius']) { ?><?php if ($config['footer_border_radius'] && count($config['footer_border_radius']) == 4) { ?>border-radius:<?php echo $config['footer_border_radius'][0];?>px <?php echo $config['footer_border_radius'][1];?>px <?php echo $config['footer_border_radius'][2];?>px <?php echo $config['footer_border_radius'][3];?>px;<?php } ?><?php if (count($config['footer_border_top']) == 2 && $config['footer_border_top'][0]) { ?>border-top:<?php echo $config['footer_border_top'][0];?>px solid <?php echo $config['footer_border_top'][1];?>;<?php } ?><?php if (count($config['footer_border_bottom']) == 2 && $config['footer_border_bottom'][0]) { ?>border-bottom:<?php echo $config['footer_border_bottom'][0];?>px solid <?php echo $config['footer_border_bottom'][1];?>;<?php } ?><?php if (count($config['footer_border_right']) == 2 && $config['footer_border_right'][0]) { ?>border-right:<?php echo $config['footer_border_right'][0];?>px solid <?php echo $config['footer_border_right'][1];?>;<?php } ?><?php if (count($config['footer_border_left']) == 2 && $config['footer_border_left'][0]) { ?>border-left:<?php echo $config['footer_border_left'][0];?>px solid <?php echo $config['footer_border_left'][1];?>;<?php } ?><?php } ?>">
												<table border="0" cellspacing="0" cellpadding="0" width="100%"<?php if($config['footer_bg_color']){ ?> bgcolor="<?php echo $config['footer_bg_color'];?>"<?php } ?> style="<?php if($config['footer_bg_color']){ ?>background:<?php echo $config['footer_bg_color'];?>;<?php } ?><?php if ($config['footer_border_radius'] && count($config['footer_border_radius']) == 4) { ?>border-radius:<?php echo $config['footer_border_radius'][0];?>px <?php echo $config['footer_border_radius'][1];?>px <?php echo $config['footer_border_radius'][2];?>px <?php echo $config['footer_border_radius'][3];?>px;<?php } ?>">
													<?php if (!$config['border_radius'] && !empty($config['footer_border_top'][0]) && count($config['footer_border_top']) == 2) { ?>
													<tr>
														<td height="<?php echo $config['footer_border_top'][0];?>" bgcolor="<?php echo $config['footer_border_top'][1];?>" style="background:<?php echo $config['footer_border_top'][1];?>;height:<?php echo $config['footer_border_top'][0];?>px;font-size:1px;line-height:<?php echo $config['footer_border_top'][0];?>px;mso-margin-top-alt:1px;">&nbsp;</td>
													</tr>
													<?php } ?>
													<tr>
														<td>
															<table class="emailFooter" border="0" cellspacing="0" cellpadding="0" width="100%">
																<tr>
																	<?php if (!$config['border_radius'] && count($config['footer_border_left']) == 2 && $config['footer_border_left'][0]) { ?>
																	<td width="<?php echo $config['footer_border_left'][0];?>" bgcolor="<?php echo $config['footer_border_left'][1];?>" style="background:<?php echo $config['footer_border_left'][1];?>;font-size:1px;">&nbsp;</td>
																	<?php } ?>
																	<td class="emailFooterText" style="<?php if ($config['footer_height']){ ?>height:<?php echo $config['footer_height'];?>px;<?php } ?><?php if ($config['footer_padding'] && count($config['footer_padding']) == 4) { echo 'padding:' . $config['footer_padding'][0] . 'px ' . $config['footer_padding'][1] . 'px ' . $config['footer_padding'][2] . 'px ' . $config['footer_padding'][3] . 'px;';} ?>font-family:<?php echo $config['body_font_family'];?>;font-size:<?php echo $config['footer_font_size'];?>px;line-height:normal;color:<?php echo $config['footer_font_color'];?>;text-align:<?php echo $config['footer_align'];?>;vertical-align:middle;font-family:<?php echo $config['body_font_family'];?>;text-align:<?php echo $config['footer_align'];?>;">
																		<?php if (isset($view_browser)) { ?>
																		<div id="emailtemplate-view-browser"><?php echo $view_browser;?></div>
																		<?php } ?>
																		<?php if (isset($unsubscribe)) { ?>
																		<div class="emailUnsubscribe" style="font-size:0.8em;line-height:18px;color:<?php echo $config['footer_font_color'];?>;padding:0 0 8px 0;margin:0;">
																			<?php echo $unsubscribe;?>
																			<br />
																		</div>
																		<?php } ?>

																		<?php echo $config['footer_text'];?>
																	</td>
																	<?php if (!$config['border_radius'] && count($config['footer_border_right']) == 2 && $config['footer_border_right'][0]) { ?>
																	<td width="<?php echo $config['footer_border_right'][0];?>" bgcolor="<?php echo $config['footer_border_right'][1];?>" style="background:<?php echo $config['footer_border_left'][1];?>;font-size:1px;">&nbsp;</td>
																	<?php } ?>
																</tr>
															</table>
														</td>
													</tr>
													<?php if (!$config['border_radius'] && count($config['footer_border_bottom']) == 2 && $config['footer_border_bottom'][0]) { ?>
													<tr>
														<td height="<?php echo $config['footer_border_bottom'][0];?>" bgcolor="<?php echo $config['footer_border_bottom'][1];?>" style="background:<?php echo $config['footer_border_bottom'][1];?>;height:<?php echo $config['footer_border_bottom'][0];?>;font-size:1px;line-height:<?php echo $config['footer_border_bottom'][0];?>px;mso-margin-top-alt:1px;">&nbsp;</td>
													</tr>
													<?php } ?>
												</table>
											</div>
										</td>
									</tr>
								</table>
							</div>
							<?php if ($config['page_align'] == 'center') { ?><!--[if mso]>
							</td></tr></table>
							<![endif]-->
							</center><?php } ?>
						</td>
					</tr>
				</table>
				<?php if (!empty($config['footer_spacing'][1])):?>
				<table class="emailSpacing" border="0" cellspacing="0" cellpadding="0" width="100%">
					<tr><td height="<?php echo $config['footer_spacing'][1];?>" valign="top" style="height:<?php echo $config['footer_spacing'][1];?>px;font-size:0;line-height:<?php echo $config['footer_spacing'][1];?>px;">&nbsp;</td></tr>
				</table>
				<?php endif;?>
			</td>
		</tr>
	</table>
</div>
</body>
</html>