{{-- <thead>
    <tr>
        <th colspan="2"><b>3 jun</b></th>
    </tr>
</thead> --}}
<tbody>
    @if ($forms->count())
        @foreach ($forms as $form)
        <tr>

            <td><a href="javascript:void(0)"  class="simple-link add_forms" data-appointment_id="{{ $form->appointment_id }}" data-form_id="{{ $form->forms->id }}">{{ $form->forms->title }}</a></td>
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
        </tr>
        {{-- <tr>
            <td><a href="#" class="simple-link">Skin Needling - CONSULTATION FORM</a></td>
            <td><span class="badge text-bg-secondary badge-md badge-rounded">In Progress</span></td>
        </tr> --}}
        @endforeach
    @endif
</tbody>
