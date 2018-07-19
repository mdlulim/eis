<?=$header?>
<div id="content" class="choose-password-wrapper" data-dash-route="dashboard_route">
  	<div class="container-fluid">
  		<br />
	    <br />
	    <div class="row">
	      	<div class="col-sm-offset-4 col-sm-4">
		        <div class="panel panel-default">
		          	<div class="panel-heading">
		            	<h1 class="panel-title">
		            		<i class="fa fa-lock"></i> 
		            		<?=$heading_title?>
		            	</h1>
		          	</div>
		          	<div class="panel-body">
			            <form action="<?=$form_action?>" method="post" novalidate="novalidate">
			              	<div class="form-group">
				                <label for="password1"><?=$text_new_password?></label>
				              	<input type="password" name="password" id="password1" class="form-control" />
				              	<?=$text_password_strength?>: <span class="password-strength weak"></span>
			              	</div>
			              	<div class="form-group">
				                <label for="input-password"><?=$text_confirm_password?></label>
				                <input type="password" name="confirm_password" id="password2" class="form-control" />
				                <span class="password-match"></span>
			              	</div>
			              	
				            <div class="well">
								<h4><i class="fa fa-info-circle"></i> <strong>Password Tips</strong></h4>
								Choose a strong password that won't be easy to guess by others or computers. A strong password contains at least <strong>3</strong> of the following and is a minimum of 8 characters long:
								<ul class="list-check" style="margin-top:10px;">
									<li>Uppercase (A,B,C...)</li>
									<li>Lowercase (a,b,c...)</li>
									<li>Numeric (1,2,3...)</li>
									<li>Special (@, $, %...)</li>
								</ul>
							</div>
			              	<div class="text-right" style="margin-top:20px;">
				                <button type="submit" class="btn btn-primary btn-block btn-lg" disabled="disabled" id="button-change-password">
				                	<?=$button_change_password?>
				                </button>
			              	</div>
			              	<input type="hidden" name="ajax" value="1">
			            </form>
		          	</div>
		        </div>
	      	</div>
	    </div>
  	</div>
</div>

<!-- Page loader -->
<div class="loader-wrapper" style="display:none">
	<div class="loader"></div>
</div>
<!-- /Page loader -->
<?=$footer?>