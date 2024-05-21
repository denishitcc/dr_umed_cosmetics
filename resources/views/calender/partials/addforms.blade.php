@if ($forms->count())
    @foreach ($forms as $form)
        <li class="list-group-item">
            <label class="cst-check d-flex align-items-center">
                <input type="checkbox" name="forms_check" value="{{ $form->id }}">
                {{-- <input type="hidden" name="apptid" id="apptid"> --}}
                <span class="checkmark me-2"></span> {{ $form->title }}
            </label>
        </li>
    @endforeach
@endif
