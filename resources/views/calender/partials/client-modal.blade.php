<!-- client card modal -->
<div class="modal fade" id="Client_card" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xxl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title modal-title-client">Client card</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="client_info">

                <ul class="nav brand-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#ptab_1" aria-selected="true"
                            role="tab"><i class="ico-clipboard-text"></i> Client History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ptab_2" aria-selected="false" tabindex="-1"
                            role="tab"><i class="ico-task"></i> Client Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ptab_3" aria-selected="false" tabindex="-1"
                            role="tab"><i class="ico-photo"></i> Photos <span
                                class="badge badge-circle ms-2 photos_count">0</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ptab_4" aria-selected="false" tabindex="-1"
                            role="tab"><i class="ico-folder"></i> Documents <span
                                class="badge badge-circle ms-2 documents_count">0</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ptab_5" aria-selected="false" tabindex="-1"
                            role="tab"><i class="ico-appt-reminder"></i> Forms <span class="badge badge-circle ms-2"
                                id="total_forms">0</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ptab_6" aria-selected="false" tabindex="-1"
                            role="tab"><i class="ico-payment-gateway"></i> Messages</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="ptab_1" role="tabpanel">
                        <div class="card-body">
                            <div class="scaffold-layout-outr">
                                <div class="scaffold-layout-list-details" id="appointmentTab">

                                    {{-- Notes section --}}

                                    <div class="scaffold-layout-detail" id="clientNotes">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ptab_2" role="tabpanel">
                        <div class="card-head pb-4">
                            <h5 class="bright-gray mb-0">Client details </h5>
                        </div>
                        <form id="update_client_detail" name="update_client_detail" class="form">
                            @csrf
                            <input type="hidden" name="id" id="id" value="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">First Name</label>
                                            <input type="text" class="form-control" placeholder="" name="firstname"
                                                id="firstname" maxlength="50" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Last Name </label>
                                            <input type="text" class="form-control" placeholder=""
                                                name="lastname" id="lastname" maxlength="50" value="">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label">Gender</label>
                                        <div class="toggle mb-1">
                                            <input type="radio" name="gender" value="Male" id="male"
                                                checked="checked" />
                                            <label for="male">Male <i class="ico-tick"></i></label>
                                            <input type="radio" name="gender" value="Female" id="female" />
                                            <label for="female">Female <i class="ico-tick"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" class="form-control" placeholder="" name="email"
                                                maxlength="100" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Date of Birth</label>
                                            <input type="date" class="form-control" name="date_of_birth"
                                                id="date_of_birth">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group mb-4">
                                            <label class="form-label">Mobile Number</label>
                                            <input type="text" class="form-control" name="mobile_number"
                                                id="mobile_number" maxlength="15">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">Home Phone</label>
                                            <input type="text" class="form-control" name="home_phone"
                                                id="home_phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">Work Phone</label>
                                            <input type="text" class="form-control" name="work_phone"
                                                id="work_phone">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-head pt-3 pb-4">
                                <h5 class="bright-gray mb-0">Contact preferences</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">Preferred contact method</label>
                                            <select class="form-select form-control" name="contact_method"
                                                id="contact_method">
                                                <option selected="" value=""> -- select an option --
                                                </option>
                                                <option value="Text message (SMS)">Text message (SMS)</option>
                                                <option value="Email">Email</option>
                                                <option value="Phone call">Phone call</option>
                                                <option value="Post">Post</option>
                                                <option value="No preference">No preference</option>
                                                <option value="Don't send reminders">Don't send reminders</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="form-label">Send promotions</label>
                                        <div class="toggle mb-0">
                                            <input type="radio" name="send_promotions" value="1"
                                                id="yes" checked="checked" />
                                            <label for="yes">Yes <i class="ico-tick"></i></label>
                                            <input type="radio" name="send_promotions" value="0"
                                                id="no" />
                                            <label for="no">No <i class="ico-tick"></i></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-head pt-3 pb-4">
                                <h5 class="bright-gray mb-0">Address</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Street address</label>
                                            <input type="text" class="form-control" id="street_address"
                                                name="street_address">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-label">Suburb</label>
                                            <input type="text" class="form-control" id="suburb"
                                                name="suburb">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group mb-0">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" id="city"
                                                name="city">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group mb-0">
                                            <label class="form-label">Post code</label>
                                            <input type="text" class="form-control" id="postcode"
                                                name="postcode">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-lg-end mt-4">
                                        <button type="button" class="btn btn-light me-2"
                                            onclick="window.location='{{ url('clients') }}'">Discard</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="ptab_3" role="tabpanel">
                        <form id="update_client_photos" name="update_client_photos" class="form" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id" value="">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="gl-upload photo_img">
                                        <div class="icon-box">
                                            <img src="../img/upload-icon.png" alt="" class="up-icon">
                                            <span class="txt-up">Choose a File or drag them here</span>
                                            <input type="file" class="filepond form-control" name="filepond"
                                                id="client_photos" accept="image/png, image/jpeg" multiple />
                                        </div>
                                    </label>
                                    <div class="mt-2 d-grey font-13"><em>Photos you add here will be visible to this
                                            client in Online Booking.</em></div>
                                </div>
                                <div class="gallery client-phbox abc grid-6 gap-2 h-188 photos">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="ptab_4" role="tabpanel">
                        <form id="update_client_documents" name="update_client_documents" class="form"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="gl-upload doc_img">
                                        <div class="icon-box">
                                            <img src="../img/upload-icon.png" alt="" class="up-icon">
                                            <span class="txt-up">Choose a File or drag them here</span>
                                            <span class="txt-up" style="opacity: .5;">.xls, Word, PNG, JPG or
                                                PDF</span>
                                            <input class="form-control" type="file" id="client_documents"
                                                name="client_documents"
                                                accept="application/pdf, applucation/vnd.ms-excel,application/msword,image/png, image/jpeg"
                                                multiple>
                                        </div>
                                    </label>
                                    <div class="mt-2 d-grey font-13"><em>Documents you add here will be visible to this
                                            client in Online Booking.</em></div>
                                </div>
                                <div class="form-group mb-0 client_docs">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="ptab_5" role="tabpanel">
                        <div class="card-body">
                            <table class="table all-db-table align-middle accordion-table" id="form_history_table">
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="ptab_6" role="tabpanel">
                        <div class="card-body">
                            <h6 class="fiord mb-4">This client has no upcoming appointments.</h6>
                            <div class="time-line--outr pd-20">
                                <div class="time-line-item">
                                    <div class="time-line-icon">
                                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                                    </div>
                                    <div class="time-line-content">
                                        <div class="dot-box">
                                            <span class="badge booked me-3 font-13">Booked</span>
                                            <div class="dropdown">
                                                <button class="dot-nav" data-bs-toggle="dropdown"><i
                                                        class="ico-nav-dots"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island
                                            4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519
                                            to reschedule.</p>
                                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                                    </div>
                                </div>
                                <div class="time-line-item">
                                    <div class="time-line-icon">
                                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                                    </div>
                                    <div class="time-line-content">
                                        <div class="dot-box">
                                            <span class="badge completed me-3 font-13">Completed</span>
                                            <div class="dropdown">
                                                <button class="dot-nav" data-bs-toggle="dropdown"><i
                                                        class="ico-nav-dots"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island
                                            4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519
                                            to reschedule.</p>
                                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                                    </div>
                                </div>
                                <div class="time-line-item">
                                    <div class="time-line-icon">
                                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                                    </div>
                                    <div class="time-line-content">
                                        <div class="dot-box">
                                            <span class="badge turned-up me-3 font-13">Turned-up</span>
                                            <div class="dropdown">
                                                <button class="dot-nav" data-bs-toggle="dropdown"><i
                                                        class="ico-nav-dots"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island
                                            4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519
                                            to reschedule.</p>
                                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                                    </div>
                                </div>
                                <div class="time-line-item">
                                    <div class="time-line-icon">
                                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                                    </div>
                                    <div class="time-line-content">
                                        <div class="dot-box">
                                            <span class="badge completed me-3 font-13">Completed</span>
                                            <div class="dropdown">
                                                <button class="dot-nav" data-bs-toggle="dropdown"><i
                                                        class="ico-nav-dots"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island
                                            4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519
                                            to reschedule.</p>
                                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                                    </div>
                                </div>
                                <div class="time-line-item">
                                    <div class="time-line-icon">
                                        <div class="avatar" style="background: #D0D0D0; color: #000;">M</div>
                                    </div>
                                    <div class="time-line-content">
                                        <div class="dot-box">
                                            <span class="badge completed me-3 font-13">Completed</span>
                                            <div class="dropdown">
                                                <button class="dot-nav" data-bs-toggle="dropdown"><i
                                                        class="ico-nav-dots"></i></button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">Booked</a></li>
                                                    <li><a class="dropdown-item" href="#">Completed</a></li>
                                                    <li><a class="dropdown-item" href="#">Turned-up</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="blue-bold mb-2">Appointment: Wed 4 Oct 2023@ Hope Island</div>
                                        <p class="mb-2">Zeina, Dr Umed Cosmetics 1/341 Hope Island Rd Hope Island
                                            4212 Wed, 4-Oct 12:00pm. Please respond YES to confirm or call 0407 194 519
                                            to reschedule.</p>
                                        <em class="d-grey font-13">SMS Sent 4 Oct 2023, 12.00 PM</em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="copy_exist1" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Copy Exist Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <p class="mb-4">Gravida aliquet parturient curae porta vel sit praesent praesent ac posuere venenatis
                    senectus venenatis ullamcorper ullamcorper pulvinar urna luctus hac ad dictumst.A adipiscing
                    condimentum ut ullamcorper vestibulum ipsum ante scelerisque massa et a a velit morbi aliquam
                    egestas.</p>



                <table class="table all-db-table align-middle mb-4">
                    <thead>
                        <tr>
                            <th colspan="2"><b>3 jun</b></th>


                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td><a href="#" class="simple-link">Skin Needling - CONSULTATION FORM</a></td>
                            <td><span class="badge text-bg-green badge-md badge-rounded">New</span></td>

                        </tr>
                        <tr>
                            <td><a href="#" class="simple-link">Skin Needling - CONSULTATION FORM</a></td>
                            <td><span class="badge text-bg-secondary badge-md badge-rounded">In Progress</span></td>

                        </tr>
                    </tbody>
                </table>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-md" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
