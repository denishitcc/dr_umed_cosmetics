@extends('layouts.sidebar')
@section('title', 'Forms')
@section('content')
<div class="card">
    <div class="card-head">
        <h4 class="small-title mb-5">Edit Forms</h4>
    </div>
    <link rel="stylesheet" href="{{ asset('js/formiojs/dist/formio.full.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/@formio/contrib/dist/formio-contrib.css') }}">

    <div class="card-body">
        <div class="row">
            <div>
                Form title<br>
                <label>{{ $forms->title }}</label>
                @if ($forms->status == 0)
                    <span class="badge text-bg-grey badge-md">Draft</span>
                @else
                    <span class="badge text-bg-green badge-md">Live</span><br>
                @endif
                <hr>
            </div>
            <div class="tool-right">
                <label data-form_json="{{ $forms->form_json }}" id="formxml"></label>
                <div class="tool-right">
                    <a href="#" class="btn btn-primary btn-md" id="formOptionsBtn" data-bs-toggle="modal" data-bs-target="#edit_form">Options</a>
                    <a href="javascript:void(0)" class="btn btn-primary btn-md deleteFormBtn" id="deleteFormBtn" data-formid="{{ $forms->id }}">Delete</a>
                    <a href="{{ route('serviceforms.formPreview', $forms->id )}}" target="_blank" class="btn btn-primary btn-md">Preview</a>
                </div>
            </div>
        </div>
        <br><br>
        <div id="form-editor"></div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="edit_form" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Form options</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="create_forms" name="create_forms" class="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" value="{{ $forms->title }}">
                        <input type="hidden" name="form_id" value="{{ $forms->id }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" name="description">{{ $forms->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="row align-items-center">
                            <div class="col-lg-7">
                                <label class="form-label">Available for use</label>
                                <div class="toggle">
                                    <input type="radio" id="yes" class="status" name="status" value="1"  {{ ($forms->status == "1" ) ? "checked" : "" }}>
                                    <label for="yes">Yes <i class="ico-tick"></i></label>
                                    <input type="radio" id="no" class="status" name="status" value="0"  {{ ($forms->status == "0" ) ? "checked" : "" }}>
                                    <label for="no">No <i class="ico-tick"></i></label>
                                </div>
                            </div>
                            <div class="col-lg-2 form_live" style="display:none;">
                                <label class="form-label d-block">&nbsp;</label>
                                <span class="badge text-bg-green badge-md">Live</span>
                            </div>
                            <div class="col-lg-2 form_draft" style="display:none;">
                                <label class="form-label d-block">&nbsp;</label>
                                <span class="badge text-bg-grey badge-md">Draft</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-light invo-notice">
                        <em class="d-grey font-13">This form can now be added to client appointments by selecting the Forms button to the left of the Dr. Umed Portal appointment book.</em>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateFormbtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/@formio/js/dist/formio.form.min.js') }}"></script>
<script src="{{ asset('js/formiojs/dist/formio.full.min.js') }}"></script>
<script src="{{ asset('js/@formio/js/dist/formio.full.js') }}"></script>
<script src="{{ asset('js/section_break.js') }}"></script>
<script src="{{ asset('js/form.js') }}"></script>
<script src="{{ asset('js/index.js') }}"></script>
<script type="text/javascript">
    var moduleConfig = {
        updateForm:             "{!! route('serviceforms.formUpdate') !!}",
        updateHTMLFormContent:  "{!! route('serviceforms.formHTMLUpdate') !!}",
        deleteForm:             "{!! route('serviceforms.formDelete') !!}",
    }
    DU.form.init();
</script>
@endsection