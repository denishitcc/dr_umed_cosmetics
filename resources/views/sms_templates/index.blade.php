@extends('layouts/sidebar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>   -->
<!-- <main> -->
    <div class="card">
        <div class="card-head">
            <div class="toolbar mb-0">
                <div class="tool-left">
                    <h4 class="small-title mb-0">SMS Templates</h4>
                </div>
                <div class="tool-right">
                    <!-- <a href="{{ route('email-templates.create') }}" class="btn btn-primary btn-md">Add Email</a> -->
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <table class="table data-table all-db-table align-middle display">
                <thead>
                    <tr>
                    <!-- <th>
                    </th> -->
                    <th>SMS Template Type</th>
                    <th>SMS Template Description</th>
                    <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($sms_templates as $sms)
                    <tr>
                        <td><a href="sms-templates/{{$sms->id}}" class="blue-bold">{{$sms->sms_template_type}}</a></td>
                        <td> {!! $sms->sms_template_description !!}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
<!-- </main> -->
     
@stop
@section('script')
<script>
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
</html>
@endsection