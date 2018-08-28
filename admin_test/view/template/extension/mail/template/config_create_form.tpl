<?php echo $header; ?>

<?php echo $column_left; ?>

<div id="content">
	<div id="emailtemplate">
		<div class="page-header">
			<div class="container-fluid">
				<div class="pull-right">
					<button id="submit_form_button" type="submit" form="form-emailtemplate" data-toggle="tooltip" title="<?php echo $button_create; ?>" class="btn btn-success"><i class="fa fa-save"></i></button>

					<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
				</div>

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
			<?php if (!empty($error_warning)) { ?>
			<div class="alert alert-danger">
				<i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
			<?php } ?>

			<?php if (!empty($error_attention)) { ?>
			<div class="alert alert-warning">
				<i class="fa fa-exclamation-circle"></i> <?php echo $error_attention; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
			<?php } ?>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-envelope"></i> <?php echo $heading_config_create; ?></h3>
				</div>

				<div class="panel-body">
					<?php if (!empty($emailtemplate_configs)) { ?>
					<div class="form-group required">
						<label class="col-sm-2 control-label" for="emailtemplate_config_id"><?php echo $entry_config; ?></label>
						<div class="col-sm-10">
							<select class="form-control" name="id" id="emailtemplate_config_id">
								<?php foreach($emailtemplate_configs as $row): ?>
								<option value="<?php echo $row['emailtemplate_config_id']; ?>"<?php echo ($emailtemplate_config['emailtemplate_config_id'] == $row['emailtemplate_config_id']) ? 'selected="selected"' : ''; ?>><?php echo $row['emailtemplate_config_name']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<?php } ?>

					<div class="form-group required">
						<label class="col-sm-2 control-label" for="emailtemplate_config_name"><?php echo $entry_label; ?></label>
						<div class="col-sm-10">
							<input class="form-control" id="emailtemplate_config_name" name="emailtemplate_config_name" value="<?php echo $emailtemplate_config['name']; ?>" required="required" type="text" />
							<?php if (isset($error_emailtemplate_config_name)) { ?><span class="text-danger"><?php echo $error_emailtemplate_config_name; ?></span><?php } ?>
						</div>
					</div>

					<fieldset class="form-section">
						<div class="row"><div class="col-sm-push-2 col-sm-10">
							<h3 class="heading"><?php echo $heading_condition; ?></h3>
							<p><?php echo $text_help_config_create; ?></p>
						</div></div>

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
					</fieldset>
				</div>
			</div>
		</form>
	</div>
</div>

<?php echo $footer; ?>