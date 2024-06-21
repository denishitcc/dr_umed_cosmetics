<div class="modal fade" id="New_appointment" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-xxl">
            <div class="modal-content">
            <div id="clientCreate" data-url="{{ route('clients.store') }}"></div>
            <form id="create_client" name="create_client" class="form" method="post">
                @csrf
                <input type="hidden" name="check_client" id="check_client" value="selected_client">
                <input type="hidden" name="appointmentlocationId" id="appointmentlocationId">
                <div class="modal-header">
                    <h4 class="modal-title">Please add new appointment here</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="clientCreateModal">
                        <div class="one-inline align-items-center mb-4 client_detail">
                            <div class="form-group icon mb-0 me-3">
                                <input type="text" class="form-control" autocomplete="off" id="searchmodel" placeholder="Search for a client"  onkeyup="changeInputModal(this.value)">
                                <!-- search_client_modal -->
                                <i class="ico-search"></i>
                            </div>
                            <!-- <div class="list-group" id="search_client_modal"></div> -->
                            <span class="me-3">Or</span>
                            <button type="button" class="btn btn-primary btn-md add_new_client">Add a New Client</button>
                        </div>
                        <div class="form-group">
                            <strong class="new_client_head" style="display:none;">New client details</strong>
                            <span class="sep new_client_head mx-2" style="display:none">|</span>
                            <a href="#" class="new_client_head cancel_client" style="display:none">Cancel</a>
                        </div>
                        <div class="mb-5 client_form" style="display:none;">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input type="text" class="form-control" name="firstname" id="firstname_client" maxlength="50">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="lastname" id="lastname_client" maxlength="50">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email" id="email_client" maxlength="100">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Gender</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="gender" value="Male" id="male" checked="checked" />
                                        <label for="male">Male <i class="ico-tick"></i></label>
                                        <input type="radio" name="gender" value="Female" id="female" />
                                        <label for="female">Female <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone </label>
                                        <input type="text" class="form-control" name="phone" id="phone_client" maxlength="15">
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Phone type</label>
                                        <select class="form-select form-control" name="phone_type" id="phone_type_client">
                                            <option selected="" value=""> -- select an option -- </option>
                                            <option>Mobile</option>
                                            <option>Home</option>
                                            <option>Work</option>
                                        </select>
                                        </div>
                                </div>
                                <div class="col-lg-3">
                                    <label class="form-label">Send Promotions</label>
                                    <div class="toggle form-group">
                                        <input type="radio" name="send_promotions" value="1" id="yes" checked="checked">
                                        <label for="yes">Yes <i class="ico-tick"></i></label>
                                        <input type="radio" name="send_promotions" value="0" id="no">
                                        <label for="no">No <i class="ico-tick"></i></label>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="form-label">Preferred contact method</label>
                                            <select class="form-select form-control" name="contact_method" id="contact_method_client">
                                                <option selected="" value=""> -- select an option -- </option>
                                                <option>Text message (SMS)</option>
                                                <option>Email</option>
                                                <option>Phone call</option>
                                                <option>Post</option>
                                                <option>No preference</option>
                                                <option>Don't send reminders</option>
                                            </select>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div id="resultmodal" class="list-group"></div> --}}
                    <div class="client_list_box" style="display:none;">
                        <ul class="drop-list" id="resultmodal"></ul>
                    </div>
                    <div class="mb-5" id="clientmodal">
                        <div class="one-inline align-items-center mb-2">
                            <span class="custname me-3" id="clientDetailsModal"> </span>
                            <input type="hidden" name="clientname" id="clientName">
                            <button type="button" class="btn btn-primary btn-md client_change">Change</button>
                        </div>
                        <em class="d-grey font-12 btn-light">No recent appointments found</em>
                    </div>

                    <div class="row" id="main_row">
                        <div class="col">
                            <h6>Categories</h6>
                            <div class="service-list-box p-2" id="categories">
                            </div>
                        </div>
                        <div class="col">
                            <h6>Services</h6>
                            <div class="service-list-box p-2 catservices" id="all_ser">
                            </div>
                        </div>
                        <div class="col">
                            <h6>Selected Services</h6>
                            <div class="service-list-box p-2" id="all_selected_ser">
                                <ul class="ctg-tree ps-0 pe-1">
                                    <li class="pt-title">
                                        <div class="disflex">
                                            Please Select/Deselect Services
                                        </div>
                                        <ul id="selected_services">
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div><label style="color: red" id="service_error">Please select at least one service for this appointment.</label></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-md" data-bs-dismiss="modal">Discard</button>
                    <button type="button" class="btn btn-primary btn-md" id="appointmentSaveBtn">Save Changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
