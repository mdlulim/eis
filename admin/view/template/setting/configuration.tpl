<?php echo $header; ?><?php echo $column_left; ?>
<div id="content" data-token="<?php echo $token; ?>">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" id="button-save" form="form-setting" data-toggle="tooltip" title="<?php echo $button_save; ?>" disabled="disabled" class="btn btn-primary"><i class="fa fa-save"></i></button>
            </div>
            <h1><?php echo $heading_title; ?></h1>
            <ul class="breadcrumb">
                <?php foreach ($breadcrumbs as $breadcrumb) : ?>
                <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-cog"></i> Configuration Settings</h3>
            </div>
            <div class="panel-body">
                <fieldset>
                    <legend>Choose the configuration type</legend>
                    <div class="well">
                        <div class="input-group">
                            <select name="category" class="form-control">
                                <?php foreach ($types as $config) : ?>
                                <option value="<?php echo $config['category']; ?>" <?php echo ($config['category']==='General') ? 'selected="selected"' : '' ?>><?php echo $config['category']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="input-group-addon"><i class="fa fa-filter"></i> Filter</span>
                        </div>
                    </div>
                </fieldset>
                <div id="config"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="newSettingModal" tabindex="-1" role="dialog" aria-labelledby="newSettingModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newSettingModalLabel">Add Setting</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <input type="hidden" name="category">
                    <input type="hidden" name="section">
                    <div class="form-group required">
                        <label class="col-sm-3 control-label text-right">Label/Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-3 control-label text-right">Type</label>
                        <div class="col-sm-9">
                            <select name="type" class="form-control">
                                <!--<option value="checkbox">Checkbox</option>-->
                                <option value="link">Link</option>
                                <option value="radio">Radio</option>
                                <option value="select">Select</option>
                                <option value="text" selected>Text</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-3 control-label text-right">Length</label>
                        <div class="col-sm-9">
                            <input type="number" name="length" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group required" style="display:none">
                        <label class="col-sm-3 control-label text-right">Values</label>
                        <div class="col-sm-9">
                            <input type="text" name="values" class="form-control" placeholder="Type comma separated values here..." />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label text-right">Help</label>
                        <div class="col-sm-9">
                            <input type="text" name="help" class="form-control" placeholder="Help text..." />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?> 