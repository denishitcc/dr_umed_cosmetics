<div class="modal fade" id="send_forms_modal1" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send forms</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group d-flex">
                    <label class="form-label">Send by</label><br>
                    <div class="toggle">
                        <input type="radio" id="yes" class="status" name="status" value="1"  checked>
                        <label for="yes">Yes <i class="ico-tick"></i></label>
                        <input type="radio" id="no" class="status" name="status" value="0"  >
                        <label for="no">No <i class="ico-tick"></i></label>
                    </div>
                </div>

                <div class="fiord mb-4" id="form_check_count"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-md" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
                                <input type="radio" name="sms_email" value="" id="sms" checked="checked" class="sms_email">
                                <label for="sms">SMS <i class="ico-tick"></i></label>
                                <input type="radio" name="sms_email" value="" id="email" class="sms_email">
                                <label for="email">Email <i class="ico-tick"></i></label>
                            </div>
                        </div>

                        <div class="col-lg-2 sms" style="display:none;">
                            <label class="form-label d-block">&nbsp;</label>
                            <span class="badge text-bg-green badge-md">Live</span>
                        </div>
                        <div class="col-lg-2 email">
                            <label class="form-label d-block">&nbsp;</label>
                            <span class="badge text-bg-grey badge-md">Draft</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light">Cancel</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
