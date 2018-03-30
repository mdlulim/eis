<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
<div id="emailtemplate">
	<div class="page-header">
		<div class="container-fluid">
			<h1><?php echo $heading_title; ?> <small style="vertical-align:middle"><?php echo $version; ?></small></h1>

			<div class="pull-right">
				<a href="<?php echo $action_insert_template; ?>" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $text_create_template; ?>"><i class="fa fa-plus"></i><span class="hidden-xs hidden-sm"> <?php //echo $text_create_template; ?></span></a>

				<a href="<?php echo $config_url; ?>" class="btn btn-info" data-toggle="tooltip" title="<?php echo $heading_config; ?>"><i class="fa fa-cogs"></i><span class="hidden-xs hidden-sm"> <?php echo $heading_config; ?></span></a>

				<?php if ($templates_restore) { ?>
				<div class="btn-group">
					<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo $button_restore; ?> <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" role="menu">
						<?php foreach($templates_restore as $row) { ?>
				    	<li><a href="<?php echo $row['url']; ?>"><?php echo $row['name']; ?></a></li>
				    	<?php } ?>
				  	</ul>
				</div>
				<?php } ?>

				<div class="btn-group" data-toggle="tooltip" title="<?php echo $button_tools; ?>">
				  <button type="button" data-toggle="dropdown" class="btn btn-warning dropdown-toggle"><i class="fa fa-wrench"></i><span class="hidden-xs hidden-sm"> <?php echo $button_tools; ?></span></button>
				  <ul class="dropdown-menu dropdown-menu-right" role="menu">
					<li><a href="<?php echo $logs_url; ?>" class="text-right"><?php echo $button_logs; ?> <i class="fa fa-fw fa-inbox"></i></a></li>
					<li><a href="<?php echo $send_url; ?>" data-confirm="<?php echo $text_confirm; ?>" class="text-right"><?php echo $button_test; ?> <i class="fa fa-fw fa-envelope-o"></i></a></li>
					<li><a href="<?php echo $modification_url; ?>" class="text-right"><?php echo $button_modification; ?> <i class="fa fa-fw fa-code"></i></a></li>
					<li><a href="<?php echo $clear_cache_url; ?>" class="text-right"><?php echo $button_clear_cache; ?> <i class="fa fa-fw fa-trash"></i></a></li>
				  </ul>
				</div>

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

	<form action="<?php echo $action; ?>" method="post" id="form-emailtemplate" class="container-fluid" data-version="<?php echo $version; ?>">
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

	    <?php if (!empty($success)) { ?>
	    	<div class="alert alert-success">
				<i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
	      		<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
	    <?php } ?>

	    <div class="filter-templates form-inline">
	    	<div class="form-group">
	    		<div class="radio">
	    			<label<?php if($emailtemplate_type == '') echo ' class="active"'; ?>>
	    				<input type="radio" name="filter_type" value=""<?php if($emailtemplate_type == '') echo ' checked="checked"'; ?> autocomplete="off" />
						<span class="filter-label"><?php echo $text_all; ?></span>
	    			</label>
	    			<?php if(in_array('order', $emailtemplate_types) && count($emailtemplate_types) > 1) { ?>
						<label<?php if($emailtemplate_type == 'order') echo ' class="active"'; ?>>
							<input type="radio" name="filter_type" value="order"<?php if($emailtemplate_type == 'order') echo ' checked="checked"'; ?>  autocomplete="off" />
							<span class="filter-label"><?php echo $text_order; ?></span>
						</label>
					<?php } ?>
	    			<?php if(in_array('customer', $emailtemplate_types) && count($emailtemplate_types) > 1) { ?>
						<label<?php if($emailtemplate_type == 'customer') echo ' class="active"'; ?>>
							<input type="radio" name="filter_type" value="customer"<?php if($emailtemplate_type == 'customer') echo ' checked="checked"'; ?> autocomplete="off" />
							<span class="filter-label"><?php echo $text_customer; ?></span>
						</label>
					<?php } ?>
	    			<?php if(in_array('affiliate', $emailtemplate_types) && count($emailtemplate_types) > 1) { ?>
						<label<?php if($emailtemplate_type == 'affiliate') echo ' class="active"'; ?>>
							<input type="radio" name="filter_type" value="affiliate"<?php if($emailtemplate_type == 'affiliate') echo ' checked="checked"'; ?>  autocomplete="off" />
							<span class="filter-label"><?php echo $text_affiliate; ?></span>
						</label>
					<?php } ?>
	    			<?php if(in_array('admin', $emailtemplate_types) && count($emailtemplate_types) > 1) { ?>
						<label<?php if($emailtemplate_type == 'admin') echo ' class="active"'; ?>>
							<input type="radio" name="filter_type" value="admin"<?php if($emailtemplate_type == 'admin') echo ' checked="checked"'; ?>  autocomplete="off" />
							<span class="filter-label"><?php echo $text_admin; ?></span>
						</label>
					<?php } ?>
	    		</div>
	    	</div>

	    </div>

	    <div class="ajax-filter">
	    	<div class="table-responsive">
				<table class="table table-bordered table-striped table-row-check" id="template_list">
					<thead>
						<tr>
							<th width="45" class="text-center"><input type="checkbox" data-checkall="input[name^='selected']" /></th>
							<th><a href="<?php echo $sort_label; ?>" class="<?php if ($sort == 'label') echo strtolower($order); ?>"><?php echo $column_label; ?></a></th>
							<th class="hidden-xs hidden-sm"><a href="<?php echo $sort_key; ?>" class="<?php if ($sort == 'key') echo strtolower($order); ?>"><?php echo $column_key; ?></a></th>
							<th class="text-center"><a href="<?php echo $sort_config; ?>" class="<?php if ($sort == 'config') echo strtolower($order); ?>"><?php echo $column_config; ?></a></th>
							<th class="text-center hidden-xs"><a href="<?php echo $sort_modified; ?>" class="<?php if ($sort == 'modified') echo strtolower($order); ?>"><?php echo $column_modified; ?></a></th>
		              		<th class="text-center" width="70"><a href="<?php echo $sort_shortcodes; ?>" class="<?php if ($sort == 'shortcodes') echo strtolower($order); ?>"><?php echo $column_shortcodes; ?></a></th>
		              		<th class="text-center" width="90"><a href="<?php echo $sort_status; ?>" class="<?php if ($sort == 'status') echo strtolower($order); ?>"><?php echo $column_status; ?></a></th>
							<th class="text-center" width="60">&nbsp;</th>
			           	</tr>
		        	</thead>
			       	<tbody>
			            <?php foreach ($templates as $row) { ?>
		            	<tr>
		              		<td class="text-center"><?php if ($row['id'] != 1) { ?><input type="checkbox" name="selected[]" value="<?php echo $row['id']; ?>"<?php if ($row['selected']) { ?> checked="checked"<?php } ?> /><?php } else { ?>&nbsp;<?php } ?></td>
		              		<td><a href="<?php echo $row['action']; ?>" style="color:inherit"><?php echo $row['label'] . ($row['custom_count'] ? ' (' . $row['custom_count'] . ')': ''); ?><b class="visible-xs visible-sm hide"> <?php echo $row['key']; ?></b></a></td>
		              		<td class="hidden-xs hidden-sm"><b><?php echo $row['key']; ?></b></td>
		              		<td class="text-center"><?php if(isset($row['config'])){ ?><a href="<?php echo $row['config_url']; ?>" style="text-decoration:none; color:inherit"><?php echo $row['config']; ?></a><?php } ?></td>
		              		<td class="text-center hidden-xs"><?php echo $row['modified']; ?></td>
		              		<td class="text-center"><i class="fa fa-<?php echo ($row['shortcodes']) ? 'thumbs-up text-success' : 'thumbs-down text-warning' ?> fa-2x"></i></td>
		              		<td class="text-center"><i class="fa fa-<?php echo ($row['status']) ? 'check-circle text-success' : 'times-circle text-warning' ?> fa-2x"></i></td>
	                          <td class="text-center">
	                            <?php if ($row['action']) { ?>
	                              <div class="btn-group">
	                                <?php if ($row['custom_templates']) { ?>
	                                <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
	                                    <i class="fa fa-pencil"></i>
	                                    <span class="sr-only">Toggle Dropdown</span>
	                                  </button>
	                                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
	                                    <li><a href="<?php echo $row['action']; ?>"><?php echo $button_default; ?></a></li>
	                                    <li role="presentation" class="divider"></li>
	                                    <?php foreach($row['custom_templates'] as $row_custom) { ?>
	                                    <li><a href="<?php echo $row_custom['action']; ?>"><?php echo $row_custom['emailtemplate_label']; ?></a></li>
	                                    <?php } ?>
	                                  </ul>
	                                  <?php } else { ?>
	                                  <a href="<?php echo $row['action']; ?>" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>
	                                  <?php } ?>
	                              </div>
	                            <?php } ?>
	                          </td>
			            </tr>
			            <?php } ?>
					</tbody>
					<tfoot>
						<tr>
		              		<td class="text-center"><button class="btn btn-sm btn-danger" data-confirm="<?php echo $text_confirm; ?>" data-action="<?php echo $action; ?>&action=delete" data-toggle="tooltip" title="<?php echo $button_delete; ?>"><i class="fa fa-trash"></i></button></td>
		              		<td>&nbsp;</td>
		              		<td class="hidden-xs">&nbsp;</td>
		              		<td>&nbsp;</td>
		              		<td class="hidden-xs">&nbsp;</td>
		              		<td class="text-center"><div class="btn-group">
								<button class="btn btn-sm btn-warning" data-action="<?php echo $action; ?>&action=delete_shortcode" data-toggle="tooltip" title="<?php echo $button_clear; ?>"><i class="fa fa-thumbs-down"></i></button>
							</div></td>
		              		<td class="text-center"><div class="btn-group">
								<button class="btn btn-sm btn-success" data-action="<?php echo $action; ?>&action=enable" data-toggle="tooltip" title="<?php echo $button_enable; ?>"><i class="fa fa-check-circle"></i></button>
								<button class="btn btn-sm btn-warning" data-action="<?php echo $action; ?>&action=disable" data-toggle="tooltip" title="<?php echo $button_disable; ?>"><i class="fa fa-times-circle"></i></button>
							</div></td>
							<td class="text-center"></td>
						</tr>
					</tfoot>
				</table>
			</div>

			<div class="row row-spacing">
				<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
				<div class="col-sm-6 text-right"><?php echo $pagination_results; ?></div>
			</div>
		</div>

		<div class="support-text">
			<h3>Extension Support - <a href="<?php echo $support_url; ?>">Open support ticket</a></h3>

			<p>This Extension is brought to you by: <a href="http://www.opencart-templates.co.uk" target="_blank">Opencart-templates</a></p>
		</div>
	</form>
</div>
</div>
<?php echo $footer; ?>