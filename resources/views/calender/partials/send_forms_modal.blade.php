<div class="modal fade" id="send_forms_modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Send Forms</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <label class="form-label">Send by</label>
                            <div class="toggle">
                                <input type="radio" name="sms_email" value="1" id="sms" class="sms_email" checked="checked">
                                <label for="sms">SMS <i class="ico-tick"></i></label>
                                <input type="radio" name="sms_email" value="0" id="email" class="sms_email" >
                                <label for="email">Email <i class="ico-tick"></i></label>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-12 sms" >
                        <label class="form-label d-block">&nbsp;</label>
                        <input type="text" name="mobile_no" class="form-control" id="mobile_no" placeholder="Mobile no">
                    </div>
                    <div class="col-lg-12 email" style="display:none;">
                        <label class="form-label d-block">&nbsp;</label>
                        <input type="text" name="email" class="form-control" id="clientemail" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="sent_sms_email">Save</button>
            </div>
        </div>
    </div>
</div>
