<div id="ClientNotesData">
    <h4 class="d-grey mb-4">Notes</h4>
    <div class="yellow-note-box common_notes">
        <strong>Common Notes:</strong>
        @if (isset($client->last_appointment->notes))
            <p> <br>
                {{ $client->last_appointment->notes->common_notes }}
            </p>
            <div class="add-note-btn-box">
                <a href="#" class="btn btn-primary font-13 alter"> Edit Notes</a>
            </div>
        @else
            <form method="post">
                <input type="text" name="common_notes" >
            </form>
            <div class="add-note-btn-box">
                <br>
                <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
            </div>
        @endif
    </div>
    <div class="yellow-note-box">
        <strong>Treatment Notes:</strong><br>
        @if (isset($client->last_appointment->notes))
        <p>
            {{ $client->last_appointment->notes->treatment_notes }}
        </p>
        <div class="add-note-btn-box">
            {{-- <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a> --}}
            <a href="#" class="btn btn-primary font-13 alter"> Edit
                Notes</a>
        </div>
        @else
            <form method="post">
                <input type="text" name="treatment_notes" >
            </form>
            <div class="add-note-btn-box">
                <br>
                <a href="#" class="btn btn-primary font-13 me-2">Add Notes</a>
            </div>
        @endif
    </div>
    <h4 class="d-grey mb-3 mt-5">Photos</h4>
    <div class="gallery client-phbox grid-4">
    </div>
</div>
