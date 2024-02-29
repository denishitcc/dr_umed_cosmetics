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
                                class="badge badge-circle ms-2 photos_count">10</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ptab_4" aria-selected="false" tabindex="-1"
                            role="tab"><i class="ico-folder"></i> Documents <span
                                class="badge badge-circle ms-2 documents_count">10</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#ptab_5" aria-selected="false" tabindex="-1"
                            role="tab"><i class="ico-appt-reminder"></i> Forms <span
                                class="badge badge-circle ms-2">10</span></a>
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
                                            <input type="text" class="form-control" placeholder=""
                                                name="firstname" id="firstname" maxlength="50" value="">
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
                                    <label class="gl-upload">
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
                                <div class="gallery client-phbox grid-6 gap-2 h-188">
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
                                    <label class="gl-upload">
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
                            <table class="table all-db-table align-middle accordion-table">
                                <thead>
                                    <tr>
                                        <th class="blue-bold" width="70%" aria-sort="ascending">22 Sep 2023</th>
                                        <th class="blue-bold" width="20%">Status </th>
                                        <th class="blue-bold" width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="pnl-head">
                                        <td><a href="#" style="color: #0747A6;">Aftercare Dermal Fillers -
                                                (Please take a snap shot)</a></td>
                                        <td><span class="badge text-bg-blue badge-md badge-rounded">Submitted</span>
                                        </td>
                                        <td class="text-center"><button type="button"
                                                class="btn btn-sm black-btn round-6 dt-delete"> <i
                                                    class="ico-trash"></i> </button></td>
                                    </tr>
                                    <tr class="pnl-content">
                                        <td colspan="3">
                                            <div class="table-card-header">
                                                <h5>Aftercare Dermal Fillers - (Please take a snap shot) Form</h5>
                                                <button type="button" class="btn-close"></button>
                                            </div>
                                            <div class="table-card-body">
                                                <div class="d-flex mb-4">
                                                    <a href="#"
                                                        class="btn btn-light-grey50 btn-md icon-btn-left"><i
                                                            class="ico-user2 me-2 fs-6"></i> Give to Alana to Update
                                                        Details</a>
                                                </div>

                                                <div class="alert alert-green alert-xs">
                                                    This form is read-only because it's been completed.
                                                    <a href="#" class="alert-close"><i
                                                            class="ico-close"></i></a>
                                                </div>


                                                <p>Dr Umed Shekhawat<br>
                                                    Cosmetic Physician (Specialist Registration General Practice)<br>
                                                    MBBS, FRACGP, Diploma of Skin Cancer / The Injecting Nurse has
                                                    explained the products and procedure to me.<br><br>
                                                    I have been informed by the Dr/ Nurse of possible complications of
                                                    Dermal Fillers, such as local pain, redness, swelling, bruising,
                                                    infection, biofilm, blistering or ulceration. There is also a risk
                                                    of skin darkening or lightening, which can last for several months.
                                                    There have also been reported cases of loss of vision, stroke and
                                                    nerve paralysis, but these complications are extremely rare. There
                                                    is a slight chance of having a poor cosmetic outcome, over
                                                    correction or under correction.<br><br>

                                                    Fillers can be dissolved if you are unhappy with the outcome, and in
                                                    the case of under correction, more product may be injected however
                                                    both options will incur a further cost.<br><br>

                                                    Dr Umed and his Nurses are highly trained and experienced in all the
                                                    cosmetic procedures he provides however, he is not able to guarantee
                                                    the clients expected results will occur in a singular visit and as
                                                    such, he has a strict no refund policy under any circumstances.
                                                    <br><br>

                                                    This informed consent document outlines most of the common and
                                                    uncommon risks involving cosmetic injections. Other risks are
                                                    possible. Once you have read and understood this information, and
                                                    had the opportunity to ask questions and discuss any concerns with
                                                    Dr. Umed or one of our Registered Nurses, please sign and date
                                                    below.</p>

                                                <div class="white-layer">
                                                    <label class="form-label"><b>I understand the above</b>
                                                    </label><br>
                                                    <label class="cst-radio"><input type="radio" checked=""
                                                            name="form1"><span
                                                            class="checkmark me-2"></span>Yes</label>
                                                </div>

                                                <div class="white-layer">
                                                    <label class="form-label"><b>Alternatives to injections include no
                                                            treatment, skin care, laser resurfacing, chemical peels,
                                                            facelifts and other surgical therapies, and other
                                                            modalities.
                                                        </b> </label><br>
                                                    <label class="cst-radio"><input type="radio" checked=""
                                                            name="form2"><span
                                                            class="checkmark me-2"></span>Yes</label>
                                                </div>

                                                <div class="white-layer">
                                                    <label class="form-label"><b>I understand the above </b>
                                                    </label><br>
                                                    <label class="cst-radio"><input type="radio" checked=""
                                                            name="form3"><span
                                                            class="checkmark me-2"></span>Yes</label>
                                                </div>

                                                <div class="white-layer">
                                                    <label class="form-label"><b>Risks. Every procedure (surgical or
                                                            non-surgical) involves risks that can only be completely
                                                            avoided by foregoing treatment. Determining whether or not a
                                                            procedure is right for you depends on your evaluation of the
                                                            risks, benefits, goals, alternatives, and recovery
                                                            associated with the procedures.</b> </label><br>
                                                    <label class="cst-radio"><input type="radio" checked=""
                                                            name="form4"><span class="checkmark me-2"></span>I
                                                        understand</label>
                                                </div>

                                                <div class="white-layer">
                                                    <label class="form-label"><b>Bumpiness (nodularity). Patients often
                                                            feel some bumpiness, firmness, or tightness under the skin
                                                            at the site of filler injections. Usually, this is not
                                                            visible and resolves in 1 -2 weeks.</b> </label><br>
                                                    <label class="cst-radio"><input type="radio" checked=""
                                                            name="form5"><span class="checkmark me-2"></span>I
                                                        understand</label>
                                                </div>

                                                <div class="white-layer">
                                                    <label class="form-label"><b>Bumpiness (nodularity). Patients often
                                                            feel some bumpiness, firmness, or tightness under the skin
                                                            at the site of filler injections. Usually, this is not
                                                            visible and resolves in 1 -2 weeks. </b> </label><br>
                                                    <label class="cst-radio me-3"><input type="radio"
                                                            checked="" name="form6"><span
                                                            class="checkmark me-2"></span>Yes</label>
                                                    <label class="cst-radio"><input type="radio" checked=""
                                                            name="form6"><span
                                                            class="checkmark me-2"></span>No</label>
                                                </div>

                                                <p>By signing this document, I have read and understand the information
                                                    provided in this waiver and grant permission for my treatment.</p>

                                                <div class="mb-4"><img src="img/demo-signature.png" alt="">
                                                </div>

                                                <label>9:43 am 22 Sep 2023</label><br><br>

                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <input type="date" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-card-footer">
                                                <div class="tf-left">
                                                    <a href="#" class="btn btn-primary btn-md icon-btn-left"><i
                                                            class="ico-user2 me-2 fs-6"></i> Download</a>
                                                </div>
                                                <div class="tf-right">
                                                    <button type="button"
                                                        class="btn btn-light btn-md me-2">Cancel</button>
                                                    <button type="submit" class="btn btn-primary btn-md">Edit
                                                        Form</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" style="color: #0747A6;">Aftercare Lips Dermal Fillers -
                                                (Please take a snap shot)</a></td>
                                        <td><span class="badge text-bg-orange badge-md badge-rounded">In
                                                progress</span></td>
                                        <td class="text-center"><button type="button"
                                                class="btn btn-sm black-btn round-6 dt-delete"> <i
                                                    class="ico-trash"></i> </button></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" style="color: #0747A6;">Informed Consent for Dermal
                                                Fillers</a></td>
                                        <td><span class="badge text-bg-blue badge-md badge-rounded">Submitted</span>
                                        </td>
                                        <td class="text-center"><button type="button"
                                                class="btn btn-sm black-btn round-6 dt-delete"> <i
                                                    class="ico-trash"></i> </button></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" style="color: #0747A6;">NURSE- Injectable Product
                                                Prescription</a></td>
                                        <td><span class="badge text-bg-green badge-md badge-rounded">Complete</span>
                                        </td>
                                        <td class="text-center"><button type="button"
                                                class="btn btn-sm black-btn round-6 dt-delete"> <i
                                                    class="ico-trash"></i> </button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table all-db-table align-middle">
                                <thead>
                                    <tr>
                                        <th class="blue-bold" width="70%" aria-sort="ascending">21 Oct 2022</th>
                                        <th class="blue-bold" width="20%">Status </th>
                                        <th class="blue-bold" width="10%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="#" style="color: #0747A6;">Informed Consent for
                                                Antiwrinkles</a></td>
                                        <td><span class="badge text-bg-blue badge-md badge-rounded">Submitted</span>
                                        </td>
                                        <td class="text-center"><button type="button"
                                                class="btn btn-sm black-btn round-6 dt-delete"> <i
                                                    class="ico-trash"></i> </button></td>
                                    </tr>
                                    <tr>
                                        <td><a href="#" style="color: #0747A6;">After Care Anti Wrinkles</a>
                                        </td>
                                        <td><span class="badge text-bg-seagreen badge-md badge-rounded">New</span></td>
                                        <td class="text-center"><button type="button"
                                                class="btn btn-sm black-btn round-6 dt-delete"> <i
                                                    class="ico-trash"></i> </button></td>
                                    </tr>
                                </tbody>
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
<!-- Modal -->
