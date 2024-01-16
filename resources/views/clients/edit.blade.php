@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="card">

    <div class="card-head">
        <h4 class="small-title mb-0">Client card</h4>
    </div>
    <div class="card-body pb-3">
        <div class="client-invo-notice">
            <div class="inv-left">
                <div class="client-name">
                    <div class="drop-cap" style="background: #D0D0D0; color: #000;">{{ucfirst(substr($client->firstname, 0, 1))}}</div>
                    <div class="client-info">
                        <h4 class="blue-bold">{{$client->firstname.' '.$client->lastname}}</h4>
                        <a href="#" class="river-bed"><b>{{$client->mobile_number}}</b></a><br>
                        <a href="#" class="river-bed"><b>{{$client->email}}</b></a>
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
            <a class="nav-link" data-bs-toggle="tab" href="#tab_3" aria-selected="false" tabindex="-1" role="tab"><i class="ico-photo"></i> Photos<span class="badge badge-circle ms-2">{{count($client_photos)}}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_4" aria-selected="false" tabindex="-1" role="tab"><i class="ico-folder"></i> Documents<span class="badge badge-circle ms-2">{{count($client_documents)}}</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab_5" aria-selected="false" tabindex="-1" role="tab"><i class="ico-appt-reminder"></i> Forms<span class="badge badge-circle ms-2">5</span></a>
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
                        @if(count($client_photos)>0)
                            <div class="gallery client-phbox grid-4">
                            @foreach($client_photos as $photos)
                                <figure>
                                    <a href="{{URL::to('/images/clients_photos/'.$photos->client_photos)}}"><img src="{{URL::to('/images/clients_photos/'.$photos->client_photos)}}" alt=""></a>
                                </figure>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="tab_2" role="tabpanel">
            <div class="card-head pb-4">
                <h5 class="bright-gray mb-0">Client details </h5>
            </div>
            <form id="update_client_detail" name="update_client_detail" class="form">
            @csrf
            <input type="hidden" name="id" id="id" value="{{$client->id}}">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" placeholder="" name="firstname" id="firstname" maxlength="50" value="{{$client->firstname}}">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Last Name </label>
                            <input type="text" class="form-control" placeholder="" name="lastname" id="lastname" maxlength="50" value="{{$client->lastname}}">
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label">Gender</label>
                        <div class="toggle mb-1">
                        <input type="radio" name="gender" value="Male" {{ ($client->gender=="Male")? "checked" : "" }}  id="male" checked="checked" />
                        <label for="male">Male <i class="ico-tick"></i></label>
                        <input type="radio" name="gender" value="Female" {{ ($client->gender=="Female")? "checked" : "" }}  id="female" />
                        <label for="female">Female <i class="ico-tick"></i></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" placeholder="" name="email" maxlength="100" value="{{$client->email}}" disabled>
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control"  name="date_of_birth" id="date_of_birth" value="{{$client->date_of_birth}}">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-4">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="{{$client->mobile_number}}" maxlength="15">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Home Phone</label>
                            <input type="text" class="form-control" name="home_phone" id="home_phone" value="{{$client->home_phone}}">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">Work Phone</label>
                            <input type="text" class="form-control" name="work_phone" id="work_phone" value="{{$client->work_phone}}">
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
                            <select class="form-select form-control" name="contact_method" id="contact_method">
                                <option selected="" value=""> -- select an option -- </option>
                                <option value="Text message (SMS)" {{ ($client->contact_method == "Text message (SMS)")? "selected" : "" }} >Text message (SMS)</option>
                                <option value="Email" {{ ($client->contact_method == "Email")? "selected" : "" }}>Email</option>
                                <option value="Phone call" {{ ($client->contact_method == "Phone call")? "selected" : "" }}>Phone call</option>
                                <option value="Post" {{ ($client->contact_method == "Post")? "selected" : "" }}>Post</option>
                                <option value="No preference" {{ ($client->contact_method == "No preference")? "selected" : "" }}>No preference</option>
                                <option value="Don't send reminders" {{ ($client->contact_method == "Don't send reminders")? "selected" : "" }}>Don't send reminders</option>
                            </select>
                            </div>
                    </div>
                    
                    <div class="col-lg-3">
                        <label class="form-label">Send promotions</label>
                        <div class="toggle mb-0">
                        <input type="radio" name="send_promotions" value="1" {{ ($client->send_promotions=="1")? "checked" : "" }}  id="yes" checked="checked" />
                        <label for="yes">Yes <i class="ico-tick"></i></label>
                        <input type="radio" name="send_promotions" value="0" {{ ($client->send_promotions=="0")? "checked" : "" }}  id="no" />
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
                            <input type="text" class="form-control" id="street_address" name="street_address" value="{{$client->street_address}}">
                            </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">Suburb</label>
                            <input type="text" class="form-control" id="suburb" name="suburb" value="{{$client->suburb}}">
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group mb-0">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{$client->city}}">
                            </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label class="form-label">Post code</label>
                            <input type="text" class="form-control" id="postcode" name="postcode" value="{{$client->postcode}}">
                            </div>
                    </div>
                    <div class="col-lg-12 text-lg-end mt-4">
                        <button type="button" class="btn btn-light me-2" onclick="window.location='{{ url("clients") }}'">Discard</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab_3" role="tabpanel">
            <form id="update_client_photos" name="update_client_photos" class="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="gl-upload">
                        <div class="icon-box">
                            <img src="../img/upload-icon.png" alt="" class="up-icon">
                            <span class="txt-up">Choose a File or drag them here</span>
                            <input type="file" class="filepond form-control" name="filepond" id="client_photos" accept="image/png, image/jpeg" multiple/>
                        </div>
                    </label>
                    <div class="mt-2 d-grey font-13"><em>Photos you add here will be visible to this client in Online Booking.</em></div>
                </div>
                @if(count($client_photos)>0)
                <div class="gallery client-phbox grid-6 gap-2 h-188">
                    @foreach($client_photos as $photos)
                    <figure>
                        <a href="{{URL::to('/images/clients_photos/'.$photos->client_photos)}}" data-fancybox="mygallery"><img src="{{URL::to('/images/clients_photos/'.$photos->client_photos)}}" alt=""></a>
                        <!-- <button type="button" photos ids="{{$photos->id}}"class="btn black-btn round-6 dt-delete remove_image"><i class="ico-trash"></i></button> -->
                    </figure>
                    @endforeach
                </div>
                @endif
            </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab_4" role="tabpanel">
            <form id="update_client_documents" name="update_client_documents" class="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label class="gl-upload">
                        <div class="icon-box">
                            <img src="../img/upload-icon.png" alt="" class="up-icon">
                            <span class="txt-up">Choose a File or drag them here</span>
                            <span class="txt-up" style="opacity: .5;">.xls, Word, PNG, JPG or PDF</span>
                            <input class="form-control" type="file" id="client_documents" name="client_documents" accept="application/pdf, applucation/vnd.ms-excel,application/msword,image/png, image/jpeg" multiple>
                        </div>
                    </label>
                    <div class="mt-2 d-grey font-13"><em>Documents you add here will be visible to this client in Online Booking.</em></div>
                </div>
                @if(count($client_documents)>0)
                <div class="form-group mb-0 docs">
                    @foreach($client_documents as $doc)
                    <a href="#" class="btn tag icon-btn-left skyblue mb-2"><span><i class="ico-pdf me-2 fs-2 align-middle"></i> {{$doc->client_documents}}</span> <span class="file-date">{{date('d F h:i A', strtotime($doc->created_at))}}</span><i class="del ico-trash remove_doc" ids="{{$doc->id}}"></i></a>
                    @endforeach
                </div>
                @endif
            </div>
            </form>
        </div>
        <div class="tab-pane fade" id="tab_5" role="tabpanel">5</div>
        <div class="tab-pane fade" id="tab_6" role="tabpanel">6</div>
    </div>
</div>
@endsection
@section('script')
<script>
        /*
        We want to preview images, so we need to register the Image Preview plugin
        */
        FilePond.registerPlugin(
        
        // encodes the file as base64 data
        FilePondPluginFileEncode,
        
        // validates the size of the file
        FilePondPluginFileValidateSize,
        
        // corrects mobile image orientation
        FilePondPluginImageExifOrientation,
        
        // previews dropped images
        FilePondPluginImagePreview
    );

    // Select the file input and use create() to turn it into a pond
    // FilePond.create(
    //     document.querySelector('input')
    // );

    // const inputElement = document.getElementById('client_photos');
    //     FilePond.create(
    //     document.querySelector('input')
    // );
    const inputElement = document.getElementById('client_photos');
    // FilePond.create(inputElement, {
    // // options here
    // })

    // const inputElement = document.getElementById('client_documents');
    //     FilePond.create(
    //     document.querySelector('input')
    // );
    const inputElement1 = document.getElementById('client_documents');
    // FilePond.create(inputElement1, {
    // // options here
    // })
    var file_cnt=0;
    var doc_cnt=0;
    $(document).ready(function(){
        $(".list-group ul li.dropdown").click(function(){
            $(this).toggleClass("show");
        });
        $(".gallery a").attr("data-fancybox","mygallery");
        $(".gallery a").fancybox();

        $("#update_client_detail").validate({
            rules: {
                firstname: {
                    required: true,
                },
                lastname:{
                    required:true,
                },
                email:{
                    required: true,
                    email: true
                },
                mobile_number:{
                    required: true,
                },
                date_of_birth:{
                    required: true,
                },
                contact_method:{
                    required: true,
                },
                street_address:{
                    required: true,
                },
                suburb:{
                    required: true,
                },
                city:{
                    required: true,
                },
                postcode:{
                    required: true,
                },
            },
        });
        
        $("#client_photos").change(function () {
            debugger;
            var inputElement = document.getElementById('client_photos');
            var data = new FormData();
            var id=$('#id').val();
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];

                reader.onload = (function (file) {
                    return function (e) {
                        var fileName = file.name;
                        var fileContents = e.target.result;
                        $('.client-phbox').append('<input type="hidden" name="hdn_img" value=' + file + '><figure imgname=' + fileName + ' id="remove_image" class="remove_image"><img src=' + fileContents + '></figure>');
                    };
                })(currFile);
                reader.readAsDataURL(this.files[i]);
                data.append('pics[]', currFile);
                data.append('id',id);
            }
            jQuery.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('clients-photos')}}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Client!",
                            text: "Client Photos Updated successfully.",
                            type: "success",
                        }).then((result) => {
                            window.location = "{{url('clients')}}/" + id
                            // window.location = "{{url('clients')}}"//'/player_detail?username=' + name;
                        });
                    } else {
                        debugger;
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                        });
                    }
                }
            });
        });
        $("#client_documents").change(function() {debugger;
            var inputElement = document.getElementById('client_documents');
            var data = new FormData();
            var id=$('#id').val();
            for (var i = 0; i < this.files.length; i++) {
                var reader = new FileReader();
                var files = this.files[i].name;
                var currFile = this.files[i];

                reader.onload = (function (file) {debugger;
                    return function (e) {
                        var d = new Date();
                        const month = d.toLocaleString('default', { month: 'long' });
                        var fulldate = d.getDate()+' '+ month + ' ' + d.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
                        var fileName = file.name;
                        var fileContents = e.target.result;
                        $('.docs').append('<a href="#" class="btn tag icon-btn-left skyblue mb-2"><span><i class="ico-pdf me-2 fs-2 align-middle"></i> ' + fileName + '</span> <span class="file-date">' + fulldate + '</span><i class="del ico-trash"></i></a>');
                        // $('.docs').append('<a href="#" class="btn tag icon-btn-left skyblue remove_doc mb-2"><i class="ico-pdf me-2 fs-2"></i> ' + fileName + ' <i class="del ico-trash"></i></a><figure style="display:none"; imgname='+ fileName +' id="remove_image" class="remove_image"><img src=' + fileContents + '><button type="button" class="btn black-btn round-6 dt-delete"><i class="ico-trash"></i></button></figure>');
                    };
                })(currFile);
                reader.readAsDataURL(this.files[i]);
                data.append('pics[]', currFile);
                data.append('id',id);
            }
            jQuery.ajax({
                headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                url: "{{route('clients-documents')}}",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST', // For jQuery < 1.9
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Client!",
                            text: "Client Documents Updated successfully.",
                            type: "success",
                        }).then((result) => {
                            window.location = "{{url('clients')}}/" + id
                            // window.location = "{{url('clients')}}"//'/player_detail?username=' + name;
                        });
                    } else {
                        debugger;
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            type: "error",
                        });
                    }
                }
            });
        });
        
    });
    $(document).on('submit','#update_client_detail',function(e){debugger;
		e.preventDefault();
        var id=$('#id').val();
		var valid= $("#update_client_detail").validate();
			if(valid.errorList.length == 0){
                var data = $('#update_client_detail').serialize() ;
            // var data = new FormData(this);
            // $.each($('.client-phbox').find('img'),function(index){
            //     debugger;
            //     var photos_img = $('.client-phbox').find('img')[index].src;
            //     data.append('pics[]', photos_img);
            // });
            // $.each($('.file-hoder').find('a'),function(index){
            //     debugger;
            //     var docs_imgs = $('.file-hoder').find('img')[index].src;
            //     data.append('docs[]', docs_imgs);
            // });
			SubmitUpdateClientDetails(data,id);
		}
	});
    $(document).on('click', '.remove_image', function (e) {debugger;
        e.preventDefault();
        $(this).parent().remove();
        var data = new FormData();
        var id = $('#id').val();
        var photo_id = $(this).attr('ids');
        data.append('id',id);
        data.append('photo_id',photo_id);
        jQuery.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{route('clients-photos-remove')}}",
            data: data,
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            data: data,
            contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
            processData: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: "Client!",
                        text: "Client Photo Deleted successfully.",
                        type: "success",
                    }).then((result) => {
                        window.location = "{{url('clients')}}/" + id
                    });
                } else {
                    debugger;
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        type: "error",
                    });
                }
            }
        });
    });
    $(document).on('click', '.remove_doc', function (e) {debugger;
        e.preventDefault();
        $(this).parent().remove();
        var data = new FormData();
        var id = $('#id').val();
        var doc_id = $(this).attr('ids');
        data.append('id',id);
        data.append('doc_id',doc_id);
        jQuery.ajax({
            headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: "{{route('clients-documents-remove')}}",
            data: data,
            method: 'POST',
            type: 'POST', // For jQuery < 1.9
            data: data,
            contentType: false, // The content type used when sending data to the server. Default is: "application/x-www-form-urlencoded"
            processData: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: "Client!",
                        text: "Client Documents Deleted successfully.",
                        type: "success",
                    }).then((result) => {
                        window.location = "{{url('clients')}}/" + id
                        // window.location = "{{url('clients')}}/" + id
                    });
                } else {
                    debugger;
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        type: "error",
                    });
                }
            }
        });
    });
    function SubmitUpdateClientDetails(data,id){
		$.ajax({
			headers: { 'Accept': "application/json", 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			url: id,
			type: "PUT",
			data: data,
            success: function(response) {
				debugger;
				// Show a Sweet Alert message after the form is submitted.
				if (response.success) {
					
					Swal.fire({
						title: "Client!",
						text: "Client Updated successfully.",
						type: "success",
					}).then((result) => {
                        window.location = "{{url('clients')}}/" + id
                        // window.location = "{{url('clients')}}"//'/player_detail?username=' + name;
                    });
					
				} else {
					debugger;
					Swal.fire({
						title: "Error!",
						text: response.message,
						type: "error",
					});
				}
			},
		});
	}
</script>
@endsection