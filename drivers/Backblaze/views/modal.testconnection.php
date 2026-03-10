<div class='modal fade' id='custmodal'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h3 id='mheader' class="mr-auto">Test Connection Settings</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class='modal-body'>
                <div class="row">
                    <div class="col-sm-12">
                        Checking Backblaze B2 connection...<br><br><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-3 control-label">
                        B2 API Connection:
                    </div>
                    <div class="col-sm-12 col-lg-9" id="b2apiconnection">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-3 control-label">
                        B2 Credentials:
                    </div>
                    <div class="col-sm-12 col-lg-9" id="b2credentials">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-3 control-label">
                        B2 Write Test:
                    </div>
                    <div class="col-sm-12 col-lg-9" id="b2write">
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <button type="button" class="btn btn-primary" id='testcon_close'><?php echo _("Close"); ?></button>
            </div>
        </div>
    </div>
</div>
