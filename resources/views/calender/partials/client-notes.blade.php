<div id="ClientNotesData">
    <h4 class="d-grey mb-4">Notes</h4>
    <div class="yellow-note-box common_notes">
        <strong class="form-label d-block">Booking Notes:</strong>
        @if ($appointmentNotes)
        <div class="viewnotes">
            <p>
                {{ $appointmentNotes->common_notes }}
            </p>
            <div class="add-note-btn-box">
                <button type="button" class="btn btn-primary font-13 alter" id="edit_common_notes">Edit Notes </button>
            </div>
        </div>
        @endif
        <div class="common d-none">
            <form method="post" >
                @if($appointmentNotes)
                    <input type="hidden" name="appointment_id" value="{{ $appointmentNotes->appointment_id }}" >
                    <div class="mb-3">
                        <textarea name="common_notes" id="common_notes" cols="80" rows="5" class="form-control" > {{ $appointmentNotes->common_notes }} </textarea>
                    </div>
                @else
                    <input type="hidden" name="appointment_id" >
                    <div class="mb-3">
                        <textarea name="common_notes" id="common_notes" cols="80" rows="5" class="form-control" > </textarea>
                    </div>
                @endif
                <div class="add-note-btn-box">
                    <button type="button" class="btn btn-primary font-13 me-2" id="add_common_notes">Add Booking Notes </button>
                </div>
            </form>
        </div>
    </div>
    <div class="yellow-note-box treatment_notes">
        <strong class="form-label d-block">Treatment Notes:</strong>
        @if ($appointmentNotes)
            <div class="treatmentviewnotes">
                <p>
                    {{ $appointmentNotes->treatment_notes }}
                </p>
                <div class="add-note-btn-box">
                    <button type="button" class="btn btn-primary font-13 alter" id="edit_treatment_notes">Edit Notes </button>
                </div>
            </div>
        @endif
        <div class="treatment_common d-none">
            <form method="post">
                @if($appointmentNotes)
                    <input type="hidden" name="appointment_id" value="{{ $appointmentNotes->appointment_id }}">
                    <div class="mb-3">
                        <textarea name="treatment_notes" id="treatment_notes" cols="80" rows="5" class="form-control">  {{ $appointmentNotes->treatment_notes }}  </textarea>
                    </div>
                @else
                    <input type="hidden" name="appointment_id" >
                    <div class="mb-3">
                        <textarea name="treatment_notes" id="treatment_notes" cols="80" rows="5" class="form-control" > </textarea>
                    </div>
                @endif
            </form>
            <div class="add-note-btn-box">
                <button type="button" class="btn btn-primary font-13 me-2" id="submit_treatment_notes">Add Notes </button>
            </div>
        </div>
    </div>
    <h4 class="d-grey mb-3 mt-5">Photos</h4>
    @if ($clientPhotos->count())
        <div class="gallery client-phbox grid-4 history">
            @foreach ($clientPhotos as $photos)
                <figure>
                    <a href="{{ $photos->photourl }}" data-fancybox="mygallery">
                        <img src="{{ $photos->photourl }}" alt="{{ $photos->client_photos }}">
                    </a>
                </figure>
            @endforeach
        </div>
    @endif
</div>
