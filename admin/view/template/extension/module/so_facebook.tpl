<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save'); ?>" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo $objlang->get('entry_button_save')?></button>
				<a class="btn btn-success" onclick="$('#action').val('save_edit');$('#form-featured').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_edit'); ?>" ><i class="fa fa-pencil-square-o"></i> <?php echo $objlang->get('entry_button_save_and_edit')?></a>
				<a class="btn btn-info" onclick="$('#action').val('save_new');$('#form-featured').submit();" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_save_and_new'); ?>" ><i class="fa fa-book"></i>  <?php echo $objlang->get('entry_button_save_and_new')?></a>
				<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $objlang->get('entry_button_cancel'); ?>" class="btn btn-danger"><i class="fa fa-reply"></i>  <?php echo $objlang->get('entry_button_cancel')?></a>
			</div>
			<h1><?php echo $objlang->get('heading_title_so'); ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if (isset($error['warning'])) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['warning']; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_layout; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $subheading; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
					<div class="row">
						<ul class="nav nav-tabs" role="tablist">
							<li <?php if( $selectedid ==0 ) { ?>class="active" <?php } ?>> <a href="<?php echo $link; ?>"> <span class="fa fa-plus"></span> <?php echo $objlang->get('button_add_module');?></a></li>
							<?php $i=1; foreach( $moduletabs as $key => $module ){ ?>
							<li role="presentation" <?php if( $module['module_id']==$selectedid ) { ?>class="active"<?php } ?>>
							<a href="<?php echo $link; ?>&module_id=<?php echo $module['module_id']?>" aria-controls="bannermodule-<?php echo $key; ?>"  >
								<span class="fa fa-pencil"></span> <?php echo $module['name']?>
							</a>
							</li>
							
							<?php $i++ ;} ?>
						</ul>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<?php $module_row = 1; ?>
						<?php foreach ($modules as $module) { ?>
							<?php if( $selectedid ){ ?>
							<div class="pull-right">
								<a href="<?php echo $action;?>&delete=1" class="remove btn btn-danger" ><span><i class="fa fa-remove"></i> <?php echo $objlang->get('entry_button_delete');?></span></a>
							</div>
							<?php } ?>
							<div  id="tab-module<?php echo $module_row; ?>" class="col-sm-12">
								<div class="form-group"> <?php //<!-- Module Name--> ?> 
									<input type="hidden" name="action" id="action" value=""/>
									<label class="col-sm-3 control-label" for="input-name"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_name_desc'); ?>"><?php echo $objlang->get('entry_name'); ?> </span></label>
									<div class="col-sm-9">
										<div class="col-sm-5">
											<input type="text" name="name" value="<?php echo $module['name']; ?>" placeholder="<?php echo $objlang->get('entry_name'); ?>" id="input-name" class="form-control" />
										</div>
										<?php if (isset($error['name'])) { ?>
										<div class="text-danger col-sm-12"><?php echo $error['name']; ?></div>
										<?php }?>
									</div>
								</div>
								<div class="form-group"> <?php //<!-- Header title--> ?>
									<label class="col-sm-3 control-label" for="input-head_name"><b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_head_name_desc'); ?>"><?php echo $objlang->get('entry_head_name'); ?> </span></label>
									<div class="col-sm-9">
										<div class="col-sm-5">
											<?php
													$i = 0;
													foreach ($languages as $language) { $i++; ?>
											<input type="text" name="module_description[<?php echo $language['language_id']; ?>][head_name]" placeholder="<?php echo $objlang->get('entry_head_name'); ?>" id="input-head-name-<?php echo $language['language_id']; ?>" value="<?php echo isset($module_description[$language['language_id']]['head_name']) ? $module_description[$language['language_id']]['head_name'] : ''; ?>" class="form-control <?php echo ($i>1) ? ' hide ' : ' first-name'; ?>" />
											<?php
														 if($i == 1){ ?>
											<input type="hidden" class="form-control" id="input-head_name" placeholder="<?php echo $objlang->get('entry_head_name'); ?>" value="<?php echo isset($module_description[$language['language_id']]['head_name']) ? $module_description[$language['language_id']]['head_name'] : ''; ?>" name="head_name">
											<?php }
														 ?>
											<?php } ?>
										</div>
										<div class="col-sm-3">
											<select  class="form-control" id="language">
												<?php foreach ($languages as $language) { ?>
												<option value="<?php echo $language['language_id']; ?>">
													<?php echo $language['name']; ?>
												</option>
												<?php } ?>
											</select>
										</div>
										<?php if (isset($error['head_name'])) { ?>
										<div class="text-danger col-sm-12"><?php echo $error['head_name']; ?></div>
										<?php }?>
									</div>
								</div>
								<div class="form-group"> <?php //<!--Display header title --> ?>
									<label class="col-sm-3 control-label" for="input-disp_title_module"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_display_title_module_desc'); ?>"><?php echo $objlang->get('entry_display_title_module'); ?> </span></label>
									<div class="col-sm-9">
										<div class="col-sm-5">
											<select name="disp_title_module" id="input-disp_title_module" class="form-control">
												<?php
													if ($module['disp_title_module']) { ?>
												<option value="1" selected="selected"><?php echo $objlang->get('text_yes'); ?></option>
												<option value="0"><?php echo $objlang->get('text_no'); ?></option>
												<?php } else { ?>
												<option value="1"><?php echo $objlang->get('text_yes'); ?></option>
												<option value="0" selected="selected"><?php echo $objlang->get('text_no'); ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group"> <?php //<!--Status --> ?>
									<label class="col-sm-3 control-label" for="input-status"><span data-toggle="tooltip" title="<?php echo $objlang->get('entry_status_desc'); ?>"><?php echo $objlang->get('entry_status'); ?> </span></label>
									<div class="col-sm-9">
										<div class="col-sm-5">
											<select name="status" id="input-status" class="form-control">
												<?php if ($module['status']) { ?>
												<option value="1" selected="selected"><?php echo $objlang->get('text_enabled'); ?></option>
												<option value="0"><?php echo $objlang->get('text_disabled'); ?></option>
												<?php } else { ?>
												<option value="1"><?php echo $objlang->get('text_enabled'); ?></option>
												<option value="0" selected="selected"><?php echo $objlang->get('text_disabled'); ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane">
								<ul class="nav nav-tabs" id="opencart-tabs">
									<li>
										<a href="#like_book_option" data-toggle="tab">
											<?php echo $objlang->get('entry_like_book_option') ?>
										</a>
									</li>
									<li>
										<a href="#advanced_option" data-toggle="tab">
											<?php echo $objlang->get('entry_advanced_option') ?>
										</a>
									</li>
								</ul>
								<div class="tab-content">
								<?php //----------------------------------------------------------------------- ?>
									<div class="tab-pane" id="like_book_option"> <?php //<!--Like book Option --> ?> 
										<div class="form-group"> <?php //<!--Class suffix --> ?>
											<label class="col-sm-3 control-label" for="input-class_suffix"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_class_suffix_desc'); ?>"><?php echo $objlang->get('entry_class_suffix'); ?> </span> </label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<input type="text" name="class_suffix" value="<?php echo $module['class_suffix']; ?>" id="input-class_suffix" class="form-control" />
												</div>
											</div>
										</div>
										<div class="form-group"> <?php //<!--pageid --> ?>
											<label class="col-sm-3 control-label" for="input-pageid"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_pageid_desc'); ?>"><?php echo $objlang->get('entry_pageid'); ?> </span> </label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<input type="text" name="pageid" value="<?php echo $module['pageid']; ?>" id="input-pageid" class="form-control" />
												</div>
												<div style="margin-top: 8px"><span style="color: red">Ex: 121579357898967</span> / Or Link: <span style="color: #003bb3">https://www.facebook.com/SmartAddons.page/</span></div>
											</div>
										</div>
										<div class="form-group"> <?php //<!--height--> ?>
											<label class="col-sm-3 control-label" for="input-height"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_height_desc'); ?>"><?php echo $objlang->get('entry_height'); ?></span></label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<input type="text" name="height" value="<?php echo $module['height']; ?>" id="input-height" class="form-control" />
												</div>
												<?php if (isset($error['height'])) { ?>
												<div class="text-danger col-sm-12"><?php echo $error['height']; ?></div>
												<?php }?>
											</div>
										</div>
										<div class="form-group"> <?php //<!--width --> ?>
											<label class="col-sm-3 control-label" for="input-width"> <b style="font-weight:bold; color:#f00">*</b> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_width_desc'); ?>"><?php echo $objlang->get('entry_width'); ?></span></label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<input type="text" name="width" value="<?php echo $module['width']; ?>" id="input-width" class="form-control" />
												</div>
												<?php if (isset($error['width'])) { ?>
												<div class="text-danger col-sm-12"><?php echo $error['width']; ?></div>
												<?php }?>
											</div>
										</div>
										<div class="form-group"> <?php //<!--stream --> ?>
											<label class="col-sm-3 control-label" for="input-stream">
												<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_stream_desc'); ?>"><?php echo $objlang->get('entry_stream'); ?></span>
											</label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<label class="radio-inline">
														<?php if ($module['stream']) { ?>
														<input type="radio" name="stream" value="1" checked="checked" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } else { ?>
														<input type="radio" name="stream" value="1" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } ?>
													</label>
													<label class="radio-inline">
														<?php if (!$module['stream']) { ?>
														<input type="radio" name="stream" value="0" checked="checked" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } else { ?>
														<input type="radio" name="stream" value="0" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } ?>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group"> <?php //<!--hide_cover --> ?>
											<label class="col-sm-3 control-label" for="input-hide_cover">
												<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_hide_cover_desc'); ?>"><?php echo $objlang->get('entry_hide_cover'); ?></span>
											</label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<label class="radio-inline">
														<?php if ($module['hide_cover']) { ?>
														<input type="radio" name="hide_cover" value="1" checked="checked" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } else { ?>
														<input type="radio" name="hide_cover" value="1" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } ?>
													</label>
													<label class="radio-inline">
														<?php if (!$module['hide_cover']) { ?>
														<input type="radio" name="hide_cover" value="0" checked="checked" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } else { ?>
														<input type="radio" name="hide_cover" value="0" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } ?>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group"> <?php //<!--small_header --> ?>
											<label class="col-sm-3 control-label" for="input-small_header">
												<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_small_header_desc'); ?>"><?php echo $objlang->get('entry_small_header'); ?></span>
											</label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<label class="radio-inline">
														<?php if ($module['small_header']) { ?>
														<input type="radio" name="small_header" value="1" checked="checked" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } else { ?>
														<input type="radio" name="small_header" value="1" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } ?>
													</label>
													<label class="radio-inline">
														<?php if (!$module['small_header']) { ?>
														<input type="radio" name="small_header" value="0" checked="checked" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } else { ?>
														<input type="radio" name="small_header" value="0" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } ?>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group"> <?php //<!--show_facepile --> ?>
											<label class="col-sm-3 control-label" for="input-show_facepile">
												<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_show_facepile_desc'); ?>"><?php echo $objlang->get('entry_show_facepile'); ?></span>
											</label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<label class="radio-inline">
														<?php if ($module['show_facepile']) { ?>
														<input type="radio" name="show_facepile" value="1" checked="checked" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } else { ?>
														<input type="radio" name="show_facepile" value="1" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } ?>
													</label>
													<label class="radio-inline">
														<?php if (!$module['show_facepile']) { ?>
														<input type="radio" name="show_facepile" value="0" checked="checked" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } else { ?>
														<input type="radio" name="show_facepile" value="0" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } ?>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group"> <?php //<!--bordercolor --> ?>
											<label class="col-sm-3 control-label" for="input-bordercolor"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_bordercolor_desc'); ?>"><?php echo $objlang->get('entry_bordercolor'); ?> </span> </label>
											<div class="col-sm-9">
												<div class="col-sm-2">
													<input type="text" name="bordercolor" value="<?php echo $module['bordercolor']; ?>" id="input-bordercolor" class="form-control" />
												</div>
											</div>
										</div>
									</div>
								<?php //----------------------------------------------------------------------- ?>
									<div class="tab-pane" id="advanced_option"> <?php //<!--Advanced Option --> ?>
										<div class="form-group"> <?php //<!--Pre-text--> ?>
											<label class="col-sm-3 control-label" for="input-pre_text"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_pre_text_desc'); ?>"><?php echo $objlang->get('entry_pre_text'); ?></span></label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<textarea name="pre_text" id="input-pre_text" class="form-control"><?php echo $module['pre_text']; ?></textarea>
												</div>
											</div>
										</div>
										<div class="form-group"> <?php //<!--Post-text--> ?>
											<label class="col-sm-3 control-label" for="input-post_text"> <span data-toggle="tooltip" title="<?php echo $objlang->get('entry_post_text_desc'); ?>"><?php echo $objlang->get('entry_post_text'); ?></span></label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<textarea name="post_text" id="input-post_text" class="form-control"><?php echo $module['post_text']; ?></textarea>
												</div>
											</div>
										</div>
										<div class="form-group"> <?php //<!--use cache --> ?>
											<label class="col-sm-3 control-label" for="input-use_cache">
												<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_use_cache_desc'); ?>"><?php echo $objlang->get('entry_use_cache'); ?></span>
											</label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<label class="radio-inline">
														<?php if ($module['use_cache']) { ?>
														<input type="radio" name="use_cache" value="1" checked="checked" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } else { ?>
														<input type="radio" name="use_cache" value="1" />
														<?php echo $objlang->get('text_yes'); ?>
														<?php } ?>
													</label>
													<label class="radio-inline">
														<?php if (!$module['use_cache']) { ?>
														<input type="radio" name="use_cache" value="0" checked="checked" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } else { ?>
														<input type="radio" name="use_cache" value="0" />
														<?php echo $objlang->get('text_no'); ?>
														<?php } ?>
													</label>
												</div>
											</div>
										</div>
										<div class="form-group" id="input-cache_time_form"> <?php //<!--cache time --> ?>
											<label class="col-sm-3 control-label" for="input-cache_time">
												<span data-toggle="tooltip" title="<?php echo $objlang->get('entry_cache_time_desc'); ?>"><?php echo $objlang->get('entry_cache_time'); ?></span>
											</label>
											<div class="col-sm-9">
												<div class="col-sm-5">
													<input type="text" name="cache_time" value="<?php echo $module['cache_time']; ?>" id="input-cache_time" class="form-control" />
												</div>
												<?php if (isset($error['cache_time'])) { ?>
												<div class="text-danger col-sm-12"><?php echo $error['cache_time']; ?></div>
												<?php }?>
											</div>
										</div>
									</div>
								<?php //----------------------------------------------------------------------- ?>
								</div>
							</div>
							<?php $module_row++; ?>
						<?php } ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript"><!--
		$('#opencart-tabs a:first').tab('show');
		$('#language').change(function(){
			var that = $(this), opt_select = $('option:selected', that).val() , _input = $('#input-head-name-'+opt_select);
			$('[id^="input-head-name-"]').addClass('hide');
			_input.removeClass('hide');
		});
		if($("input[name='use_cache']:radio:checked").val() == '0')
		{
			$('#input-cache_time_form').hide();
		}else
		{
			$('#input-cache_time_form').show();
		}
		$("input[name='use_cache']").change(function(){
			val = $(this).val();
			if(val ==0)
			{
				$('#input-cache_time_form').hide();
			}else
			{
				$('#input-cache_time_form').show();
			}
		});
		$('.first-name').change(function(){
			$('input[name="head-name"]').val($(this).val());
		});
		$('#input-bordercolor').colpick({
			layout:'hex',
			submit:0,
			colorScheme:'dark',
			onChange:function(hsb,hex,rgb,el,bySetColor) {
				$(el).css('border-color','#'+hex);
				// Fill the text box just if the color was set using the picker, and not the colpickSetColor function.
				if(!bySetColor) $(el).val(hex);
			}
		}).keyup(function(){

			$(this).colpickSetColor(this.value);

		});
		var this_value_bg = $('#input-bordercolor').val();
		$('#input-bordercolor').css('border-left', '25px solid #' + this_value_bg)
		//--></script>
		<script type="text/javascript">
		jQuery(document).ready(function ($) {
			var button = '<div class="remove-caching" style="margin-left: 15px"><button type="button" onclick="remove_cache()" title="<?php echo $objlang->get('entry_button_clear_cache'); ?>" class="btn btn-danger"><i class="fa fa-remove"></i> <?php echo $objlang->get('entry_button_clear_cache')?></button></div>';
			var button_min = '<div class="remove-caching" style="margin-left: 7px"><button type="button" onclick="remove_cache()" title="<?php echo $objlang->get('entry_button_clear_cache'); ?>" class="btn btn-danger"><i class="fa fa-remove"></i> </button></div>';
			if($('#column-left').hasClass('active')){
				$('#column-left #stats').after(button);
			}else{
				$('#column-left #stats').after(button_min);
			}
			$('#button-menu').click(function(){
				$('.remove-caching').remove();
				if($(this).parents().find('#column-left').hasClass('active')){
					$('#column-left #stats').after(button);
				}else{
					$('#column-left #stats').after(button_min);
				}
			});
		});
		function remove_cache(){
			var success_remove = '<?php echo $success_remove; ?>';
			$.ajax({
				type: 'POST',
				url: '<?php echo $linkremove; ?>',
				data: {	is_ajax_cache_lite: 1},
				success: function () {
					var html = '<div class="alert alert-success cls-remove-cache"> '+success_remove+' <button type="button" class="close" data-dismiss="alert">&times;</button></div>';
					if(!($('.page-header .container-fluid .alert-success')).hasClass('cls-remove-cache')){
						$('.page-header .container-fluid').append(html);
					}
				},
			});
		}
	</script>
</div>
<?php echo $footer; ?>