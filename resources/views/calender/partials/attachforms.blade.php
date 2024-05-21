<tr>
    <td>
        <input type="checkbox" name="forms_check">
    </td>
    <td>Update client card<br>
        <span class="font-13 d-grey">Ask Dane to review and update their contact details</span>
    </td>
    <td></td>
    <td class="text-center"></td>
</tr>
<input type="hidden" name="client_name" id="client_name">
<input type="hidden" name="location_name" id="location_name">
<input type="hidden" name="apptid" id="apptid">
@if ($forms->count())
    @foreach ($forms as $form)
        <tr>
            <td>
                <input type="checkbox" name="forms_check[]" value="{{ $form->form_id }}">
            </td>
            <td class="blue">{{ $form->forms->title }}</td>
            <td>
                @if($form->status == \App\Models\AppointmentForms::NEW)
                    <span class="badge text-bg-cyan badge-md badge-rounded">New</span>
                @elseif ($form->status == \App\Models\AppointmentForms::IN_PRORESS)
                    <span class="badge text-bg-yellow badge-md badge-rounded">In progress</span>
                @elseif ($form->status == \App\Models\AppointmentForms::COMPLETED)
                    <span class="badge text-bg-green badge-md badge-rounded">Completed</span>
                @endif
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm black-btn round-6 dt-delete" id="delete_forms" data-apptform_id="{{ $form->id }}" data-appointment_id="{{ $form->appointment_id }}">
                    <i class="ico-trash"></i>
                </button>
            </td>
        </tr>
    @endforeach
@endif
