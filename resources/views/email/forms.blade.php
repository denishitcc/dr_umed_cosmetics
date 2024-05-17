Hello {{ ucfirst($name) }},

<p>Before your appointment, we'd like to gather some additional information. Please follow this link to complete the required forms:</p>

<a href="{{ $form_url }}"> {{ $form_url }}</a>

<p>If you have any questions or need assistance, please give us a call on 0407 194 519.</p>

Kind regards,
<br />
{{ $company_name }}