<?php echo $header; ?>
<div id="container" class="container j-container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?><?php echo $column_right; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
        <h1 class="heading-title"><?php echo $heading_title; ?></h1>
        <?php echo $content_top; ?>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <fieldset>
                        <!--<h2 class="secondary-title"><?php echo $text_password; ?></h2>-->
                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-password"><?php echo $entry_password; ?></label>
                            <div class="col-sm-9">
                            <input type="password" name="password" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" id="input-password" class="form-control" />
                            <span class="password-strength-label" style="display:none"><?php echo $text_password_strength; ?>: </span>
                            <span class="password-strength weak"></span>
                            <?php if ($error_password) { ?>
                            <div class="text-danger"><?php echo $error_password; ?></div>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label class="col-sm-3 control-label" for="input-confirm"><?php echo $entry_confirm; ?></label>
                            <div class="col-sm-9">
                            <input type="password" name="confirm" value="<?php echo $confirm; ?>" placeholder="<?php echo $entry_confirm; ?>" id="input-confirm" class="form-control" />
                            <span class="password-match"></span>
                            <?php if ($error_confirm) { ?>
                            <div class="text-danger"><?php echo $error_confirm; ?></div>
                            <?php } ?>
                            </div>
                        </div>
                        </fieldset>
                    </div>    
                    <div class="col-sm-6 col-xs-12">
                        <div class="password-tips">
                            <h4>Password Tips</h4>
                            <p>
                                Choose a strong password that won't be easy to guess by others or computers. A strong password contains at least 3 of the following and is a minimum of 8 characters long:
                            </p>
                            <ul>
                                <li>Uppercase (A,B,C...)</li>
                                <li>Lowercase (a,b,c...)</li>
                                <li>Numeric (1,2,3...)</li>
                                <li>Special (@, $, %...)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="buttons">
                            <!--<div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default button"><?php echo $button_back; ?></a></div>-->
                            <div class="pull-right">
                                <input type="submit" value="<?php echo $button_save; ?>" class="btn btn-primary button" id="button-change-password" disabled="disabled" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <?php echo $content_bottom; ?></div>
    </div>
</div>
<?php echo $footer; ?> 