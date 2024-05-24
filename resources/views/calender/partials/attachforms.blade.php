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
                @if($form->status == \App\Models\AppointmentForms::COMPLETED)
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                    </svg>
                @else
                    <input type="checkbox" name="forms_check[]" value="{{ $form->form_id }}">
                @endif
            </td>
            <td class="blue" style="cursor: pointer" >{{ $form->forms->title }}</td>
            <button type="button" data-toggle="tooltip" data-html="true" data-trigger="manual" data-placement="right" title="<button>Facebook</button>" class="btn btn-default" id="example">example</button>
            <td>
                @if($form->status == \App\Models\AppointmentForms::NEW)
                    <span class="badge text-bg-seagreen badge-md badge-rounded">New</span>
                @elseif ($form->status == \App\Models\AppointmentForms::SUBMITTED)
                    <span class="badge text-bg-blue badge-md badge-rounded">Submitted</span>
                @elseif ($form->status == \App\Models\AppointmentForms::IN_PRORESS)
                    <span class="badge text-bg-orange badge-md badge-rounded">In progress</span>
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
