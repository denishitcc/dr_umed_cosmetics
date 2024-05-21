<div class="modal fade" id="appointment_Forms" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Appointment forms</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group d-flex">
                    <button type="button" id="add_new_forms" class="btn btn-primary btn-md me-2" data-bs-toggle="dropdown">+ Add
                        New</button>
                        {{-- data-bs-toggle="dropdown" --}}
                    <div class="dropdown-menu p-3 w-100 shaded-dropdown scroll-y">
                        <ul id="form_dropdown" class="list-group list-group-flush ad-flus">
                        </ul>
                    </div>
                    <button type="button" class="btn btn-secondary btn-md icon-btn-left copy_existing_forms">
                        <i class="ico-copy me-2"></i>Copy existing
                    </button>
                </div>

                <table class="table all-db-table align-middle mb-4">
                    <thead>
                        <tr>
                            <th width="10%" aria-sort="ascending">
                                <input type="checkbox" name="all_forms_check">
                            </th>
                            <th width="60%" aria-sort="ascending">Form</th>
                            <th width="20%">Status</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody id="forms">
                    </tbody>
                </table>

                <div class="fiord mb-4" id="form_check_count"></div>

                <div class="d-flex mb-3">
                    <button class="btn btn-light-grey50 btn-md icon-btn-left me-2 send_forms" disabled>
                        <i class="ico-directbox-notify me-2 fs-6"></i> Send forms
                    </button>
                    <button class="btn btn-light-grey50 btn-md icon-btn-left me-2 update_forms" id="update_forms_client"  disabled>
                        <i class="ico-user2 me-2 fs-6"></i>
                    </button>
                </div>
                <div id="form_sent_time">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-md" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
