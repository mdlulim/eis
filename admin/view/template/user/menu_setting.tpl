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
              <?php if ($error_user_group_id) { ?>
              <div class="text-danger"><?php echo $error_user_group_id; ?></div>
              <?php  } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-10">
              <div class="well" style="background-color:#fff">
              	<ul class="nav nav-pills nav-stacked parent-menu">
              		<?php $first=true; $check=$userGroupMenuItems; ?>
              		<?php if (is_array($menuitems) && !empty($menuitems)) : ?>
              			<?php foreach($menuitems as $k1 => $parent) : ?>
          					<li class="parent-item has-child <?=($first) ? 'active': ''?>">
          						<input name="menu_id[]" value="<?=$parent['menu_id']?>" type="checkbox" <?=(in_array($parent['menu_id'], $check)) ? 'checked="checked"' : '' ?> />
          						<a href="javascript:void()" class="parent cst"><?=$parent['title']?></a>
                                <i></i>
                                <?php if (is_array($parent['children']) && !empty($parent['children'])) : ?>
                                	<ul class="child-menu">
                                	<?php foreach($parent['children'] as $k2 => $child) : ?>
						  				<li class="child-item child-item1 <?=(isset($child['children'])) ? 'has-child' : '' ?>">
                                			<input name="menu_id[]" value="<?php echo $child['menu_id']?>" type="checkbox" <?=(in_array($child['menu_id'], $check)) ? 'checked="checked"' : '' ?> />
						  					<a href="javascript:void()">
						  						<?=$child['title']?>
						  					</a>
						  					<i></i>
						  					<?php if (is_array($child['children']) && !empty($child['children'])) : ?>
						  						<ul class="grandchild-menu">
						  						<?php foreach($child['children'] as $k3 => $grandchild) : ?>
						  							<li class="child-item <?=(isset($grandchild['children'])) ? 'has-child' : '' ?>">
						  								<input name="menu_id[]" value="<?php echo $grandchild['menu_id']?>" type="checkbox" <?=(in_array($grandchild['menu_id'], $check)) ? 'checked="checked"' : '' ?> />
						  								<a href="javascript:void()">
						  									<?=$grandchild['title']?>
						  								</a>
						  								<i></i>
						  								<?php if (is_array($grandchild['children']) && !empty($grandchild['children'])) : ?>
						  									<ul class="great-grandchild-menu">
						  									<?php foreach($grandchild['children'] as $k4 => $innerGrandchild) : ?>
						  										<li class="child-item">
						  											<input type="checkbox" name="menu_id[]" value="<?php echo $innerGrandchild['menu_id']?>" <?=(in_array($innerGrandchild['menu_id'], $check)) ? 'checked="checked"' : '' ?> />
						  											<a href="javascript:void()">
						  												<?=$innerGrandchild['title']?>
					  												</a>
						  										</li>
						  									<?php endforeach; ?>
						  									</ul>
						  								<?php endif; ?>
					  								</li>
					  							<?php endforeach; ?>
					  							</ul>
					  						<?php endif; ?>
                            			</li>
                            		<?php endforeach; ?>
                            		</ul>
                                <?php endif; ?>
          					</li>
          					<?php $first=false; ?>
          				<?php endforeach; ?>
              		<?php endif; ?>
              	</ul>
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
				
				$('.nav li.parent-item li.child-item  ul.grandchild-menu > li.child-item > ul').css("display", "none");
				$('.nav li.parent-item li.child-item').removeClass('active');
				
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

		$('.nav li.parent-item li.child-item1 > a').on('click', function(e) { 
			if ($(this).parent('li.child-item').hasClass('has-child')) {
				e.preventDefault();
				//$('.nav li.parent-item li.child-item').removeClass('active');
				//$(this).parent('li.child-item').addClass('active');
				$('.nav li.parent-item li.child-item  ul.grandchild-menu > li.child-item > ul').css("display", "none");
				
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
		
		// Last Child Menu Dropdown Start

		$('.nav li.parent-item li.child-item  ul.grandchild-menu > li.child-item > a').on('click', function(e) { 
			if ($(this).parent('li.child-item  ul.grandchild-menu > li.child-item').hasClass('has-child')) { 
				e.preventDefault();
				//$('.nav li.parent-item li.child-item').removeClass('active');
				//$(this).parent('li.child-item').addClass('active');
				$('.nav li.parent-item li.child-item  ul.grandchild-menu > li.child-item > ul').css("display", "none");
				
				if($(this).parent('li.child-item  ul.grandchild-menu > li.child-item').hasClass('active'))
				{ 
					$('.nav li.parent-item li.child-item  ul.grandchild-menu > li.child-item').removeClass('active');
					$('.nav li.parent-item li.child-item  ul.grandchild-menu > li.child-item > ul').css("display", "none");
					$(this).children('a i').removeClass('fa-caret-down');
					$(this).children('a i').addClass('fa-caret-up');
					$(this).siblings('li > ul').css("display", "none");
					
				}
				else
				{ 
					$('.nav li.parent-item li.child-item  ul.grandchild-menu > li.child-item').removeClass('active');
					$(this).parent('li.parent-item li.child-item  ul.grandchild-menu > li.child-item').addClass('active');
					$(this).children('a i').removeClass('fa-caret-up');
					$(this).children('a i').addClass('fa-caret-down');
					//$(this).parent('li.child-item  ul.grandchild-menu > li.child-item .great-grandchild-menu').show();
					//$('.nav li.parent-item li.child-item  ul.grandchild-menu > li.child-item > ul').css("display", "block");
					$(this).siblings('li > ul').css("display", "block");
				}
				
			}
		});

		// Last Child Menu Dropdown End
		
	})(window.jQuery);
	
	$('input[type=checkbox]').click(function() {
		var parent = $(this).parent('li');

		// children checkboxes depend on current checkbox
		parent.find('input[type=checkbox]').prop('checked', this.checked);
		
		
		$.fn.linkNestedCheckboxes = function () {
		var childCheckboxes = $(this).find('input[type=checkbox] ~ ul li input[type=checkbox]');
		
		childCheckboxes.change(function(){
			var parent = $(this).closest("ul").prevAll("input[type=checkbox]").first();
			var anyChildrenChecked = $(this).closest("ul").find("li input[type=checkbox]").is(":checked");
			$(parent).prop("checked", anyChildrenChecked);
		});
		
		// Parents
		childCheckboxes.closest("ul").prevAll("input[type=checkbox]").first().change(function(){
		   $(this).nextAll("ul").first().find("li input[type=checkbox]")
					.prop("checked", $(this).prop("checked"));        
		});
		
		
		return $(this);
	};
	
	$(".well").linkNestedCheckboxes();
		

		// go up the hierarchy - and check/uncheck depending on number of children checked/unchecked
		// $(this).parents('ul').children('li').next('input[type=checkbox]').prop('checked',function(){
		// 	return $(this).next().find(':checked').length;
		// });
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
		.child-menu, .grandchild-menu, .lastgrandchild-menu {
			display: none;
			margin: 6px 0 10px -20px;
		}
		
		.great-grandchild-menu{
			display: none;
		}
		.child-menu {
			margin: 0; 
			padding: 5px 10px 15px 10px; 
			border-top: 1px solid #e3e3e3;
		}
		.child-menu a {
			background-color: #f5f5f5;
			color: #555;
			font-weight: 600;
			padding: 9px 35px;
		    display: block;
		}
		.nav.nav-pills li.parent-item {
		    margin-left: 0;
		    position: relative;
		    border: 1px solid #e3e3e3;
		    margin-bottom: 13px;
		}
		.nav.nav-pills li.parent-item > i {
			display: inline-block;
		    font: normal normal normal 14px/1 FontAwesome;
		    font-size: inherit;
		    text-rendering: auto;
		    -webkit-font-smoothing: antialiased;
		    -moz-osx-font-smoothing: grayscale;
		}
		.nav.nav-pills li.parent-item > i {
			color: #555;
			font-size: 14px;
			position: absolute; 
			right: 15px; 
			top: 11px; 
			z-index: 1;
		}
		.nav.nav-pills li.parent-item > i:before { content: "\f105"; }
		.nav.nav-pills li.parent-item.active > i:before { content: "\f107"; }
		.parent-item.active > .child-menu {display: block !important}
		.child-item.active > .grandchild-menu {display: block !important}
		
		.parent-item .child-menu.active > .child-menu {display: block !important}
		.child-item .grandchild-menu.active > .grandchild-menu {display: block !important}
		
		.parent-item a.parent {
			font-weight: bold;
			padding-left: 35px;
		    color: #666;
			background-color: #eee !important;
		    border-radius: 0;
		    border: 1px solid #e2e2e2;
		}

		.nav > li.parent-item  > a:hover, 
		.nav > li.parent-item > a.parent:focus {
			color: #555;
    		background-color: #eee !important;
		}
		.nav li.parent-item > input {
			float: left;
			left: 11px; 
			top: 11px; 
			z-index: 1;
		}
		.child-item, .grandchild-item, .lastchild-item, .lastgrandchild-item {
			position: relative;
			list-style:none;
		}

		.child-menu > .child-item {
			position: relative;
		    margin-top: 10px;
		    padding: 0;
		    border: 1px dotted #e3e3e3;
		}
		.child-item > input {
			float: left;
		    left: 10px;
    		top: 9px;
		}

		.child-menu .child-item.active > a {
			border-bottom: 1px dotted #e3e3e3;
		}

		.nav > li > a:hover, .nav > li > a.parent{background-color:#F5F5F5; color: #555;}
		.nav > li > a:hover, .nav > li > a.parent:focus{background-color:#eee !important; color: #555;}

		.grandchild-menu, .lastgrandchild-menu {
			margin: 0;
		    padding-left: 0;
		    margin-left: 10px;
		}
		.grandchild-menu > li.child-item {
			position: relative;
			margin-top: 10px;
			margin-right: 10px;
			border: 1px dotted #ccc;
		}
		.great-grandchild-menu {
			border-top: 1px dotted #ccc;
			margin: 0;
		    padding: 0;
		    padding-left: 10px;
		}
		.great-grandchild-menu > li.child-item {
			margin-top: 10px;
			margin-right: 10px;
		}
		.great-grandchild-menu > li.child-item:last-child {
			margin-bottom: 10px;
		}
		.great-grandchild-menu > li.child-item a {
			background-color: #fff;
			border: 1px dotted #eee;
		}
		.child-item > i {display:none}
		.child-item.has-child > i {
			display: inline-block;
		    font: normal normal normal 14px/1 FontAwesome;
		    font-size: inherit;
		    text-rendering: auto;
		    -webkit-font-smoothing: antialiased;
		    -moz-osx-font-smoothing: grayscale;
			color: #555;
			font-size: 14px;
			position: absolute; 
			right: 15px; 
			top: 11px; 
			z-index: 1;
		}
		.child-item.has-child > i:before { content: "\f105"; }
		.child-item.has-child.active > i:before { content: "\f107"; }
		
		.great-grandchild-menu .child-item a {
			background-color: #f5f5f5;
			color: #555;
			font-weight: 600;
			padding: 9px 35px;
		    display: block;
		}
		
	</style>
<?php echo $footer; ?> 