<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
<div id="emailtemplate">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button id="submit_form_button" type="submit" form="form-emailtemplate" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>

				<a href="<?php echo $action_delete; ?>" data-confirm="<?php echo $text_confirm; ?>" class="btn btn-danger" data-toggle="tooltip" title="<?php echo $button_delete; ?>"><i class="fa fa-trash-o"></i></a>

				<?php if (!empty($action_configs) && count($action_configs) > 1) { ?>
					<div class="btn-group">
						<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-cogs"></i> <?php echo $button_configs; ?> <span class="caret"></span></button>
						<ul class="dropdown-menu dropdown-menu-right" role="menu">
							<?php if (!empty($action_default)) { ?>
								<li><a href="<?php echo $action_default; ?>"><?php echo $button_default; ?></a></li>
								<li class="divider"></li>
							<?php } ?>
							<?php foreach($action_configs as $row) { ?>
								<?php if ($row['id'] != 1) { ?>
									<li><a href="<?php echo $row['url']; ?>"<?php if ($row['id'] == $emailtemplate_config_id) { ?> class="active"<?php } ?>><?php echo $row['name']; ?></a></li>
								<?php } ?>
							<?php } ?>
					  	</ul>
					</div>
				<?php } ?>

				<a href="<?php echo $url_insert_config; ?>" class="btn btn-success" data-toggle="tooltip" title="<?php echo $text_create_config; ?>"><i class="fa fa-plus"></i><span class="hidden-sm"> <?php echo $text_create_config; ?></span></a>

				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>

			<h1><?php echo $heading_config; ?><?php if ($id == 1) { echo ' - ' . $text_default; } ?></h1>

			<ul class="breadcrumb">
        		<?php $i=1; foreach ($breadcrumbs as $breadcrumb) { ?>
        		<?php if ($i == count($breadcrumbs)) { ?>
        			<li class="active"><?php echo $breadcrumb['text']; ?></li>
        		<?php } else { ?>
        			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        		<?php } ?>
        		<?php $i++; } ?>
      		</ul>
		</div>
	</div>

	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-emailtemplate" class="container-fluid form-horizontal">
	    <?php if (isset($error_warning) && $error_warning) { ?>
	    	<div class="alert alert-danger">
				<i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
	      		<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
	    <?php } ?>

	    <?php if (isset($error_attention) && $error_attention) { ?>
	    	<div class="alert alert-warning">
				<i class="fa fa-exclamation-circle"></i> <?php echo $error_attention; ?>
	      		<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
	    <?php } ?>

	    <?php if (isset($success) && $success) { ?>
	    	<div class="alert alert-success">
				<i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
	      		<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
	    <?php } ?>

		<div class="form-group required">
			<label class="col-sm-2 control-label" for="emailtemplate_config_name"><?php echo $entry_label; ?></label>
			<div class="col-sm-10">
				<input class="form-control" id="emailtemplate_config_name" name="emailtemplate_config_name" value="<?php echo $emailtemplate_config['name']; ?>" required="required" type="text" />
				<?php if (isset($error_emailtemplate_config_name)) { ?><span class="text-danger"><?php echo $error_emailtemplate_config_name; ?></span><?php } ?>
			</div>
		</div>

		<?php if ($id != 1) { ?>
		<div class="well well-sm">
			<?php if (!empty($languages)) { ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="language_id"><?php echo $entry_language; ?></label>
				<div class="col-sm-10">
					<select class="form-control" name="language_id" id="language_id">
						<option value=""><?php echo $text_select; ?></option>
						<?php foreach($languages as $language) { ?>
						<option value="<?php echo $language['language_id']; ?>"<?php if ($language['language_id'] == $emailtemplate_config['language_id']) { ?> selected="selected"<?php } ?>>
						<?php echo $language['name']; ?>
						</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<?php } ?>

			<?php if (!empty($stores)) { ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="store_id"><?php echo $entry_store; ?></label>
				<div class="col-sm-10">
					<select class="form-control" name="store_id" id="store_id">
						<option value="-1"><?php echo $text_select; ?></option>
						<?php foreach($stores as $store) { ?>
						<option value="<?php echo $store['store_id']; ?>"<?php if ($store['store_id'] == $emailtemplate_config['store_id']) { ?> selected="selected"<?php } ?>>
						<?php echo $store['name']; ?>
						</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<?php } ?>

			<?php if (!empty($customer_groups)) { ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="customer_group_id"><?php echo $entry_customer_group; ?></label>
				<div class="col-sm-10">
					<select class="form-control" name="customer_group_id" id="customer_group_id">
						<option value="-1"><?php echo $text_select; ?></option>
						<?php foreach($customer_groups as $customer_group) { ?>
						<option value="<?php echo $customer_group['customer_group_id']; ?>"<?php if ($customer_group['customer_group_id'] == $emailtemplate_config['customer_group_id']) { ?> selected="selected"<?php } ?>>
						<?php echo $customer_group['name']; ?>
						</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>

		<div class="panel">
			<div class="panel-nav-tabs">
				<ul class="nav nav-tabs" id="config-tabs">
    				<li class="active"><a href="javascript:void(0)" data-target="#tab-settings" data-toggle="tab"><i class="fa fa-wrench hidden-xs"></i> <?php echo $heading_settings; ?></a></li>
    				<li><a href="javascript:void(0)" data-target="#tab-style" data-toggle="tab"><i class="fa fa-paint-brush hidden-xs"></i> <?php echo $heading_style; ?></a></li>
					<li><a href="javascript:void(0)" data-target="#tab-header" data-toggle="tab"><i class="fa fa-arrow-up hidden-xs"></i> <?php echo $heading_header; ?></a></li><li><a href="javascript:void(0)" data-target="#tab-page" data-toggle="tab"><i class="fa fa-bars hidden-xs"></i> <?php echo $heading_content; ?></a></li>
					<li><a href="javascript:void(0)" data-target="#tab-showcase" data-toggle="tab"><i class="fa fa-rocket hidden-xs"></i> <?php echo $heading_showcase; ?></a></li>
					<li><a href="javascript:void(0)" data-target="#tab-footer" data-toggle="tab"><i class="fa fa-arrow-down hidden-xs"></i> <?php echo $heading_footer; ?></a></li>
  				</ul>
			</div>

			<div class="tab-content">
				<div class="tab-pane fade in active" id="tab-settings">
					<?php if ($id != 1) { ?>
					<div class="form-group form-group-radio">
						<label class="col-sm-2 control-label" for="emailtemplate_config_status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
							<input name="emailtemplate_config_status" id="emailtemplate_config_status" class="input-control-checkbox" data-off-label="<?php echo $text_disabled; ?>" data-on-label="<?php echo $text_enabled; ?>" value="1" type="checkbox"<?php echo ($emailtemplate_config['status'] == 1) ? ' checked="checked"' : ''; ?>/>
						</div>
					</div>
					<?php } ?>

					<?php if (count($themes) > 1) { ?>
                  	<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_theme"><?php echo $entry_theme; ?></label>
						<div class="col-sm-10">
							<select class="form-control" name="emailtemplate_config_theme" id="emailtemplate_config_theme">
								<?php foreach($themes as $theme) { ?>
								<option value="<?php echo $theme; ?>"<?php if ($theme == $emailtemplate_config['theme']) { ?> selected="selected"<?php } ?>><?php echo $theme; ?></option>
								<?php } ?>
							</select>
							<?php if (isset($error_emailtemplate_config_theme)) { ?><span class="text-danger"><?php echo $error_emailtemplate_config_theme; ?></span><?php } ?>
						</div>
					</div>
					<?php } ?>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_wrapper_tpl"><?php echo $entry_wrapper; ?></label>
						<div class="col-sm-10">
							<input class="form-control" id="emailtemplate_config_wrapper_tpl" name="emailtemplate_config_wrapper_tpl" value="<?php echo $emailtemplate_config['wrapper_tpl']; ?>" type="text" />
							<?php if (isset($error_emailtemplate_config_name)) { ?><span class="text-danger"><?php echo $error_emailtemplate_config_name; ?></span><?php } ?>
						</div>
					</div>

					<fieldset class="form-section">
						<div class="row"><div class="col-sm-push-2 col-sm-10"><h3 class="heading"><?php echo $heading_logs; ?></h3></div></div>

						<div class="form-group form-group-radio">
							<label class="col-sm-2 control-label" for="emailtemplate_config_log"><?php echo $entry_log; ?></label>
							<div class="col-sm-4">
								<input name="emailtemplate_config_log" id="emailtemplate_config_log" class="input-control-checkbox" data-off-label="<?php echo $text_no; ?>" data-on-label="<?php echo $text_yes; ?>" value="1" type="checkbox"<?php echo ($emailtemplate_config['log'] == 1) ? ' checked="checked"' : ''; ?>/>
							</div>
							<label class="col-sm-2 control-label" for="emailtemplate_config_log_read"><?php echo $entry_log_read; ?></label>
							<div class="col-sm-4">
								<input name="emailtemplate_config_log_read" id="emailtemplate_config_log_read" class="input-control-checkbox" data-off-label="<?php echo $text_no; ?>" data-on-label="<?php echo $text_yes; ?>" value="1" type="checkbox"<?php echo ($emailtemplate_config['log_read'] == 1) ? ' checked="checked"' : ''; ?>/>
							</div>
						</div>

						<div class="form-group form-group-radio">
							<label class="col-sm-2 control-label" for="emailtemplate_config_view_browser_theme"><?php echo $entry_view_browser_theme; ?></label>
							<div class="col-sm-4">
								<input name="emailtemplate_config_view_browser_theme" id="emailtemplate_config_view_browser_theme" class="input-control-checkbox" data-off-label="<?php echo $text_no; ?>" data-on-label="<?php echo $text_yes; ?>" value="1" type="checkbox"<?php echo ($emailtemplate_config['view_browser_theme'] == 1) ? ' checked="checked"' : ''; ?>/>
							</div>
						</div>
					</fieldset>

					<fieldset class="form-section">
						<div class="row"><div class="col-sm-push-2 col-sm-10">
								<h3 class="heading"><?php echo $heading_cronjob; ?></h3>
							</div></div>

						<div class="form-group form-group-radio">
							<label class="col-sm-2 control-label" for="setting_emailtemplate_token"><?php echo $entry_token; ?></label>
							<div class="col-sm-4">
								<input class="form-control" name="setting[emailtemplate_token]" id="setting_token" value="<?php echo $setting['emailtemplate_token']; ?>" type="text" />
							</div>
							<div class="col-sm-6">
								<div class="input-group">
									<span class="input-group-addon"><?php echo $text_url; ?></span>
									<input class="form-control" value="<?php echo $cron_request_url; ?>" type="text" />
								</div>
								<div class="input-group">
									<span class="input-group-addon"><?php echo $text_path; ?></span>
									<input class="form-control" value="<?php echo $cron_request_path; ?>" type="text" />
								</div>
								<p>Path is faster but requires extra <a href="https://github.com/iSenseLabs/oc_cli" target="_blank">command line extension</a>.</p>
							</div>
						</div>
					</fieldset>

					<fieldset class="form-section">
						<div class="row"><div class="col-sm-push-2 col-sm-10"><h3 class="heading"><?php echo $heading_orders; ?></h3></div></div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="emailtemplate_config_order_products_layout"><?php echo $entry_layout; ?></label>
							<div class="col-sm-10">
								<div class="well well-sm">
									<div class="row">
										<div class="col-sm-4">
											<div class="radio">
												<label>
													<input type="radio" name="emailtemplate_config_order_products[layout]" value="default"<?php if ($emailtemplate_config['order_products']['layout'] == "default") { ?> checked="checked"<?php } ?> />
													Table (default)
												</label>
											</div>
											<div class="radio">
												<label>
													<input type="radio" name="emailtemplate_config_order_products[layout]" value="clean"<?php if ($emailtemplate_config['order_products']['layout'] == "clean") { ?> checked="checked"<?php } ?> />
													Clean
												</label>
											</div>
											<div class="radio">
												<label>
													<input type="radio" name="emailtemplate_config_order_products[layout]" value="hybrid"<?php if ($emailtemplate_config['order_products']['layout'] == "hybrid") { ?> checked="checked"<?php } ?> />
													Hybrid
												</label>
											</div>
										</div>
										<div class="col-sm-2 col-sm-push-1">
											<div class="img-preview img-order-style img-style-<?php echo $emailtemplate_config['order_products']['layout']; ?>"></div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group form-group-radio">
							<label class="col-sm-2 control-label" for="emailtemplate_config_order_table_quantity_column"><?php echo $entry_quantity_column; ?></label>
							<div class="col-sm-4">
								<input name="emailtemplate_config_order_products[quantity_column]" id="emailtemplate_config_order_table_quantity_column" class="input-control-checkbox" data-off-label="<?php echo $text_no; ?>" data-on-label="<?php echo $text_yes; ?>" value="1" type="checkbox"<?php echo ($emailtemplate_config['order_products']['quantity_column'] == 1) ? ' checked="checked"' : ''; ?>/>
							</div>
							<label class="col-sm-2 control-label" for="emailtemplate_config_order_table_admin_stock"><?php echo $entry_admin_stock; ?></label>
							<div class="col-sm-4">
								<input name="emailtemplate_config_order_products[admin_stock]" id="emailtemplate_config_order_table_admin_stock" class="input-control-checkbox" data-off-label="<?php echo $text_no; ?>" data-on-label="<?php echo $text_yes; ?>" value="1" type="checkbox"<?php echo ($emailtemplate_config['order_products']['admin_stock'] == 1) ? ' checked="checked"' : ''; ?>/>
							</div>
						</div>

						<div class="form-group form-group-radio">
							<label class="col-sm-2 control-label" for="emailtemplate_config_order_products_image_width"><?php echo $entry_product_image_width; ?></label>
							<div class="col-sm-4">
								<input class="form-control" name="emailtemplate_config_order_products[image_width]" id="emailtemplate_config_order_products_image_width" value="<?php echo $emailtemplate_config['order_products']['image_width']; ?>" type="text" />
							</div>
							<label class="col-sm-2 control-label" for="emailtemplate_config_order_products_image_height"><?php echo $entry_product_image_height; ?></label>
							<div class="col-sm-4">
								<input class="form-control" name="emailtemplate_config_order_products[image_height]" id="emailtemplate_config_order_products_image_height" value="<?php echo $emailtemplate_config['order_products']['image_height']; ?>" type="text" />
							</div>
						</div>
					</fieldset>
				</div><!-- #tab-settings -->

				<div id="tab-style" class="tab-pane fade">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_style"><?php echo $entry_style; ?></label>
						<div class="col-sm-10">
							<div class="well well-sm">
								<div class="row">
									<div class="col-sm-4">
										<select class="form-control" name="emailtemplate_config_style" id="emailtemplate_config_style">
											<option value=''><?php echo $text_select; ?></option>
											<option value="page"<?php if ('page' == $emailtemplate_config['style']) { ?> selected="selected"<?php } ?>>Page with shadow</option>
											<option value="white"<?php if ('white' == $emailtemplate_config['style']) { ?> selected="selected"<?php } ?>>Page with white body</option>
											<option value="border"<?php if ('border' == $emailtemplate_config['style']) { ?> selected="selected"<?php } ?>>Page with border</option>
											<option value="clean"<?php if ('clean' == $emailtemplate_config['style']) { ?> selected="selected"<?php } ?>>Clean</option>
											<option value="sections"<?php if ('sections' == $emailtemplate_config['style']) { ?> selected="selected"<?php } ?>>Sections</option>
											<option value="crisp"<?php if ('crisp' == $emailtemplate_config['style']) { ?> selected="selected"<?php } ?>>Crisp</option>
										</select>
										<?php if (isset($error_emailtemplate_config_style)) { ?><span class="text-danger"><?php echo $error_emailtemplate_config_style; ?></span><?php } ?>
									</div>
									<div class="col-sm-2 col-sm-push-1">
										<div class="img-preview img-preview-style img-style-<?php echo $emailtemplate_config['style']; ?>"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_email_width"><?php echo $entry_email_width; ?></label>
						<div class="col-sm-4">
							<input class="form-control" id="emailtemplate_config_email_width" name="emailtemplate_config_email_width" value="<?php echo $emailtemplate_config['email_width']; ?>" type="text" />
							<span class="help-block"><?php echo $text_help_email_width; ?></span>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_email_responsive"><?php echo $entry_responsive; ?></label>
						<div class="col-sm-4 form-group-radio">
							<input name="emailtemplate_config_email_responsive" id="emailtemplate_config_email_responsive" class="input-control-checkbox" data-off-label="<?php echo $text_no; ?>" data-on-label="<?php echo $text_yes; ?>" value="1" type="checkbox"<?php echo ($emailtemplate_config['email_responsive'] == 1) ? ' checked="checked"' : ''; ?>/>
							<?php if (isset($error_emailtemplate_config_email_responsive)) { ?><span class="text-danger"><?php echo $error_emailtemplate_config_email_responsive; ?></span><?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_body_bg_color"><?php echo $entry_bg_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['body_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['body_bg_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_body_bg_color" name="emailtemplate_config_body_bg_color" value="<?php echo $emailtemplate_config['body_bg_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
						<label class="col-sm-2 control-label"><?php echo $entry_bg_image; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-xs-12 col-lg-3">
									<a href="javascript:void(0)" id="thumb-body-bg" data-toggle="image" class="img-thumbnail"><img class="img-responsive" src="<?php echo $emailtemplate_config['body_bg_image_thumb']; ?>" alt="" data-placeholder="<?php echo $no_image; ?>" /></a>
									<input type="hidden" name="emailtemplate_config_body_bg_image" value="<?php echo $emailtemplate_config['body_bg_image']; ?>" id="input-body-bg" />
									<?php if (isset($error_emailtemplate_config_body_bg_image)) { ?><span class="text-danger"><?php echo $error_emailtemplate_config_body_bg_image; ?></span><?php } ?>
								</div>
								<div class="col-xs-12 col-lg-9">
									<select class="form-control" name="emailtemplate_config_body_bg_image_repeat">
										<option value="no-repeat"<?php if($emailtemplate_config['body_bg_image_repeat'] == 'no-repeat' || $emailtemplate_config['body_bg_image_repeat'] == ''){ ?> selected="selected"<?php } ?>>No Repeat</option>
										<option value="repeat"<?php if($emailtemplate_config['body_bg_image_repeat'] == 'repeat'){ ?> selected="selected"<?php } ?>>Repeat</option>
										<option value="repeat-x"<?php if($emailtemplate_config['body_bg_image_repeat'] == 'repeat-x'){ ?> selected="selected"<?php } ?>>Repeat Horizontal</option>
										<option value="repeat-y"<?php if($emailtemplate_config['body_bg_image_repeat'] == 'repeat-y'){ ?> selected="selected"<?php } ?>>Repeat Vertical</option>
									</select>
									<br />
									<input type="text" class="form-control" name="emailtemplate_config_body_bg_image_position" value="<?php echo $emailtemplate_config['body_bg_image_position']; ?>" placeholder="E.g: center top" />
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_page_align"><?php echo $entry_page_align; ?></label>
						<div class="col-sm-4">
							<select class="form-control " name="emailtemplate_config_page_align" id="emailtemplate_config_page_align">
								<option value="center"<?php if ($emailtemplate_config['page_align'] == 'center') { ?> selected="selected"<?php } ?>><?php echo $text_center; ?></option>
								<option value="left"<?php if ($emailtemplate_config['page_align'] == 'left') { ?> selected="selected"<?php } ?>><?php echo $text_left; ?></option>
								<option value="right"<?php if ($emailtemplate_config['page_align'] == 'right') { ?> selected="selected"<?php } ?>><?php echo $text_right; ?></option>
							</select>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_text_align"><?php echo $entry_text_align; ?></label>
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-fw fa-align-<?php echo $emailtemplate_config['text_align']; ?>"></i></span>
								<select class="form-control" name="emailtemplate_config_text_align" id="emailtemplate_config_text_align">
									<option value="left"<?php if ($emailtemplate_config['text_align'] == 'left') { ?> selected="selected"<?php } ?>><?php echo $text_left; ?></option>
									<option value="right"<?php if ($emailtemplate_config['text_align'] == 'right') { ?> selected="selected"<?php } ?>><?php echo $text_right; ?></option>
									<option value="center"<?php if ($emailtemplate_config['text_align'] == 'center') { ?> selected="selected"<?php } ?>><?php echo $text_center; ?></option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_body_font_size"><?php echo $entry_font_size; ?></label>
						<div class="col-sm-4">
							<div class="input-group">
								<input class="form-control" type="number" id="emailtemplate_config_body_font_size" name="emailtemplate_config_body_font_size" value="<?php echo $emailtemplate_config['body_font_size']; ?>" />
								<span class="input-group-addon">px</span>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_body_font_family"><?php echo $entry_font_family; ?></label>
						<div class="col-sm-4">
							<div class="well well-sm" style="overflow: auto; max-height: 120px;">
								<div class="radio">
									<label style="font-family:Arial, 'Helvetica Neue', Helvetica, sans-serif">
										<input type="radio" name="emailtemplate_config_body_font_family" value="Arial, 'Helvetica Neue', Helvetica, sans-serif"<?php if ($emailtemplate_config['body_font_family'] == "Arial, 'Helvetica Neue', Helvetica, sans-serif") { ?> checked="checked"<?php } ?> />
										Arial/Helvetica
									</label>
								</div>
								<div class="radio">
									<label style="font-family:'Courier New', Courier, monospace">
										<input type="radio" name="emailtemplate_config_body_font_family" value="'Courier New', Courier, monospace"<?php if ($emailtemplate_config['body_font_family'] == "'Courier New', Courier, monospace") { ?> checked="checked"<?php } ?> />
										Courier
									</label>
								</div>
								<div class="radio">
									<label style="font-family:Tahoma, Geneva, sans-serif">
										<input type="radio" name="emailtemplate_config_body_font_family" value="Tahoma, Geneva, sans-serif"<?php if ($emailtemplate_config['body_font_family'] == "Tahoma, Geneva, sans-serif") { ?> checked="checked"<?php } ?> />
										Tahoma
									</label>
								</div>
								<div class="radio">
									<label style="font-family:'Times New Roman', Times, serif">
										<input type="radio" name="emailtemplate_config_body_font_family" value="'Times New Roman', Times, serif"<?php if ($emailtemplate_config['body_font_family'] == "'Times New Roman', Times, serif") { ?> checked="checked"<?php } ?> />
										Times New Roman
									</label>
								</div>
								<div class="radio">
									<label style="font-family:'Trebuchet MS', Helvetica, sans-serif">
										<input type="radio" name="emailtemplate_config_body_font_family" value="'Trebuchet MS', Helvetica, sans-serif"<?php if ($emailtemplate_config['body_font_family'] == "'Trebuchet MS', Helvetica, sans-serif") { ?> checked="checked"<?php } ?> />
										Trebuchet MS
									</label>
								</div>
								<div class="radio">
									<label style="font-family:Verdana, Geneva, sans-serif">
										<input type="radio" name="emailtemplate_config_body_font_family" value="Verdana, Geneva, sans-serif"<?php if ($emailtemplate_config['body_font_family'] == "Verdana, Geneva, sans-serif") { ?> checked="checked"<?php } ?> />
										Verdana
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_body_font_color"><?php echo $entry_body_font_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['body_font_color']) { ?> style="background-color:<?php echo $emailtemplate_config['body_font_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_body_font_color" name="emailtemplate_config_body_font_color" value="<?php echo $emailtemplate_config['body_font_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_body_link_color"><?php echo $entry_body_link_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['body_link_color']) { ?> style="background-color:<?php echo $emailtemplate_config['body_link_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_body_link_color" name="emailtemplate_config_body_link_color" value="<?php echo $emailtemplate_config['body_link_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_body_heading_color"><?php echo $entry_body_heading_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['body_heading_color']) { ?> style="background-color:<?php echo $emailtemplate_config['body_heading_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_body_heading_color" name="emailtemplate_config_body_heading_color" value="<?php echo $emailtemplate_config['body_heading_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_link_style"><?php echo $entry_link_style; ?></label>
						<div class="col-sm-4">
							<select name="emailtemplate_config_link_style" id="emailtemplate_config_link_style" class="form-control">
								<option value=""<?php if ($emailtemplate_config['link_style'] == '') { ?> selected="selected"<?php } ?>><?php echo $text_default; ?></option>
								<option value="button"<?php if ($emailtemplate_config['link_style'] == 'button') { ?> selected="selected"<?php } ?>><?php echo $text_button; ?></option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 text-right"><a href="#fieldset-shadow" class="btn btn-info collapsed" data-toggle="collapse"><i class="fa fa-chevron fa-fw" ></i> <?php echo $heading_shadow; ?></a></label>
						<div class="col-sm-10">
							<div class="collapse well well-cm" id="fieldset-shadow" style="margin-bottom: 20px;">
								<div class="row">
									<label class="col-sm-2 control-label"><?php echo $text_top; ?></label>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_top_length"><?php echo $entry_height; ?></label>
										<div class="input-group">
											<input class="form-control " name="emailtemplate_config_shadow_top[length]" id="emailtemplate_config_shadow_top_length" value="<?php echo isset($emailtemplate_config['shadow_top']['length']) ? $emailtemplate_config['shadow_top']['length'] : ''; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_top_overlap"><?php echo $entry_overlap; ?></label>
										<div class="input-group">
											<input class="form-control " name="emailtemplate_config_shadow_top[overlap]" id="emailtemplate_config_shadow_top_overlap" value="<?php echo isset($emailtemplate_config['shadow_top']['overlap']) ? $emailtemplate_config['shadow_top']['overlap'] : ''; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
									<div class="col-sm-5 col-sm-offset-2 col-lg-2 col-lg-offset-0">
										<label for="emailtemplate_config_shadow_top_end"><?php echo $entry_start; ?></label>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['shadow_top']['start']) { ?> style="background-color:<?php echo $emailtemplate_config['shadow_top']['start']; ?>;"<?php } ?>></i></span>
											<input class="form-control " type="text" id="emailtemplate_config_shadow_top_end" name="emailtemplate_config_shadow_top[start]" value="<?php echo $emailtemplate_config['shadow_top']['start']; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_top_end"><?php echo $entry_end; ?></label>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['shadow_top']['end']) { ?> style="background-color:<?php echo $emailtemplate_config['shadow_top']['end']; ?>;"<?php } ?>></i></span>
											<input class="form-control " type="text" id="emailtemplate_config_shadow_top_end" name="emailtemplate_config_shadow_top[end]" value="<?php echo $emailtemplate_config['shadow_top']['end']; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
								<hr />

								<?php if ($emailtemplate_config['shadow_bottom']) { ?>
								<div class="row">
									<label class="col-sm-2 control-label"><?php echo $text_bottom; ?></label>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_bottom_length"><?php echo $entry_height; ?></label>
										<div class="input-group">
											<input class="form-control " name="emailtemplate_config_shadow_bottom[length]" id="emailtemplate_config_shadow_bottom_length" value="<?php echo isset($emailtemplate_config['shadow_bottom']['length']) ? $emailtemplate_config['shadow_bottom']['length'] : ''; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_bottom_overlap"><?php echo $entry_overlap; ?></label>
										<div class="input-group">
											<input class="form-control " name="emailtemplate_config_shadow_bottom[overlap]" id="emailtemplate_config_shadow_bottom_overlap" value="<?php echo isset($emailtemplate_config['shadow_bottom']['overlap']) ? $emailtemplate_config['shadow_bottom']['overlap'] : ''; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
									<div class="col-sm-5 col-sm-offset-2 col-lg-2 col-lg-offset-0">
										<label for="emailtemplate_config_shadow_bottom_end"><?php echo $entry_start; ?></label>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['shadow_bottom']['start']) { ?> style="background-color:<?php echo $emailtemplate_config['shadow_bottom']['start']; ?>;"<?php } ?>></i></span>
											<input class="form-control " type="text" id="emailtemplate_config_shadow_bottom_end" name="emailtemplate_config_shadow_bottom[start]" value="<?php echo $emailtemplate_config['shadow_bottom']['start']; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_bottom_end"><?php echo $entry_end; ?></label>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['shadow_bottom']['end']) { ?> style="background-color:<?php echo $emailtemplate_config['shadow_bottom']['end']; ?>;"<?php } ?>></i></span>
											<input class="form-control " type="text" id="emailtemplate_config_shadow_bottom_end" name="emailtemplate_config_shadow_bottom[end]" value="<?php echo $emailtemplate_config['shadow_bottom']['end']; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
								<hr />
								<?php } ?>

								<div class="row">
									<label class="col-sm-2 control-label"><?php echo $text_left; ?></label>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_left_length"><?php echo $entry_width; ?></label>
										<div class="input-group">
											<input class="form-control " name="emailtemplate_config_shadow_left[length]" id="emailtemplate_config_shadow_left_length" value="<?php echo isset($emailtemplate_config['shadow_left']['length']) ? $emailtemplate_config['shadow_left']['length'] : ''; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_left_overlap"><?php echo $entry_overlap; ?></label>
										<div class="input-group">
											<input class="form-control " name="emailtemplate_config_shadow_left[overlap]" id="emailtemplate_config_shadow_left_overlap" value="<?php echo isset($emailtemplate_config['shadow_left']['overlap']) ? $emailtemplate_config['shadow_left']['overlap'] : ''; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
									<div class="col-sm-5 col-sm-offset-2 col-lg-2 col-lg-offset-0">
										<label for="emailtemplate_config_shadow_left_end"><?php echo $entry_start; ?></label>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['shadow_left']['start']) { ?> style="background-color:<?php echo $emailtemplate_config['shadow_left']['start']; ?>;"<?php } ?>></i></span>
											<input class="form-control " type="text" id="emailtemplate_config_shadow_left_end" name="emailtemplate_config_shadow_left[start]" value="<?php echo $emailtemplate_config['shadow_left']['start']; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_left_end"><?php echo $entry_end; ?></label>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['shadow_left']['end']) { ?> style="background-color:<?php echo $emailtemplate_config['shadow_left']['end']; ?>;"<?php } ?>></i></span>
											<input class="form-control " type="text" id="emailtemplate_config_shadow_left_end" name="emailtemplate_config_shadow_left[end]" value="<?php echo $emailtemplate_config['shadow_left']['end']; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
								<hr />

								<div class="row">
									<label class="col-sm-2 control-label"><?php echo $text_right; ?></label>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_right_length"><?php echo $entry_width; ?></label>
										<div class="input-group">
											<input class="form-control" name="emailtemplate_config_shadow_right[length]" id="emailtemplate_config_shadow_right_length" value="<?php echo isset($emailtemplate_config['shadow_right']['length']) ? $emailtemplate_config['shadow_right']['length'] : ''; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_right_overlap"><?php echo $entry_overlap; ?></label>
										<div class="input-group">
											<input class="form-control" name="emailtemplate_config_shadow_right[overlap]" id="emailtemplate_config_shadow_right_overlap" value="<?php echo isset($emailtemplate_config['shadow_right']['overlap']) ? $emailtemplate_config['shadow_right']['overlap'] : ''; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
									<div class="col-sm-5 col-sm-offset-2 col-lg-2 col-lg-offset-0">
										<label for="emailtemplate_config_shadow_right_end"><?php echo $entry_start; ?></label>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['shadow_right']['start']) { ?> style="background-color:<?php echo $emailtemplate_config['shadow_right']['start']; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" id="emailtemplate_config_shadow_right_end" name="emailtemplate_config_shadow_right[start]" value="<?php echo $emailtemplate_config['shadow_right']['start']; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
									<div class="col-sm-5 col-lg-2">
										<label for="emailtemplate_config_shadow_right_end"><?php echo $entry_end; ?></label>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['shadow_right']['end']) { ?> style="background-color:<?php echo $emailtemplate_config['shadow_right']['end']; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" id="emailtemplate_config_shadow_right_end" name="emailtemplate_config_shadow_right[end]" value="<?php echo $emailtemplate_config['shadow_right']['end']; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
								<hr />

								<div class="row">
									<label class="col-sm-2 control-label"><?php echo $entry_corner_image; ?></label>
									<div class="col-xs-6 col-md-3 col-lg-2">
										<a href="javascript:void(0)" id="thumb-shadow-top-left" data-toggle="image" class="img-thumbnail" style="vertical-align:middle; min-height: 20px; min-width: 20px;"><img class="img-responsive" src="<?php echo $emailtemplate_config['shadow_top']['left_thumb']; ?>" alt="" data-placeholder="<?php echo $no_shadow_image; ?>" /></a>
										<label for="image-shadow-top-left"><?php echo $entry_top_left; ?></label>
		                  				<input type="hidden" name="emailtemplate_config_shadow_top[left_img]" value="<?php echo $emailtemplate_config['shadow_top']['left_img']; ?>" id="image-shadow-top-left" />
									</div>
									<div class="col-xs-6 col-md-3 col-lg-2">
										<a href="javascript:void(0)" id="thumb-shadow-top-right" data-toggle="image" class="img-thumbnail" style="vertical-align:middle; min-height: 20px; min-width: 20px;"><img class="img-responsive" src="<?php echo $emailtemplate_config['shadow_top']['right_thumb']; ?>" alt="" data-placeholder="<?php echo $no_shadow_image; ?>" /></a>
										<label for="image-shadow-top-right"><?php echo $entry_top_right; ?></label>
		                  				<input type="hidden" name="emailtemplate_config_shadow_top[right_img]" value="<?php echo $emailtemplate_config['shadow_top']['right_img']; ?>" id="image-shadow-top-right" />
									</div>
									<div class="col-sm-5 col-sm-offset-2 col-lg-2 col-lg-offset-0">
										<a href="javascript:void(0)" id="thumb-shadow-bottom-left" data-toggle="image" class="img-thumbnail" style="vertical-align:middle; min-height: 20px; min-width: 20px;"><img class="img-responsive" src="<?php echo $emailtemplate_config['shadow_bottom']['left_thumb']; ?>" alt="" data-placeholder="<?php echo $no_shadow_image; ?>" /></a>
										<label for="image-shadow-bottom-left"><?php echo $entry_bottom_left; ?></label>
										<input type="hidden" name="emailtemplate_config_shadow_bottom[left_img]" value="<?php echo $emailtemplate_config['shadow_bottom']['left_img']; ?>" id="image-shadow-bottom-left" />
									</div>
									<div class="col-xs-6 col-md-3 col-lg-2">
										<a href="javascript:void(0)" id="thumb-shadow-bottom-right" data-toggle="image" class="img-thumbnail" style="vertical-align:middle; min-height: 20px; min-width: 20px;"><img class="img-responsive" src="<?php echo $emailtemplate_config['shadow_bottom']['right_thumb']; ?>" alt="" data-placeholder="<?php echo $no_shadow_image; ?>" /></a>
										<label for="image-shadow-bottom-right"><?php echo $entry_bottom_right; ?></label>
		                  				<input type="hidden" name="emailtemplate_config_shadow_bottom[right_img]" value="<?php echo $emailtemplate_config['shadow_bottom']['right_img']; ?>" id="image-shadow-bottom-right" />
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- #tab-style -->

				<div id="tab-page" class="tab-pane fade">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_page_padding"><?php echo $entry_padding; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_page_padding[0]" value="<?php echo $emailtemplate_config['page_padding'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_page_padding[1]" value="<?php echo $emailtemplate_config['page_padding'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
							</div>

							<div class="row form-spacing">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_page_padding[2]" value="<?php echo $emailtemplate_config['page_padding'][2]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_page_padding[3]" value="<?php echo $emailtemplate_config['page_padding'][3]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
							</div>
						</div>

						<label class="col-sm-2 control-label" for="emailtemplate_config_page_spacing"><?php echo $entry_spacing; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_page_spacing[0]" value="<?php echo $emailtemplate_config['page_spacing'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_page_spacing[1]" value="<?php echo $emailtemplate_config['page_spacing'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_page_bg_color"><?php echo $entry_bg_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['page_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['page_bg_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_page_bg_color" name="emailtemplate_config_page_bg_color" value="<?php echo $emailtemplate_config['page_bg_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_body_section_bg_color"><?php echo $entry_section_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['body_section_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['body_section_bg_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_body_section_bg_color" name="emailtemplate_config_body_section_bg_color" value="<?php echo $emailtemplate_config['body_section_bg_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_page_border_top"><?php echo $entry_border; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_page_border_top[0]" value="<?php echo $emailtemplate_config['page_border_top'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="input-group input-colorpicker">
										<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['page_border_top'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['page_border_top'][1]; ?>;"<?php } ?>></i></span>
										<input type="text" class="form-control" name="emailtemplate_config_page_border_top[1]" id="emailtemplate_config_page_border_top" value="<?php echo $emailtemplate_config['page_border_top'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
										<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
									</div>

									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw"></i></span>
											<input class="form-control" name="emailtemplate_config_page_border_left[0]" value="<?php echo $emailtemplate_config['page_border_left'][0]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['page_border_left'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['page_border_left'][1]; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" name="emailtemplate_config_page_border_left[1]" id="emailtemplate_config_page_border_left" value="<?php echo $emailtemplate_config['page_border_left'][1]; ?>" placeholder="<?php echo $text_color; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_page_border_right[0]" value="<?php echo $emailtemplate_config['page_border_right'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="input-group input-colorpicker">
										<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['page_border_right'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['page_border_right'][1]; ?>;"<?php } ?>></i></span>
										<input type="text" class="form-control" name="emailtemplate_config_page_border_right[1]" id="emailtemplate_config_page_border_right" value="<?php echo $emailtemplate_config['page_border_right'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
										<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
									</div>

									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
											<input class="form-control" name="emailtemplate_config_page_border_bottom[0]" value="<?php echo $emailtemplate_config['page_border_bottom'][0]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['page_border_bottom'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['page_border_bottom'][1]; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" name="emailtemplate_config_page_border_bottom[1]" id="emailtemplate_config_page_border_bottom" value="<?php echo $emailtemplate_config['page_border_bottom'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_page_border_radius"><?php echo $entry_border_radius; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw" style="transform: rotate(-45deg);"></i></span>
										<input class="form-control" name="emailtemplate_config_page_border_radius[0]" value="<?php echo $emailtemplate_config['page_border_radius'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw" style="transform: rotate(-45deg);"></i></span>
											<input class="form-control" name="emailtemplate_config_page_border_radius[2]" value="<?php echo $emailtemplate_config['page_border_radius'][2]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw" style="transform: rotate(-45deg);"></i></span>
										<input class="form-control" name="emailtemplate_config_page_border_radius[1]" value="<?php echo $emailtemplate_config['page_border_radius'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw" style="transform: rotate(-45deg);"></i></span>
											<input class="form-control" name="emailtemplate_config_page_border_radius[3]" value="<?php echo $emailtemplate_config['page_border_radius'][3]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_page_footer_text"><?php echo $entry_footer_text; ?></label>
						<div class="col-sm-10">
							<ul class="nav nav-tabs">
								<?php $i = 1; foreach ($languages as $language) { ?>
								<li<?php if ($i == 1) { ?> class="active"<?php } ?>><a href="#" data-target="#tab-page-footer-text-<?php echo $language['code']; ?>" data-toggle="tab" title="<?php echo $language['name']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></a></li>
								<?php $i++; } ?>
							</ul>
							<div class="tab-content">
								<?php $i = 1; foreach ($languages as $language) { ?>
								<div class="tab-pane<?php if ($i == 1) { ?> active<?php } ?>" id="tab-page-footer-text-<?php echo $language['code']; ?>">
									<textarea class="summernote" name="emailtemplate_config_page_footer_text[<?php echo $language['language_id']; ?>]" id="emailtemplate_config_page_footer_text_<?php echo $language['language_id']; ?>"><?php echo $emailtemplate_config['page_footer_text'][$language['language_id']]; ?></textarea>
								</div>
								<?php $i++; } ?>
							</div>
						</div>
					</div>
				</div>

				<div id="tab-header" class="tab-pane fade">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_header_height"><?php echo $entry_height; ?></label>
						<div class="col-sm-4">
							<div class="input-group">
								<input class="form-control" id="emailtemplate_config_header_height" name="emailtemplate_config_header_height" value="<?php echo $emailtemplate_config['header_height']; ?>" type="number" min="0" step="1" />
								<span class="input-group-addon">px</span>
							</div>
							<span class="help-block"><?php echo $text_help_header_height; ?></span>
						</div>

						<label class="col-sm-2 control-label" for="emailtemplate_config_header_spacing"><?php echo $entry_spacing; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-xs-12 col-lg-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_header_spacing[0]" value="<?php echo $emailtemplate_config['header_spacing'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-12 col-lg-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_header_spacing[1]" value="<?php echo $emailtemplate_config['header_spacing'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_header_bg_color"><?php echo $entry_bg_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['header_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['header_bg_color']; ?>;"<?php } ?>></i></span>
								<input type="text" class="form-control" id="emailtemplate_config_header_bg_color" name="emailtemplate_config_header_bg_color" value="<?php echo $emailtemplate_config['header_bg_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
							<div class="input-group">
								<a href="javascript:void(0)" id="thumb-header-bg" data-toggle="image" class="img-thumbnail"><img class="img-responsive" src="<?php echo $emailtemplate_config['header_bg_image_thumb']; ?>" alt="" data-placeholder="<?php echo $no_image; ?>" /></a>
								<input type="hidden" name="emailtemplate_config_header_bg_image" value="<?php echo $emailtemplate_config['header_bg_image']; ?>" id="input-header-bg" />
								<?php if (isset($error_emailtemplate_config_header_bg_image)) { ?><span class="text-danger"><?php echo $error_emailtemplate_config_header_bg_image; ?></span><?php } ?>
							</div>
						</div>

						<label class="col-sm-2 control-label" for="emailtemplate_config_header_section_bg_color"><?php echo $entry_section_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['header_section_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['header_section_bg_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_header_section_bg_color" name="emailtemplate_config_header_section_bg_color" value="<?php echo $emailtemplate_config['header_section_bg_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_header_border_top"><?php echo $entry_border; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_header_border_top[0]" value="<?php echo $emailtemplate_config['header_border_top'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="input-group input-colorpicker">
										<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['header_border_top'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['header_border_top'][1]; ?>;"<?php } ?>></i></span>
										<input type="text" class="form-control" name="emailtemplate_config_header_border_top[1]" id="emailtemplate_config_header_border_top" value="<?php echo $emailtemplate_config['header_border_top'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
										<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
									</div>

									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw"></i></span>
											<input class="form-control" name="emailtemplate_config_header_border_left[0]" value="<?php echo $emailtemplate_config['header_border_left'][0]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['header_border_left'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['header_border_left'][1]; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" name="emailtemplate_config_header_border_left[1]" id="emailtemplate_config_header_border_left" value="<?php echo $emailtemplate_config['header_border_left'][1]; ?>" placeholder="<?php echo $text_color; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_header_border_right[0]" value="<?php echo $emailtemplate_config['header_border_right'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="input-group input-colorpicker">
										<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['header_border_right'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['header_border_right'][1]; ?>;"<?php } ?>></i></span>
										<input type="text" class="form-control" name="emailtemplate_config_header_border_right[1]" id="emailtemplate_config_header_border_right" value="<?php echo $emailtemplate_config['header_border_right'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
										<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
									</div>

									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
											<input class="form-control" name="emailtemplate_config_header_border_bottom[0]" value="<?php echo $emailtemplate_config['header_border_bottom'][0]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['header_border_bottom'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['header_border_bottom'][1]; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" name="emailtemplate_config_header_border_bottom[1]" id="emailtemplate_config_header_border_bottom" value="<?php echo $emailtemplate_config['header_border_bottom'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<label class="col-sm-2 control-label" for="emailtemplate_config_header_border_radius"><?php echo $entry_border_radius; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw" style="transform: rotate(-45deg);"></i></span>
										<input class="form-control" name="emailtemplate_config_header_border_radius[0]" value="<?php echo $emailtemplate_config['header_border_radius'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw" style="transform: rotate(-45deg);"></i></span>
											<input class="form-control" name="emailtemplate_config_header_border_radius[2]" value="<?php echo $emailtemplate_config['header_border_radius'][2]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw" style="transform: rotate(-45deg);"></i></span>
										<input class="form-control" name="emailtemplate_config_header_border_radius[1]" value="<?php echo $emailtemplate_config['header_border_radius'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw" style="transform: rotate(-45deg);"></i></span>
											<input class="form-control" name="emailtemplate_config_header_border_radius[3]" value="<?php echo $emailtemplate_config['header_border_radius'][3]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_header_html"><?php echo $entry_header_html; ?></label>
						<div class="col-sm-10">
							<ul class="nav nav-tabs">
								<?php $i = 1; foreach ($languages as $language) { ?>
								<li<?php if ($i == 1) { ?> class="active"<?php } ?>><a href="#" data-target="#tab-header-html-<?php echo $language['code']; ?>" data-toggle="tab" title="<?php echo $language['name']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></a></li>
								<?php $i++; } ?>
							</ul>
							<div class="tab-content">
								<?php $i = 1; foreach ($languages as $language) { ?>
								<div class="tab-pane<?php if ($i == 1) { ?> active<?php } ?>" id="tab-header-html-<?php echo $language['code']; ?>">
									<textarea class="summernote" name="emailtemplate_config_header_html[<?php echo $language['language_id']; ?>]" id="emailtemplate_config_header_html_<?php echo $language['language_id']; ?>"><?php echo $emailtemplate_config['header_html'][$language['language_id']]; ?></textarea>
								</div>
								<?php $i++; } ?>
							</div>
						</div>
					</div>

					<fieldset class="form-section">
						<div class="row"><div class="col-sm-push-2 col-sm-10"><h3 class="heading"><?php echo $text_logo; ?></h3></div></div>

						<div class="form-group">
							<label class="col-sm-2 control-label"><?php echo $entry_logo; ?></label>
							<div class="col-sm-4">
								<a href="javascript:void(0)" id="thumb-logo" data-toggle="image" class="img-thumbnail"><img class="img-responsive" src="<?php echo $emailtemplate_config['logo_thumb']; ?>" alt="" data-placeholder="<?php echo $no_image; ?>" /></a>
								<input type="hidden" name="emailtemplate_config_logo" value="<?php echo $emailtemplate_config['logo']; ?>" id="input-logo" />
								<?php if (isset($error_emailtemplate_config_logo)) { ?><span class="text-danger"><?php echo $error_emailtemplate_config_logo; ?></span><?php } ?>
								<span class="help-block"><?php echo $text_help_logo; ?></span>
							</div>
							<label class="col-sm-2 control-label" for="emailtemplate_config_logo_width"><?php echo $entry_logo_resize_options; ?></label>
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon input-group-addon-sm"><?php echo $text_width; ?> <i class="fa fa-arrows-h fa-fw"></i></span>
									<input class="form-control" name="emailtemplate_config_logo_width" id="emailtemplate_config_logo_width" value="<?php echo $emailtemplate_config['logo_width']; ?>" type="number" min="0" step="1" />
									<span class="input-group-addon">px</span>
								</div>
								<div class="input-group">
									<span class="input-group-addon input-group-addon-sm"><?php echo $text_height; ?> <i class="fa fa-arrows-v fa-fw"></i></span>
									<input class="form-control" name="emailtemplate_config_logo_height" id="emailtemplate_config_logo_height" value="<?php echo $emailtemplate_config['logo_height']; ?>" type="number" min="0" step="1" />
									<span class="input-group-addon">px</span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="emailtemplate_config_logo_font_color"><?php echo $text_text_color; ?></label>
							<div class="col-sm-4">
								<div class="input-group input-colorpicker">
									<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['logo_font_color']) { ?> style="background-color:<?php echo $emailtemplate_config['logo_font_color']; ?>;"<?php } ?>></i></span>
									<input class="form-control" type="text" id="emailtemplate_config_logo_font_color" name="emailtemplate_config_logo_font_color" value="<?php echo $emailtemplate_config['logo_font_color']; ?>" />
									<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="emailtemplate_config_logo_font_size"><span data-toggle="tooltip" title="<?php echo $text_help_logo_font; ?>"><?php echo $entry_font_size; ?></span></label>
							<div class="col-sm-4">
								<div class="input-group">
									<input class="form-control" id="emailtemplate_config_logo_font_size" name="emailtemplate_config_logo_font_size" value="<?php echo $emailtemplate_config['logo_font_size']; ?>" type="number" min="0" step="1" />
									<span class="input-group-addon">px</span>
								</div>
								<span class="help-block"><?php echo $text_help_logo_font; ?></span>
							</div>
							<label class="col-sm-2 control-label" for="emailtemplate_config_logo_align"><?php echo $entry_text_align; ?></label>
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-fw fa-align-<?php echo $emailtemplate_config['logo_align']; ?>"></i></span>
									<select name="emailtemplate_config_logo_align" id="emailtemplate_config_logo_align" class="form-control">
										<option value="center"<?php if ($emailtemplate_config['logo_align'] == 'center') { ?> selected="selected"<?php } ?>><?php echo $text_center; ?></option>
										<option value="left"<?php if ($emailtemplate_config['logo_align'] == 'left') { ?> selected="selected"<?php } ?>><?php echo $text_left; ?></option>
										<option value="right"<?php if ($emailtemplate_config['logo_align'] == 'right') { ?> selected="selected"<?php } ?>><?php echo $text_right; ?></option>
									</select>
								</div>
							</div>
						</div>
					</fieldset>

					<fieldset class="form-section">
						<div class="row"><div class="col-sm-push-2 col-sm-10"><h3 class="heading"><?php echo $text_header_head; ?></h3></div></div>

						<div class="form-group">
							<label class="col-sm-2 control-label" for="emailtemplate_config_head_section_bg_color"><?php echo $entry_section_color; ?></label>
							<div class="col-sm-10">
								<div class="input-group input-colorpicker">
									<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['head_section_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['head_section_bg_color']; ?>;"<?php } ?>></i></span>
									<input class="form-control " type="text" id="emailtemplate_config_head_section_bg_color" name="emailtemplate_config_head_section_bg_color" value="<?php echo $emailtemplate_config['head_section_bg_color']; ?>" />
									<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="emailtemplate_config_head_text"><?php echo $entry_head_text; ?></label>
							<div class="col-sm-10">
								<ul class="nav nav-tabs">
									<?php $i = 1; foreach ($languages as $language) { ?>
									<li<?php if ($i == 1) { ?> class="active"<?php } ?>><a href="#" data-target="#tab-head-text-<?php echo $language['code']; ?>" data-toggle="tab" title="<?php echo $language['name']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></a></li>
									<?php $i++; } ?>
								</ul>
								<div class="tab-content">
									<?php $i = 1; foreach ($languages as $language) { ?>
									<div class="tab-pane<?php if ($i == 1) { ?> active<?php } ?>" id="tab-head-text-<?php echo $language['code']; ?>">
										<textarea class="summernote" name="emailtemplate_config_head_text[<?php echo $language['language_id']; ?>]" id="emailtemplate_config_head_text_<?php echo $language['language_id']; ?>"><?php echo $emailtemplate_config['head_text'][$language['language_id']]; ?></textarea>
									</div>
									<?php $i++; } ?>
								</div>
							</div>
						</div>
					</fieldset>
				</div><!-- #tab-header -->

				<div id="tab-footer" class="tab-pane fade">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_height"><?php echo $text_height; ?></label>
						<div class="col-sm-4">
							<div class="input-group">
								<input class="form-control" id="emailtemplate_config_footer_height" name="emailtemplate_config_footer_height" value="<?php echo $emailtemplate_config['footer_height']; ?>" type="number" min="0" step="1" />
								<span class="input-group-addon">px</span>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_spacing"><?php echo $entry_spacing; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_spacing[0]" value="<?php echo $emailtemplate_config['footer_spacing'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_spacing[1]" value="<?php echo $emailtemplate_config['footer_spacing'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_padding"><?php echo $entry_padding; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_padding[0]" value="<?php echo $emailtemplate_config['footer_padding'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_padding[1]" value="<?php echo $emailtemplate_config['footer_padding'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
							</div>

							<div class="row form-spacing">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_padding[2]" value="<?php echo $emailtemplate_config['footer_padding'][2]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_padding[3]" value="<?php echo $emailtemplate_config['footer_padding'][3]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_bg_color"><?php echo $entry_bg_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['footer_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['footer_bg_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_footer_bg_color" name="emailtemplate_config_footer_bg_color" value="<?php echo $emailtemplate_config['footer_bg_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_section_bg_color"><?php echo $entry_section_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['footer_section_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['footer_section_bg_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_footer_section_bg_color" name="emailtemplate_config_footer_section_bg_color" value="<?php echo $emailtemplate_config['footer_section_bg_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_border_top"><?php echo $entry_border; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_border_top[0]" value="<?php echo $emailtemplate_config['footer_border_top'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="input-group input-colorpicker">
										<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['footer_border_top'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['footer_border_top'][1]; ?>;"<?php } ?>></i></span>
										<input type="text" class="form-control" name="emailtemplate_config_footer_border_top[1]" id="emailtemplate_config_footer_border_top" value="<?php echo $emailtemplate_config['footer_border_top'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
										<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
									</div>

									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw"></i></span>
											<input class="form-control" name="emailtemplate_config_footer_border_left[0]" value="<?php echo $emailtemplate_config['footer_border_left'][0]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['footer_border_left'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['footer_border_left'][1]; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" name="emailtemplate_config_footer_border_left[1]" id="emailtemplate_config_footer_border_left" value="<?php echo $emailtemplate_config['footer_border_left'][1]; ?>" placeholder="<?php echo $text_color; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_border_right[0]" value="<?php echo $emailtemplate_config['footer_border_right'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="input-group input-colorpicker">
										<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['footer_border_right'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['footer_border_right'][1]; ?>;"<?php } ?>></i></span>
										<input type="text" class="form-control" name="emailtemplate_config_footer_border_right[1]" id="emailtemplate_config_footer_border_right" value="<?php echo $emailtemplate_config['footer_border_right'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
										<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
									</div>

									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
											<input class="form-control" name="emailtemplate_config_footer_border_bottom[0]" value="<?php echo $emailtemplate_config['footer_border_bottom'][0]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['footer_border_bottom'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['footer_border_bottom'][1]; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" name="emailtemplate_config_footer_border_bottom[1]" id="emailtemplate_config_footer_border_bottom" value="<?php echo $emailtemplate_config['footer_border_bottom'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_border_radius"><?php echo $entry_border_radius; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw" style="transform: rotate(-45deg);"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_border_radius[0]" value="<?php echo $emailtemplate_config['footer_border_radius'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw" style="transform: rotate(-45deg);"></i></span>
											<input class="form-control" name="emailtemplate_config_footer_border_radius[2]" value="<?php echo $emailtemplate_config['footer_border_radius'][2]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw" style="transform: rotate(-45deg);"></i></span>
										<input class="form-control" name="emailtemplate_config_footer_border_radius[1]" value="<?php echo $emailtemplate_config['footer_border_radius'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw" style="transform: rotate(-45deg);"></i></span>
											<input class="form-control" name="emailtemplate_config_footer_border_radius[3]" value="<?php echo $emailtemplate_config['footer_border_radius'][3]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_font_color"><?php echo $text_text_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['footer_font_color']) { ?> style="background-color:<?php echo $emailtemplate_config['footer_font_color']; ?>;"<?php } ?>></i></span>
								<input type="text" class="form-control" id="emailtemplate_config_footer_font_color" name="emailtemplate_config_footer_font_color" value="<?php echo $emailtemplate_config['footer_font_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_font_size"><?php echo $entry_font_size; ?></label>
						<div class="col-sm-4">
							<div class="input-group">
								<input class="form-control" id="emailtemplate_config_footer_font_size" name="emailtemplate_config_footer_font_size" value="<?php echo $emailtemplate_config['footer_font_size']; ?>" type="number" min="0" step="1" />
								<span class="input-group-addon">px</span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_footer_align"><?php echo $entry_text_align; ?></label>
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-fw fa-align-<?php echo $emailtemplate_config['footer_align']; ?>"></i></span>
								<select name="emailtemplate_config_footer_align" id="emailtemplate_config_footer_align" class="form-control">
									<option value="center"<?php if ($emailtemplate_config['footer_align'] == 'center') { ?> selected="selected"<?php } ?>><?php echo $text_center; ?></option>
									<option value="left"<?php if ($emailtemplate_config['footer_align'] == 'left') { ?> selected="selected"<?php } ?>><?php echo $text_left; ?></option>
									<option value="right"<?php if ($emailtemplate_config['footer_align'] == 'right') { ?> selected="selected"<?php } ?>><?php echo $text_right; ?></option>
								</select>
							</div>
						</div>
					</div>

                  	<div class="form-group">
                   		<label class="col-sm-2 control-label" for="emailtemplate_config_view_browser_text"><?php echo $entry_view_browser_text; ?></label>
                   		<div class="col-sm-10">
							<ul class="nav nav-tabs">
								<?php $i = 1; foreach ($languages as $language) { ?>
								<li<?php if ($i == 1) { ?> class="active"<?php } ?>><a href="#" data-target="#tab-view-browser-text-<?php echo $language['code']; ?>" data-toggle="tab" title="<?php echo $language['name']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></a></li>
								<?php $i++; } ?>
							</ul>
							<div class="tab-content">
								<?php $i = 1; foreach ($languages as $language) { ?>
								<div class="tab-pane<?php if ($i == 1) { ?> active<?php } ?>" id="tab-view-browser-text-<?php echo $language['code']; ?>">
									<textarea class="summernote" name="emailtemplate_config_view_browser_text[<?php echo $language['language_id']; ?>]" id="emailtemplate_config_view_browser_text_<?php echo $language['language_id']; ?>"><?php echo $emailtemplate_config['view_browser_text'][$language['language_id']]; ?></textarea>
								</div>
								<?php $i++; } ?>
							</div>
                   		</div>
                  	</div>

					<div class="form-group">
                   		<label class="col-sm-2 control-label" for="emailtemplate_config_footer_text"><?php echo $entry_footer_text; ?></label>
                   		<div class="col-sm-10">
							<ul class="nav nav-tabs">
								<?php $i = 1; foreach ($languages as $language) { ?>
								<li<?php if ($i == 1) { ?> class="active"<?php } ?>><a href="#" data-target="#tab-footer-text-<?php echo $language['code']; ?>" data-toggle="tab" title="<?php echo $language['name']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" /></a></li>
								<?php $i++; } ?>
							</ul>
							<div class="tab-content">
								<?php $i = 1; foreach ($languages as $language) { ?>
								<div class="tab-pane<?php if ($i == 1) { ?> active<?php } ?>" id="tab-footer-text-<?php echo $language['code']; ?>">
									<textarea class="summernote" name="emailtemplate_config_footer_text[<?php echo $language['language_id']; ?>]" id="emailtemplate_config_footer_text_<?php echo $language['language_id']; ?>"><?php echo $emailtemplate_config['footer_text'][$language['language_id']]; ?></textarea>
								</div>
								<?php $i++; } ?>
							</div>
                   		</div>
                  	</div>
				</div><!-- #tab-footer -->

				<div id="tab-showcase" class="tab-pane fade">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_padding"><?php echo $entry_padding; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_showcase_padding[0]" value="<?php echo $emailtemplate_config['showcase_padding'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_showcase_padding[1]" value="<?php echo $emailtemplate_config['showcase_padding'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
							</div>

							<div class="row form-spacing">
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_showcase_padding[2]" value="<?php echo $emailtemplate_config['showcase_padding'][2]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
								<div class="col-xs-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_showcase_padding[3]" value="<?php echo $emailtemplate_config['showcase_padding'][3]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_bg_color"><?php echo $entry_bg_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['showcase_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['showcase_bg_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_showcase_bg_color" name="emailtemplate_config_showcase_bg_color" value="<?php echo $emailtemplate_config['showcase_bg_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_section_bg_color"><?php echo $entry_section_color; ?></label>
						<div class="col-sm-4">
							<div class="input-group input-colorpicker">
								<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['showcase_section_bg_color']) { ?> style="background-color:<?php echo $emailtemplate_config['showcase_section_bg_color']; ?>;"<?php } ?>></i></span>
								<input class="form-control " type="text" id="emailtemplate_config_showcase_section_bg_color" name="emailtemplate_config_showcase_section_bg_color" value="<?php echo $emailtemplate_config['showcase_section_bg_color']; ?>" />
								<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_border_top"><?php echo $entry_border; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_showcase_border_top[0]" value="<?php echo $emailtemplate_config['showcase_border_top'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="input-group input-colorpicker">
										<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['showcase_border_top'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['showcase_border_top'][1]; ?>;"<?php } ?>></i></span>
										<input type="text" class="form-control" name="emailtemplate_config_showcase_border_top[1]" id="emailtemplate_config_showcase_border_top" value="<?php echo $emailtemplate_config['showcase_border_top'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
										<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
									</div>

									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw"></i></span>
											<input class="form-control" name="emailtemplate_config_showcase_border_left[0]" value="<?php echo $emailtemplate_config['showcase_border_left'][0]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['showcase_border_left'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['showcase_border_left'][1]; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" name="emailtemplate_config_showcase_border_left[1]" id="emailtemplate_config_showcase_border_left" value="<?php echo $emailtemplate_config['showcase_border_left'][1]; ?>" placeholder="<?php echo $text_color; ?>" />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw"></i></span>
										<input class="form-control" name="emailtemplate_config_showcase_border_right[0]" value="<?php echo $emailtemplate_config['showcase_border_right'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="input-group input-colorpicker">
										<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['showcase_border_right'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['showcase_border_right'][1]; ?>;"<?php } ?>></i></span>
										<input type="text" class="form-control" name="emailtemplate_config_showcase_border_right[1]" id="emailtemplate_config_showcase_border_right" value="<?php echo $emailtemplate_config['showcase_border_right'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
										<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
									</div>

									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw"></i></span>
											<input class="form-control" name="emailtemplate_config_showcase_border_bottom[0]" value="<?php echo $emailtemplate_config['showcase_border_bottom'][0]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
										<div class="input-group input-colorpicker">
											<span class="input-group-addon preview"><i<?php if ($emailtemplate_config['showcase_border_bottom'][1]) { ?> style="background-color:<?php echo $emailtemplate_config['showcase_border_bottom'][1]; ?>;"<?php } ?>></i></span>
											<input type="text" class="form-control" name="emailtemplate_config_showcase_border_bottom[1]" id="emailtemplate_config_showcase_border_bottom" value="<?php echo $emailtemplate_config['showcase_border_bottom'][1]; ?>" placeholder="<?php echo $text_color; ?>"  />
											<span class="input-group-addon"><i class="fa fa-fw fa-eyedropper"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_border_radius"><?php echo $entry_border_radius; ?></label>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-up fa-fw" style="transform: rotate(-45deg);"></i></span>
										<input class="form-control" name="emailtemplate_config_showcase_border_radius[0]" value="<?php echo $emailtemplate_config['showcase_border_radius'][0]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-left fa-fw" style="transform: rotate(-45deg);"></i></span>
											<input class="form-control" name="emailtemplate_config_showcase_border_radius[3]" value="<?php echo $emailtemplate_config['showcase_border_radius'][3]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-arrow-right fa-fw" style="transform: rotate(-45deg);"></i></span>
										<input class="form-control" name="emailtemplate_config_showcase_border_radius[1]" value="<?php echo $emailtemplate_config['showcase_border_radius'][1]; ?>" type="number" min="0" step="1" />
										<span class="input-group-addon">px</span>
									</div>
									<div class="form-spacing">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrow-down fa-fw" style="transform: rotate(-45deg);"></i></span>
											<input class="form-control" name="emailtemplate_config_showcase_border_radius[2]" value="<?php echo $emailtemplate_config['showcase_border_radius'][2]; ?>" type="number" min="0" step="1" />
											<span class="input-group-addon">px</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_title"><?php echo $entry_title; ?></label>
						<div class="col-sm-10">
							<?php foreach ($languages as $language) { ?>
							<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>
								<input type="text" name="emailtemplate_config_showcase_title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($emailtemplate_config['showcase_title'][$language['language_id']]) ? $emailtemplate_config['showcase_title'][$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_title; ?>" class="form-control" />
							</div>
							<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase"><?php echo $entry_showcase; ?></label>
						<div class="col-sm-4">
							<select class="form-control" name="emailtemplate_config_showcase" id="emailtemplate_config_showcase">
								<option value=""><?php echo $text_none; ?></option>
								<option value="latest"<?php if ($emailtemplate_config['showcase'] == 'latest') { ?> selected="selected"<?php } ?>><?php echo $text_latest; ?></option>
								<option value="bestsellers"<?php if ($emailtemplate_config['showcase'] == 'bestsellers') { ?> selected="selected"<?php } ?>><?php echo $text_bestsellers; ?></option>
								<option value="popular"<?php if ($emailtemplate_config['showcase'] == 'popular') { ?> selected="selected"<?php } ?>><?php echo $text_popular; ?></option>
								<option value="specials"<?php if ($emailtemplate_config['showcase'] == 'specials') { ?> selected="selected"<?php } ?>><?php echo $text_specials; ?></option>
								<option value="products"<?php if ($emailtemplate_config['showcase'] == 'products') { ?> selected="selected"<?php } ?>><?php echo $text_products; ?></option>
							</select>
							<input type="hidden" name="emailtemplate_config_showcase_selection" value="<?php echo $emailtemplate_config['showcase_selection']; ?>" />
						</div>
					</div>

					<div class="showcase_products form-group<?php if ($emailtemplate_config['showcase'] != 'products') echo ' hide' ?>">
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_selection"><?php echo $entry_selection; ?></label>
						<div class="col-sm-4">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
								<input class="form-control input-autocomplete-product" data-field="input[name=emailtemplate_config_showcase_selection]" data-output="#emailtemplate_config_showcase_selection" type="text" name="" value="" autocomplete="off" placeholder="<?php echo $text_search; ?>" />
							</div>

							<div id="emailtemplate_config_showcase_selection" class="<?php if (empty($showcase_selection)) echo ' hide' ?>">
								<ul class="list-group list-group-small">
								<?php if (isset($showcase_selection)) { ?>
									<?php foreach($showcase_selection as $row) { ?>
										<li class="list-group-item" data-id="<?php echo $row['product_id']; ?>"><a href="javascript:void(0)" class="badge remove list-group-item-danger"><i class="fa fa-times"></i></a> <?php echo $row['name']; ?></li>
									<?php } ?>
								<?php } ?>
								</ul>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_limit"><?php echo $entry_limit; ?></label>
						<div class="col-sm-4">
							<input class="form-control" id="emailtemplate_config_showcase_limit" name="emailtemplate_config_showcase_limit" value="<?php echo $emailtemplate_config['showcase_limit']; ?>" type="number" min="0" step="1" />
						</div>
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_per_row"><?php echo $entry_per_row; ?></label>
						<div class="col-sm-4">
							<input class="form-control" id="emailtemplate_config_showcase_per_row" name="emailtemplate_config_showcase_per_row" value="<?php echo $emailtemplate_config['showcase_per_row']; ?>" type="number" min="0" step="1" />
						</div>
					</div>

					<div class="form-group form-group-radio">
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_cycle"><?php echo $entry_showcase_cycle; ?></label>
						<div class="col-sm-4">
							<input name="emailtemplate_config_showcase_cycle" id="emailtemplate_config_showcase_cycle" class="input-control-checkbox" data-off-label="<?php echo $text_no; ?>" data-on-label="<?php echo $text_yes; ?>" value="1" type="checkbox"<?php echo ($emailtemplate_config['showcase_cycle'] == 1) ? ' checked="checked"' : ''; ?>/>
						</div>
					</div>

					<div class="form-group form-group-radio">
						<label class="col-sm-2 control-label" for="emailtemplate_config_showcase_related"><?php echo $entry_showcase_related; ?></label>
						<div class="col-sm-4">
							<input name="emailtemplate_config_showcase_related" id="emailtemplate_config_showcase_related" class="input-control-checkbox" data-off-label="<?php echo $text_no; ?>" data-on-label="<?php echo $text_yes; ?>" value="1" type="checkbox"<?php echo ($emailtemplate_config['showcase_related'] == 1) ? ' checked="checked"' : ''; ?>/>
						</div>
					</div>
				</div><!-- #tab-showcase -->
			</div>
		</div>

		<div id="preview-mail" class="panel panel-inbox">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-eye"></i> <?php echo $heading_preview; ?></h3>

				<div class="panel-heading-action">
					<span class="well">
						<i data-width="100%" class="media-icon fa fa-desktop selected" data-toggle="tooltip" title="<?php echo $text_desktop; ?>"></i>
						<i data-width="768px" class="media-icon fa fa-tablet" data-toggle="tooltip" title="<?php echo $text_tablet; ?>"></i>
						<i data-width="320px" class="media-icon fa fa-mobile" data-toggle="tooltip" title="<?php echo $text_mobile; ?>"></i>
						<span class="divider"></span>
						<i class="preview-image fa fa-toggle-on selected" data-toggle="tooltip" title="<?php echo $button_withimages; ?>"></i>
						<i class="preview-image preview-no-image fa fa-toggle-off hide selected" data-toggle="tooltip" title="<?php echo $button_withoutimages; ?>"></i>
					</span>
					<i class="fa fa-refresh template-update" data-toggle="tooltip" title="<?php echo $button_update_preview; ?>"></i>
					<span class="divider"></span>
					<i class="fa fa-envelope send-test-email" data-toggle="tooltip" title="<?php echo $button_test; ?>"></i>
				</div>
			</div>

			<div class="panel-body">
				<div id="preview-with" class="preview-frame ajax-loading"><i class="fa fa-spinner fa-spin fa-5x" style="color:#009afd"></i></div>
    			<div id="preview-without" class="preview-frame" style="display:none"></div>
			</div>
		</div>
	</form>
</div>
</div>

<?php echo $footer; ?>