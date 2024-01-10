@extends('layouts/sidebar')
@section('content')
<div class="card">

    <div class="card-head">
        <h4 class="small-title mb-0">Client card</h4>
    </div>
    <div class="card-body pb-3">
        <div class="client-invo-notice">
            <div class="inv-left">
                <div class="client-name">
                    <div class="drop-cap" style="background: #D0D0D0; color: #000;">A</div>
                    <div class="client-info">
                        <h4 class="blue-bold">Alana Ahfoc</h4>
                        <a href="#" class="river-bed"><b>0404 061 182</b></a><br>
                        <a href="#" class="river-bed"><b>alanaframe@hotmail.com</b></a>
                    </div>
                </div>
            </div>
            <div class="inv-center">
                <div class="d-grey">Last appt at Sunshine Coast on 31 Dec 21 <br>
                    3 Area Anti Wrinkle Package with Nurse<br>
                    Lynn (Completed)</div>
            </div>
            <div class="inv-right">
                <a href="#" class="btn btn-primary btn-md icon-btn-left"><i class="ico-user2 me-2 fs-6"></i> Give to Alana to Update Details</a>
            </div>
        </div>
    </div>

    <ul class="nav brand-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab_1" aria-selected="true" role="tab"><i class="ico-clipboard-text"></i> Client History</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_2" aria-selected="false" tabindex="-1" role="tab"><i class="ico-task"></i> Client Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_3" aria-selected="false" tabindex="-1" role="tab"><i class="ico-photo"></i> Photos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_4" aria-selected="false" tabindex="-1" role="tab"><i class="ico-folder"></i> Documents</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_5" aria-selected="false" tabindex="-1" role="tab"><i class="ico-appt-reminder"></i> Forms</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_6" aria-selected="false" tabindex="-1" role="tab"><i class="ico-payment-gateway"></i> Messages</a>
        </li>
    </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab_1" role="tabpanel">
                <div class="card-body">
                    <div class="scaffold-layout-outr">
                    <div class="scaffold-layout-list-details">
                        <div class="scaffold-layout-list">
                            <h6 class="fiord mb-5">This client has no upcoming appointments.</h6>
                            <ul class="scaffold-layout-list-container">
                                <li class="scaffold-layout-list-item">
                                    <div class="appt-timeplace">
                                        Today<br>12:00pm @<br> Hope Island<br> (Booked)
                                    </div>
                                    <div class="appt-details">
                                        <div class="his-detaiils">
                                            <h5 class="black">3 Area Anti Wrinkle Package</h5>
                                            <p>30m with Nurse Vish<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i class="ico-file-text me-2 fs-4 align-middle"></i> 0 Notes</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="scaffold-layout-list-item active">
                                    <div class="appt-timeplace">
                                        Today<br>12:00pm @<br> Hope Island<br> (Booked)
                                    </div>
                                    <div class="appt-details">
                                        <a href="#" class="btn btn-primary btn-sm pointer"><i class="ico-right-arrow fs-4"></i></a>
                                        <div class="his-detaiils">
                                            <h5 class="black">Client Consultation</h5>
                                            <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                        </div>
                                        <div class="his-detaiils">
                                            <h5 class="black">Anti-Wrinkle - Dysport</h5>
                                            <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <span class="badge badge-black my-2">Total: $400.00</span><br>
                                            <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i class="ico-file-text me-2 fs-4 align-middle"></i> 2 Notes</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="scaffold-layout-list-item">
                                    <div class="appt-timeplace">
                                        Fri 18 Mar 2022<br> 2:15pm @<br> Hope Island<br> (Completed)
                                    </div>
                                    <div class="appt-details">
                                        <div class="his-detaiils">
                                            <h5 class="black">Cosmetic Consultation</h5>
                                            <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <div class="add-note-btn-box">
                                                <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                                <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="scaffold-layout-list-item">
                                    <div class="appt-timeplace">
                                        Mon 31 Jan 2022<br> 10:00am @<br> Hope Island<br> (Completed)
                                    </div>
                                    <div class="appt-details">
                                        <div class="his-detaiils">
                                            <h5 class="black">Anti-Wrinkle - Dysport</h5>
                                            <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <div class="add-note-btn-box">
                                                <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="scaffold-layout-list-item">
                                    <div class="appt-timeplace">
                                        Mon 28 Feb 2022<br> 8:00am @<br> Hope Island<br> (Completed)
                                    </div>
                                    <div class="appt-details">
                                        <div class="his-detaiils">
                                            <h5 class="black">HIFU Full Face</h5>
                                            <p>15m with Jen Taylor<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <div class="add-note-btn-box">
                                                <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                                <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="scaffold-layout-list-item">
                                    <div class="appt-timeplace">
                                        Fri 18 Mar 2022<br> 2:15pm @<br> Hope Island<br> (Completed)
                                    </div>
                                    <div class="appt-details">
                                        <div class="his-detaiils">
                                            <h5 class="black">Cosmetic Consultation</h5>
                                            <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <div class="add-note-btn-box">
                                                <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                                <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="scaffold-layout-list-item">
                                    <div class="appt-timeplace">
                                        Mon 31 Jan 2022<br> 10:00am @<br> Hope Island<br> (Completed)
                                    </div>
                                    <div class="appt-details">
                                        <div class="his-detaiils">
                                            <h5 class="black">Anti-Wrinkle - Dysport</h5>
                                            <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <div class="add-note-btn-box">
                                                <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="scaffold-layout-list-item">
                                    <div class="appt-timeplace">
                                        Mon 28 Feb 2022<br> 8:00am @<br> Hope Island<br> (Completed)
                                    </div>
                                    <div class="appt-details">
                                        <div class="his-detaiils">
                                            <h5 class="black">HIFU Full Face</h5>
                                            <p>15m with Jen Taylor<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <div class="add-note-btn-box">
                                                <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                                <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="scaffold-layout-list-item">
                                    <div class="appt-timeplace">
                                        Today<br>12:00pm @<br> Hope Island<br> (Booked)
                                    </div>
                                    <div class="appt-details">
                                        <div class="his-detaiils">
                                            <h5 class="black">3 Area Anti Wrinkle Package</h5>
                                            <p>30m with Nurse Vish<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i class="ico-file-text me-2 fs-4 align-middle"></i> 0 Notes</a>
                                        </div>
                                        <div class="his-detaiils">
                                            <h5 class="black">HIFU Full Face</h5>
                                            <p>15m with Jen Taylor<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <div class="add-note-btn-box">
                                                <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                                <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                            </div>
                                        </div>
                                        <div class="his-detaiils">
                                            <h5 class="black">HIFU Full Face</h5>
                                            <p>15m with Jen Taylor<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <div class="add-note-btn-box">
                                                <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                                <a href="#" class="btn btn-primary font-13 alter"> Add treatment notes </a>
                                            </div>
                                        </div>
                                        <div class="his-detaiils">
                                            <h5 class="black">Anti-Wrinkle - Dysport</h5>
                                            <p>15m with Dr Umed (Hope Island) Shekhawat<br>
                                            <span class="font-13">(Uninvoiced) : $0.00</span></p>
                                            <span class="badge badge-black my-2">Total: $400.00</span><br>
                                            <a href="#" class="badge badge-alter badge-icon badge-note my-2"><i class="ico-file-text me-2 fs-4 align-middle"></i> 2 Notes</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="scaffold-layout-detail">
                            <h4 class="d-grey mb-4">Notes</h4>
                            <div class="yellow-note-box">
                                <p> <strong>Common Notes:</strong><br> Form incomplete. 400 (paid together with Moey $1150 eft).</p>
                                <div class="add-note-btn-box">
                                <a href="#" class="btn btn-primary font-13 alter"> Edit Notes</a>
                            </div>
                            </div>
                            <div class="yellow-note-box">
                                <p>
                                <strong>Treatment Notes:</strong><br>
                                    Client presented to clinic for cheek filler. Cheek Filler: <br><br>

                                    Juvederm Voluma 2mls used. Treated ck1 and ck2 with 0.5mls on each side. And 1ml used to treat preauricular area. 0.5mls on each side using canulla.<br><br>

                                    Has had dermal filler in the past and had no complications from the treatment<br>
                                    -Allergies: Nil Known<br>
                                    -Medical conditions:<br>
                                    -Medications: Not taking any<br>
                                    Not pregnant and not breastfeeding<br>
                                    -Medical conditions:<br>
                                    -Medications: Not taking any
                                </p>
                                    <div class="add-note-btn-box">
                                        <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
                                        <a href="#" class="btn btn-primary font-13 alter"> Edit Notes</a>
                                    </div>
                            </div>
                            <h4 class="d-grey mb-3 mt-5">Photos</h4>
                            <div class="gallery client-phbox grid-4">
                                <figure>
                                    <a href="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg"><img src="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg" alt=""></a>
                                </figure>
                            
                                <figure>
                                    <a href="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg"><img src="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg" alt=""></a></figure>

                                <figure>
                                    <a href="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&resize=640:*"><img src="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&resize=640:*" alt=""></a></figure>
                                
                                <figure>
                                    <a class="col" href="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/"><img src="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/" alt=""></a>
                                </figure>
                            <figure>
                                <a href="https://introlift.com/wp-content/uploads/non-surgical.jpg"><img src="https://introlift.com/wp-content/uploads/non-surgical.jpg" alt=""></a>
                            </figure>
                            <figure>
                            <a href="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg"><img src="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg" alt=""></a>
                            </figure>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab_2" role="tabpanel">
                <div class="card-head pb-4">
                    <h5 class="bright-gray mb-0">Client details </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" placeholder="Alana">
                                </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Last Name </label>
                                <input type="text" class="form-control" placeholder="Ahfoc">
                                </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Gender</label>
                            <div class="toggle mb-1">
                                <input type="radio" name="gender" value="" id="male" checked="checked" />
                                <label for="male">Male <i class="ico-tick"></i></label>
                                <input type="radio" name="gender" value="" id="female" />
                                <label for="female">Female <i class="ico-tick"></i></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" placeholder="Alnoteszeina_aouli@live.com.au">
                                </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control">
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Primary Number</label>
                                <input type="text" class="form-control" placeholder="0451 100 228">
                                </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Alternate Number</label>
                                <input type="text" class="form-control">
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-0">
                                <label class="form-label">Home Phone</label>
                                <input type="text" class="form-control">
                                </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group mb-0">
                                <label class="form-label">Work Phone</label>
                                <input type="text" class="form-control">
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
                                <select class="form-select form-control">
                                    <option>No Preference</option>
                                    <option>Option 1</option>
                                </select>
                                </div>
                        </div>
                        
                        <div class="col-lg-3">
                            <label class="form-label">Send promotions</label>
                            <div class="toggle mb-0">
                                <input type="radio" name="Send_promotions" value="" id="yes" checked="checked">
                                <label for="yes">Yes <i class="ico-tick"></i></label>
                                <input type="radio" name="Send_promotions" value="" id="no">
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
                                <input type="text" class="form-control">
                                </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-label">Suburb</label>
                                <input type="text" class="form-control">
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group mb-0">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control">
                                </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group mb-0">
                                <label class="form-label">Post code</label>
                                <input type="text" class="form-control">
                                </div>
                        </div>
                        <div class="col-lg-12 text-lg-end mt-4">
                            <button type="button" class="btn btn-light me-2">Discard</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab_3" role="tabpanel">
                <div class="card-body">
                    <div class="form-group">
                        <label class="gl-upload">
                            <div class="icon-box">
                                <img src="img/upload-icon.png" alt="" class="up-icon">
                                <span class="txt-up">Choose a File or drag them here</span>
                                <input class="form-control" type="file" id="imgInput" name="banner_image" accept="image/png, image/gif, image/jpeg">
                            </div>
                        </label>
                        <div class="mt-2 d-grey font-13"><em>Photos you add here will be visible to this client in Online Booking.</em></div>
                    </div>
                    <div class="gallery client-phbox grid-6 gap-2 h-188">
                        <figure>
                            <a href="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg" data-fancybox="mygallery"><img src="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg" alt=""></a>
                        </figure>
                    
                        <figure>
                            <a href="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg" data-fancybox="mygallery"><img src="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg" alt=""></a></figure>

                        <figure>
                            <a href="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&amp;resize=640:*" data-fancybox="mygallery"><img src="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&amp;resize=640:*" alt=""></a></figure>
                        
                        <figure>
                            <a class="col" href="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/" data-fancybox="mygallery"><img src="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/" alt=""></a>
                        </figure>
                        <figure>
                            <a href="https://introlift.com/wp-content/uploads/non-surgical.jpg" data-fancybox="mygallery"><img src="https://introlift.com/wp-content/uploads/non-surgical.jpg" alt=""></a>
                        </figure>
                        <figure>
                        <a href="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg" data-fancybox="mygallery"><img src="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg" alt=""></a>
                        </figure>
                        <figure>
                            <a href="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg" data-fancybox="mygallery"><img src="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg" alt=""></a>
                        </figure>
                    
                        <figure>
                            <a href="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg" data-fancybox="mygallery"><img src="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg" alt=""></a></figure>

                        <figure>
                            <a href="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&amp;resize=640:*" data-fancybox="mygallery"><img src="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&amp;resize=640:*" alt=""></a></figure>
                        
                        <figure>
                            <a class="col" href="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/" data-fancybox="mygallery"><img src="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/" alt=""></a>
                        </figure>
                        <figure>
                            <a href="https://introlift.com/wp-content/uploads/non-surgical.jpg" data-fancybox="mygallery"><img src="https://introlift.com/wp-content/uploads/non-surgical.jpg" alt=""></a>
                        </figure>
                        <figure>
                        <a href="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg" data-fancybox="mygallery"><img src="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg" alt=""></a>
                        </figure>
                        <figure>
                            <a href="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg" data-fancybox="mygallery"><img src="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg" alt=""></a>
                        </figure>
                    
                        <figure>
                            <a href="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg" data-fancybox="mygallery"><img src="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg" alt=""></a></figure>

                        <figure>
                            <a href="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&amp;resize=640:*" data-fancybox="mygallery"><img src="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&amp;resize=640:*" alt=""></a></figure>
                        
                        <figure>
                            <a class="col" href="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/" data-fancybox="mygallery"><img src="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/" alt=""></a>
                        </figure>
                        <figure>
                            <a href="https://introlift.com/wp-content/uploads/non-surgical.jpg" data-fancybox="mygallery"><img src="https://introlift.com/wp-content/uploads/non-surgical.jpg" alt=""></a>
                        </figure>
                        <figure>
                        <a href="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg" data-fancybox="mygallery"><img src="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg" alt=""></a>
                        </figure>
                        <figure>
                            <a href="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg" data-fancybox="mygallery"><img src="https://www.realself.com/news/wp-content/uploads/2021/09/RS_Biggest-Bang-for-Your-Buck-Treatments.jpg" alt=""></a>
                        </figure>
                    
                        <figure>
                            <a href="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg" data-fancybox="mygallery"><img src="https://dragarwalsclinic.com/wp-content/uploads/2020/04/Cosmetic-Skin-Treatments.jpg" alt=""></a></figure>

                        <figure>
                            <a href="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&amp;resize=640:*" data-fancybox="mygallery"><img src="https://hips.hearstapps.com/hmg-prod/images/professional-female-cosmetologist-doing-hydrafacial-royalty-free-image-1682540818.jpg?crop=0.668xw:1.00xh;0.0816xw,0&amp;resize=640:*" alt=""></a></figure>
                        
                        <figure>
                            <a class="col" href="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/" data-fancybox="mygallery"><img src="https://ucarecdn.com/a719a842-79ff-447d-875b-c7ba49f89183/-/format/auto/-/preview/3000x3000/-/quality/lighter/" alt=""></a>
                        </figure>
                    <figure>
                        <a href="https://introlift.com/wp-content/uploads/non-surgical.jpg" data-fancybox="mygallery"><img src="https://introlift.com/wp-content/uploads/non-surgical.jpg" alt=""></a>
                    </figure>
                    <figure>
                    <a href="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg" data-fancybox="mygallery"><img src="https://i.pinimg.com/736x/cd/96/87/cd9687a032de5724b869feb8cb3722ab.jpg" alt=""></a>
                    </figure>
                </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab_4" role="tabpanel">
                <div class="card-body">
                    <div class="form-group">
                        <label class="gl-upload">
                            <div class="icon-box">
                                <img src="img/upload-icon.png" alt="" class="up-icon">
                                <span class="txt-up">Choose a File or drag them here</span>
                                <span class="txt-up" style="opacity: .5;">.xls, Word, PNG, JPG or PDF (max. 5MB Upload)</span>
                                <input class="form-control" type="file" id="imgInput" name="banner_image" accept="image/png, image/gif, image/jpeg">
                            </div>
                        </label>
                        <div class="mt-2 d-grey font-13"><em>Documents you add here will be visible to this client in Online Booking.</em></div>
                    </div>
                    <div class="form-group mb-0">
                        <a href="#" class="btn tag icon-btn-left skyblue mb-2"><span><i class="ico-pdf me-2 fs-2 align-middle"></i> Alana_Invoice.pdf</span> <span class="file-date">6 October 8.15 AM</span><i class="del ico-trash"></i></a>
                        <a href="#" class="btn tag icon-btn-left skyblue mb-2"><i class="ico-png me-2 fs-2 align-middle"></i> Alana_treatment.png <span class="file-date">6 October 8.15 AM</span><i class="del ico-trash"></i></a>
                        <a href="#" class="btn tag icon-btn-left skyblue mb-2"><i class="ico-pdf me-2 fs-2 align-middle"></i> Alana_Invoice.pdf <span class="file-date">6 October 8.15 AM</span><i class="del ico-trash"></i></a>
                        <a href="#" class="btn tag icon-btn-left skyblue mb-2"><i class="ico-pdf me-2 fs-2 align-middle"></i> Alana_Invoice.pdf <span class="file-date">6 October 8.15 AM</span><i class="del ico-trash"></i></a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab_5" role="tabpanel">5</div>
            <div class="tab-pane fade" id="tab_6" role="tabpanel">6</div>
        </div>
</div>
@stop
@section('script')
<script>
    $(document).ready(function(){
        $(".list-group ul li.dropdown").click(function(){
            $(this).toggleClass("show");
        });
        $(".gallery a").attr("data-fancybox","mygallery");
        $(".gallery a").fancybox();
    });
@endsection