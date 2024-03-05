<div id="ClientNotesData">
    <h4 class="d-grey mb-4">Notes</h4>
    <div class="yellow-note-box common_notes">
        <strong>Common Notes:</strong>
        @if (isset($appointmentNotes))
        <div class="viewnotes">
            <p> <br>
                {{ $appointmentNotes->common_notes }}
            </p>
            <div class="add-note-btn-box">
                <button type="button" class="btn btn-primary font-13 alter" id="edit_common_notes">Edit Notes </button>
            </div>
        </div>
        @endif
        <div class="common d-none">
            <form method="post" >
                @if(isset($appointmentNotes))
                    <input type="hidden" name="appointment_id" value="{{ $appointmentNotes->appointment_id }}" >
                    <textarea name="common_notes" id="common_notes" cols="80" rows="5" class="form=control" > {{ $appointmentNotes->common_notes }} </textarea>
                @else
                    <input type="hidden" name="appointment_id" >
                    <textarea name="common_notes" id="common_notes" cols="80" rows="5" class="form=control" > </textarea>
                @endif
                <div class="add-note-btn-box">
                    <br>
                    <button type="button" class="btn btn-primary font-13 me-2" id="add_common_notes">Add Notes </button>
                </div>
            </form>
        </div>
    </div>
    <div class="yellow-note-box treatment_notes">
        <strong>Treatment Notes:</strong><br>
        @if (isset($appointmentNotes))
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
                @if(isset($appointmentNotes))
                    <input type="hidden" name="appointment_id" value="{{ $appointmentNotes->appointment_id }}">
                    <textarea name="treatment_notes" id="treatment_notes" cols="80" rows="5" class="form=control">  {{ $appointmentNotes->treatment_notes }}  </textarea>
                @else
                    <input type="hidden" name="appointment_id" >
                    <textarea name="treatment_notes" id="treatment_notes" cols="80" rows="5" class="form=control" > </textarea>
                @endif
            </form>
            <div class="add-note-btn-box">
                <br>
                <button type="button" class="btn btn-primary font-13 me-2" id="submit_treatment_notes">Add Notes </button>
            </div>
        </div>
    </div>
    <h4 class="d-grey mb-3 mt-5">Photos</h4>
    @if ($clientPhotos->count())
        <div class="gallery client-phbox grid-4">
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
