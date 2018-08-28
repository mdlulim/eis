<?php echo $header; ?>
<?php echo $column_left; ?>

<div id="content">
<div id="emailtemplate">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>

			<h1><?php echo $heading_logs; ?></h1>

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

	<form action="<?php echo $action; ?>" method="post" id="form-emailtemplate" class="container-fluid">
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

	    <div class="well" id="form-filter">
			<div class="row">
            	<div class="col-sm-6 col-md-3">
              		<div class="form-group">
                		<label for="filter_emailtemplate_id" class="control-label"><?php echo $text_template; ?></label>
                		<select name="filter_emailtemplate_id" id="filter_emailtemplate_id" class="form-control form-filter">
							<option value=""><?php echo $text_select; ?></option>
							<?php foreach($emailtemplates as $row) { ?>
							<option value="<?php echo $row['emailtemplate_id']; ?>"<?php if ($filter_emailtemplate_id == $row['emailtemplate_id']) echo ' selected="selected"'; ?>><?php echo ($row['label']) ? $row['label'] : $row['key']; ?></option>
							<?php } ?>
						</select>
              		</div>
              	</div>
            	<div class="col-sm-6 col-md-3">
              		<div class="form-group">
                		<label for="filter_emailtemplate_config_id" class="control-label"><?php echo $entry_config; ?></label>
                		<select name="filter_emailtemplate_config_id" id="filter_emailtemplate_config_id" class="form-control form-filter">
							<option value=""><?php echo $text_select; ?></option>
							<?php foreach($emailtemplate_configs as $row) { ?>
							<option value="<?php echo $row['emailtemplate_config_id']; ?>"<?php if ($filter_emailtemplate_config_id == $row['emailtemplate_config_id']) echo ' selected="selected"'; ?>><?php echo $row['emailtemplate_config_name']; ?></option>
							<?php } ?>
						</select>
              		</div>
              	</div>
            	<div class="col-sm-6 col-md-3">
              		<div class="form-group">
                		<label for="filter_store_id" class="control-label"><?php echo $entry_store; ?></label>
                		<select name="filter_store_id" id="filter_store_id" class="form-control form-filter">
							<option value=""><?php echo $text_select; ?></option>
							<?php foreach($stores as $store) { ?>
							<option value="<?php echo $store['store_id']; ?>"<?php if ($filter_store_id == $store['store_id'] && is_numeric($filter_store_id)) echo ' selected="selected"'; ?>><?php echo $store['name']; ?></option>
							<?php } ?>
						</select>
              		</div>
              	</div>
            	<div class="col-sm-6 col-md-3">
              		<div class="form-group">
                		<label for="filter_customer_id" class="control-label"><?php echo $text_customer; ?></label>
                		<input type="hidden" name="filter_customer_id" id="filter_customer_id" class="form-filter" value="<?php echo $filter_customer_id; ?>" />
                		<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-search"></i></span>
							<input class="form-control input-autocomplete-customer" data-field="input[name=filter_customer_id]" type="text" name="" value="<?php echo $filter_customer; ?>" autocomplete="off" placeholder="<?php echo $text_search; ?>" />
						</div>
              		</div>
              	</div>
			</div>
        </div>

	    <div class="table-responsive">
			<table class="table table-bordered table-row-check" id="template_list">
				<thead>
					<tr>
						<th width="45" class="text-center"><input type="checkbox" data-checkall="input[name^='selected']" /></th>
	              		<th><a href="<?php echo $sort_subject; ?>" class="<?php if ($sort == 'subject') echo strtolower($order); ?>"><?php echo $column_subject; ?></a></th>
	              		<th class="hidden-xs"><a href="<?php echo $sort_to; ?>" class="<?php if ($sort == 'to') echo strtolower($order); ?>"><?php echo $column_to; ?></a></th>
	              		<th class="hidden-xs"><a href="<?php echo $sort_from; ?>" class="<?php if ($sort == 'from') echo strtolower($order); ?>"><?php echo $column_from; ?></a></th>
	              		<th class="text-center"><a href="<?php echo $sort_sent; ?>" class="<?php if ($sort == 'sent') echo strtolower($order); ?>"><?php echo $column_sent; ?></a></th>
	              		<th class="text-center"><a href="<?php echo $sort_read; ?>" class="<?php if ($sort == 'read') echo strtolower($order); ?>"><?php echo $column_read; ?></a></th>
	                	<th>&nbsp;</th>
		           	</tr>
	        	</thead>
		       	<tbody>
		       		<?php if ($logs) { ?>
		            <?php foreach ($logs as $row) { ?>
		            	<tr data-id="<?php echo $row['emailtemplate_log_id']; ?>">
			            	<td class="text-center"><input type="checkbox" name="selected[]" value="<?php echo $row['emailtemplate_log_id']; ?>" /></td>
			              	<td>
			              		<b><?php echo $row['emailtemplate_log_preview']; ?></b>
			              		<div class="hide visible-xs">
			              			<i><?php echo $column_to; ?>:</i>
			              			<?php if (!empty($row['customer']['url_edit'])) { ?>
					              		<a href="<?php echo $row['customer']['url_edit']; ?>"><?php echo $row['customer']['firstname'] . ' ' . $row['customer']['lastname']; ?></a> &lt;<a href="mailto:<?php echo $row['emailtemplate_log_to']; ?>?subject=<?php echo $row['emailtemplate_log_subject']; ?>"><?php echo $row['emailtemplate_log_to']; ?></a>&gt;
				              		<?php } else { ?>
				              			<a href="mailto:<?php echo $row['emailtemplate_log_to']; ?>?subject=<?php echo $row['emailtemplate_log_subject']; ?>"><?php echo $row['emailtemplate_log_to']; ?></a>
				              		<?php } ?>
				              		<br /><i><?php echo $column_from; ?>:</i>
				              		<?php if ($row['emailtemplate_log_sender']) { ?>
					              		<?php echo $row['emailtemplate_log_sender']; ?> &lt;<a href="mailto:<?php echo $row['emailtemplate_log_from']; ?>?subject=<?php echo $row['emailtemplate_log_subject']; ?>"><?php echo $row['emailtemplate_log_from']; ?></a>&gt;
				              		<?php } else { ?>
				              			<a href="mailto:<?php echo $row['emailtemplate_log_from']; ?>?subject=<?php echo $row['emailtemplate_log_subject']; ?>"><?php echo $row['emailtemplate_log_from']; ?></a>
				              		<?php } ?>
			              		</div>
			              	</td>
			              	<td class="hidden-xs">
			              		<?php if (!empty($row['customer']['url_edit'])) { ?>
				              		<a href="<?php echo $row['customer']['url_edit']; ?>"><?php echo $row['customer']['firstname'] . ' ' . $row['customer']['lastname']; ?></a> &lt;<a href="mailto:<?php echo $row['emailtemplate_log_to']; ?>?subject=<?php echo $row['emailtemplate_log_subject']; ?>"><?php echo $row['emailtemplate_log_to']; ?></a>&gt;
			              		<?php } else { ?>
			              			<a href="mailto:<?php echo $row['emailtemplate_log_to']; ?>?subject=<?php echo $row['emailtemplate_log_subject']; ?>"><?php echo $row['emailtemplate_log_to']; ?></a>
			              		<?php } ?>
			              	</td>
			              	<td class="hidden-xs">
			              		<?php if ($row['emailtemplate_log_sender']) { ?>
				              		<?php echo $row['emailtemplate_log_sender']; ?> &lt;<a href="mailto:<?php echo $row['emailtemplate_log_from']; ?>?subject=<?php echo $row['emailtemplate_log_subject']; ?>"><?php echo $row['emailtemplate_log_from']; ?></a>&gt;
			              		<?php } else { ?>
			              			<a href="mailto:<?php echo $row['emailtemplate_log_from']; ?>?subject=<?php echo $row['emailtemplate_log_subject']; ?>"><?php echo $row['emailtemplate_log_from']; ?></a>
			              		<?php } ?>
		              		</td>
			              	<td class="text-left"><i><?php echo $row['emailtemplate_log_sent']; ?></i></td>
			              	<td class="text-left"><i><?php echo $row['emailtemplate_log_read']; ?></i></td>
                            <td class="text-right">
                              <?php if (!empty($row['emailtemplate'])) { ?>
                                <a href="<?php echo $row['emailtemplate']['url_edit']; ?>" data-toggle="tooltip" title="<?php echo $row['emailtemplate']['label']; ?> (<?php echo $row['emailtemplate']['key']; ?>)" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></a>
                              <?php } ?>
                              <?php if (!empty($row['resend'])) { ?>
                                <a href="<?php echo $row['resend']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" title="<?php echo $text_resend; ?>"><i class="fa fa-envelope"></i></a>
                              <?php } ?>
                              <a href="javascript:void(0)" class="btn btn-info btn-sm load-email"><i class="fa fa-eye"></i></a>
                            </td>
			            </tr>
		           	<?php } ?>
		            <?php } else { ?>
		            	<tr>
		              		<td class="text-center" colspan="6">
		              			<p><?php echo $text_no_results; ?></p>
	              			</td>
	            		</tr>
		            <?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td class="text-center"><button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="<?php echo $button_delete; ?>" data-confirm="<?php echo $text_confirm; ?>"><i class="fa fa-trash"></i></button></td>
						<td colspan="5"></td>
					</tr>
				</tfoot>
			</table>
		</div>

		<div class="row row-spacing">
			<div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
			<div class="col-sm-6 text-right"><?php echo $pagination_results; ?></div>
		</div>

		<div id="emailBox" class="panel panel-inbox hide">
			<div class="panel-heading">
				<div class="row">
					<div class="col-sm-6">
						<ul class="panel-inbox-properties">
							<li>
								<label><?php echo $text_from; ?></label>
								<span data-field="emailtemplate_log_sender"></span>
								<i>&lt;</i><a data-field="emailtemplate_log_from" data-type="mailto"></a><i>&gt;</i>
							</li>
							<li>
								<label><?php echo $text_subject; ?></label>
								<b data-field="emailtemplate_log_subject"></b>
							</li>
							<li>
								<label><?php echo $text_to; ?></label>
								<i>&lt;</i><a data-field="emailtemplate_log_to" data-type="mailto"></a><i>&gt;</i>
							</li>
						</ul>
					</div>
					<div class="col-sm-6">
						<div class="panel-inbox-buttons">
							<a href="javascript:void(0)" class="btn btn-sm btn-info" data-button="plaintext"><i class="fa fa-font"></i> <?php echo $button_plain_text; ?></a>
							<a href="javascript:void(0)" class="btn btn-sm btn-info" data-button="html" style="display:none"><i class="fa fa-code"></i> <?php echo $button_html; ?></a>
							<a href="javascript:void(0)" class="btn btn-sm btn-primary" data-button="reply"><i class="fa fa-reply"></i> <?php echo $button_reply; ?></a>
						</div>

						<div class="panel-inbox-meta">
							<p><span data-field="emailtemplate_log_sent"></span></p>
							<p class="hide"><b><?php echo $text_read; ?></b> <span data-field="emailtemplate_log_read"></span></p>
							<p class="hide"><b><?php echo $text_read_last; ?></b> <span data-field="emailtemplate_log_read_last"></span></p>
						</div>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div id="emailBoxText"></div>
				<iframe src="javascript:false;" id="emailBoxFrame" style="width:100%; height:500px; border:none; margin:0 auto; float:none; display:block"></iframe>
			</div>
		</div>
	</form>
</div>
</div>

<?php echo $footer; ?>