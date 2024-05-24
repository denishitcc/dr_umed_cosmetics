Hello {{ ucfirst($name) }},

<p>Before your appointment, we'd like to gather some additional information. Please follow this link to complete the required forms:</p>

@if(count($formslinks)>0)
    @foreach ($formslinks as $formslink)
        <a href="{{ $formslink['form_url'] }}"> <b> {{ $formslink['form_title'] }} </b> </a> <br><br>
    @endforeach
@endif

<p>If you have any questions or need assistance, please give us a call on 0407 194 519.</p>

Kind regards,
<br />
{{ $company_name }}