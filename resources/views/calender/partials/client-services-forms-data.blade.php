<div class="table-card-body">
                    <h5> {{ $clientforms->forms->title }} </h5>
                </div>
                <div class="table-card-body">
                    <div class="d-flex mb-4">
                        <a href="#" class="btn btn-light-grey50 btn-md icon-btn-left">
                            <i class="ico-user2 me-2 fs-6"></i> Give to {{ $clientforms->appointment->clients->firstname }} to Update Details</a>
                    </div>
                    @if ($clientforms->status == \App\Models\AppointmentForms::COMPLETED)
                        <div class="alert alert-green alert-xs">
                            This form is read-only because it's been completed.
                            <a href="#" class="alert-close"><i class="ico-close"></i></a>
                        </div>
                    @endif

                    <label data-form_user_data="{{ $clientforms->form_user_data }}" id="client_form_data"></label>
                    <div id="fb-editor"></div>
                    {{-- <p>Dr Umed Shekhawat<br>
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
                        below.
                    </p>

                    <div class="white-layer">
                        <label class="form-label"><b>I understand the above</b>
                        </label><br>
                        <label class="cst-radio"><input type="radio" checked="" name="form1"><span
                                class="checkmark me-2"></span>Yes</label>
                    </div>

                    <div class="white-layer">
                        <label class="form-label"><b>Alternatives to injections include no
                                treatment, skin care, laser resurfacing, chemical peels,
                                facelifts and other surgical therapies, and other
                                modalities.
                            </b> </label><br>
                        <label class="cst-radio"><input type="radio" checked="" name="form2"><span
                                class="checkmark me-2"></span>Yes</label>
                    </div>

                    <div class="white-layer">
                        <label class="form-label"><b>I understand the above </b>
                        </label><br>
                        <label class="cst-radio"><input type="radio" checked="" name="form3"><span
                                class="checkmark me-2"></span>Yes</label>
                    </div>

                    <div class="white-layer">
                        <label class="form-label"><b>Risks. Every procedure (surgical or
                                non-surgical) involves risks that can only be completely
                                avoided by foregoing treatment. Determining whether or not a
                                procedure is right for you depends on your evaluation of the
                                risks, benefits, goals, alternatives, and recovery
                                associated with the procedures.</b> </label><br>
                        <label class="cst-radio"><input type="radio" checked="" name="form4"><span
                                class="checkmark me-2"></span>I
                            understand</label>
                    </div>

                    <div class="white-layer">
                        <label class="form-label"><b>Bumpiness (nodularity). Patients often
                                feel some bumpiness, firmness, or tightness under the skin
                                at the site of filler injections. Usually, this is not
                                visible and resolves in 1 -2 weeks.</b> </label><br>
                        <label class="cst-radio"><input type="radio" checked="" name="form5"><span
                                class="checkmark me-2"></span>I
                            understand</label>
                    </div>

                    <div class="white-layer">
                        <label class="form-label"><b>Bumpiness (nodularity). Patients often
                                feel some bumpiness, firmness, or tightness under the skin
                                at the site of filler injections. Usually, this is not
                                visible and resolves in 1 -2 weeks. </b> </label><br>
                        <label class="cst-radio me-3"><input type="radio" checked="" name="form6"><span
                                class="checkmark me-2"></span>Yes</label>
                        <label class="cst-radio"><input type="radio" checked="" name="form6"><span
                                class="checkmark me-2"></span>No</label>
                    </div>

                    <p>By signing this document, I have read and understand the information
                        provided in this waiver and grant permission for my treatment.</p>

                    <div class="mb-4"><img src="img/demo-signature.png" alt="">
                    </div> --}}

                    {{-- <label>9:43 am 22 Sep 2023</label><br><br>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <input type="date" class="form-control">
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="table-card-footer">
                    <div class="tf-left">
                        <a href="#" class="btn btn-primary btn-md icon-btn-left"><i
                                class="ico-user2 me-2 fs-6"></i>
                            Download</a>
                    </div>
                    <div class="tf-right">
                        <button type="button" class="btn btn-light btn-md me-2" data-bs-dismiss="modal">Cancel</button>
                        @if ($clientforms->status == \App\Models\AppointmentForms::COMPLETED)
                            <button type="submit" class="btn btn-primary btn-md">Edit Form</button>
                        @else
                            <button type="submit" class="btn btn-primary btn-md" id="form_complete">Complete</button>
                        @endif
                    </div>
                </div>