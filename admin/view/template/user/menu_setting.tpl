<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-user-group" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user-group" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <select name="user_group_id" id="input-user_group_id" class="form-control">
                <option value="">Select User Group</option>
                <?php foreach ($usergroups as $usergroup) { ?>
                 <?php if ($usergroup['user_group_id'] == $user_group_id) { ?>
                	<option value="<?php echo $usergroup['user_group_id']; ?>" selected="selected"><?php echo $usergroup['name']; ?></option>
                 <?php } else { ?>
                 	<option value="<?php echo $usergroup['user_group_id']; ?>" ><?php echo $usergroup['name']; ?></option>
                 <?php } ?>
                <?php } ?>
              </select>
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
              <div class="well">
              <ul class="nav nav-pills nav-stacked parent-menu">
				<?php $first = true; ?>
				<?php if (is_array($menuitems) && !empty($menuitems)){ ?>
					<?php foreach($menuitems as $k1 => $v1) { ?>
					  	<?php if (isset($v1['children']) && is_array($v1['children']) && !empty($v1['children'])) { ?>
                        	
                            <input type="checkbox" style="float: left; right: 8px; top:10px;" />
                            
					  		<li class="parent-item has-child <?=($first) ? "active" : "" ?>" style="margin-left: 5px;">
                                <a href="<?=$v1['link']?>" class="parent" style="color:#000000;"><?=$v1['title']?>
                                <?php if($first) { ?>
                                    <i class="fa fa-caret-down" style="margin-left:10px;font-size:15px;"></i> 
                                <?php } else { ?>
                                    <i class="fa fa-caret-up" style="margin-left:10px;font-size:15px;"></i> 
                                <?php } ?>
                                </a>
					  		<ul class="child-menu">
					  		<?php foreach ($v1['children'] as $k2 => $v2) { ?>
					  			<?php if (isset($v2['children']) && is_array($v2['children']) && !empty($v2['children'])) { ?>
                                	<input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" style="float: left; right: 12px; top:4px;"/>
					  				<li class="child-item has-child"><a href="<?=$v2['link']?>" style="color:#000000;"><?=$v2['title']?><i class="fa fa-caret-up" style="margin-left:10px;font-size:15px;"></i> </a>
					  				<ul class="grandchild-menu">
					  				<?php foreach ($v2['children'] as $k3 => $grandchild) { ?>
                                    	<input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" style="float: left; right: 12px; top:4px;" />
					  					<li class="grandchild-item"><a href="<?=$grandchild['link']?>" style="color:#000000;"><?=$grandchild['title']?></a></li>
					  				<?php } ?>
					  				</ul>
					  			<?php } else { ?>
                                	<input type="checkbox" name="permission[access][]" value="<?php echo $permission; ?>" style="float: left; right: 12px; top:4px;"/>
					  				<li class="child-item"><a href="<?=$v2['link']?>" style="color:#000000;"><?=$v2['title']?></a>
					  			<?php } ?>
					  			</li>
					  		<?php } ?>
					  		</ul>
					  	<?php } else { ?>
                        	<input type="checkbox" style="float: left; right: 8px; top:10px;" />
					  		<li class="parent-item <?=($first) ? "active" : "" ?>"><a class="parent" href="<?=$v1['link']?>" style="background:none;color:#000000;"><?=$v1['title']?></a>
					  	<?php } ?>
					  	<?php $first = false; ?>
					  	</li>
					<?php } ?>
				<?php } ?>
				</ul>
              </li>  
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	(function ($) {
		'use strict';
		$('.nav li.parent-item > a').on('click', function(e) {
			if ($(this).parent('li.parent-item').hasClass('has-child')) {
				e.preventDefault();
				
				if($(this).parent('li').hasClass('active'))
				{
					$('.nav li.parent-item').removeClass('active');
					$(this).children('a i').removeClass('fa-caret-down');
					$(this).children('a i').addClass('fa-caret-up');
				}
				else
				{
					$('.nav li.parent-item').removeClass('active');
					$(this).parent('li.parent-item').addClass('active');
					$(this).children('a i').removeClass('fa-caret-up');
					$(this).children('a i').addClass('fa-caret-down');
					
				}
			}
		});
		$('.nav li.parent-item li.child-item > a').on('click', function(e) {
			if ($(this).parent('li.child-item').hasClass('has-child')) {
				e.preventDefault();
				//$('.nav li.parent-item li.child-item').removeClass('active');
				//$(this).parent('li.child-item').addClass('active');
				
				if($(this).parent('li.child-item').hasClass('active'))
				{
					$('.nav li.parent-item li.child-item').removeClass('active');
					$(this).children('a i').removeClass('fa-caret-down');
					$(this).children('a i').addClass('fa-caret-up');
				}
				else
				{
					$('.nav li.parent-item li.child-item').removeClass('active');
					$(this).parent('li.parent-item li.child-item').addClass('active');
					$(this).children('a i').removeClass('fa-caret-up');
					$(this).children('a i').addClass('fa-caret-down');
				}
				
			}
		});
	})(window.jQuery);
	
	$('input[type=checkbox]').click(function(){
		// children checkboxes depend on current checkbox
		$(this).next().find('input[type=checkbox]').prop('checked',this.checked);
		// go up the hierarchy - and check/uncheck depending on number of children checked/unchecked
		$(this).parents('ul').prev('input[type=checkbox]').prop('checked',function(){
			return $(this).next().find(':checked').length;
		});
	});
	
	$('select[name=\'user_group_id\']').on('change', function() {
		
		var user_group_id = this.value;
		if(user_group_id != '')
		{
			var url = 'index.php?route=user/menu_setting&token=<?php echo $token; ?>&user_group_id='+ user_group_id +'';
			window.location = url;
		}
	});
	
</script>
<style type="text/css">
		.child-menu, .grandchild-menu {
			display: none;
			margin: 6px 0 10px -20px;
		}
		.child-menu {
			margin-top: 0px;
			padding-left: 35px;
		}
		.child-menu a {
			font-weight: normal;
			padding: 4px 0;
		    display: block;
		}
		.parent-item.active > .child-menu {display: block !important}
		.child-item.active > .grandchild-menu {display: block !important}
		
		.parent-item a.parent {font-weight:bold;}
		.child-item, .grandchild-item{
			list-style:none;
		}
		.nav > li > a:hover, .nav > li > a.parent{background-color:#F5F5F5}
		.nav > li > a:hover, .nav > li > a.parent:focus{background-color:#eee !important}
	</style>
<?php echo $footer; ?> 