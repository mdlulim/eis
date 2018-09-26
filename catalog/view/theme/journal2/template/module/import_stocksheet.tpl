<!-- Modal -->
<div class="modal fade" id="modalImportStocksheet" tabindex="-1" role="dialog" aria-labelledby="modalImportStocksheetLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-download"></i>
                    Import Stock Sheet
                </h4>
            </div>
            <div class="modal-body">
                <div class="steps clearfix">
                    <ul role="tablist">
                    <li role="tab" class="first done" aria-disabled="false" aria-selected="true">
                        <a id="steps-uid-0-t-0" href="#steps-uid-0-h-0" aria-controls="steps-uid-0-p-0">
                        <span class="step"><i class="fa fa-upload"></i></span> 
                        Upload
                        </a>
                    </li>
                    <li role="tab" class="current" aria-disabled="true">
                        <a id="steps-uid-0-t-1" href="#steps-uid-0-h-1" aria-controls="steps-uid-0-p-1">
                        <span class="current-info audible">current step: </span>
                        <span class="step"><i class="fa fa-check"></i></span> 
                        Validate
                        </a>
                    </li>
                    <li role="tab" class="disabled" aria-disabled="true">
                        <a id="steps-uid-0-t-2" href="#steps-uid-0-h-2" aria-controls="steps-uid-0-p-2">
                        <span class="step"><i class="fa fa-file-text"></i></span> 
                        Add to Stock Sheet
                        </a>
                    </li>
                    <li role="tab" class="disabled last" aria-disabled="true">
                        <a id="steps-uid-0-t-3" href="#steps-uid-0-h-3" aria-controls="steps-uid-0-p-3">
                        <span class="step"><i class="fa fa-thumbs-up"></i></span> 
                        Finish
                        </a>
                    </li>
                    </ul>
                </div>
                <div class="text-area">
                    <div class="ajax__loader">
                        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                        <p>Please wait, as this might take time...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="form__import-items-not-found" action="index.php?route=checkout/cart/items_not_found" method="post">
                    <input type="hidden" name="items">
                </form>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" disabled="disabled" data-action="add_to_stocksheet" id="button-continue">Continue</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->