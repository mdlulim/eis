<form name="form" id="form" class="form-horizontal text-left"
      action="<?php echo 'https://secure.paygate.co.za/payweb3/process.trans'?>" method="post">
    <input type="hidden" name="PAY_REQUEST_ID" value="<?php echo $PAY_REQUEST_ID; ?>"/>
    <input type="hidden" name="CHECKSUM" value="<?php echo $CHECKSUM; ?>"/>
    <div class="buttons">
        <div class="pull-right"><input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary"/>
        </div>
    </div>
</form>