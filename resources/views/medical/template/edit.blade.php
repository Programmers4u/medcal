@extends('layouts.app')

@section('title', trans('medical.template.edit.title'))
@section('subtitle', trans('medical.template.edit.subtitle'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('medical.template.create.title') }}</div>

            <div class="panel-body">
                    @include('medical.template._form', [
                        'submitLabel' => trans('manager.humanresource.btn.update'),
                        'template_type'=>$template_type, 
                        'business' => $business
                    ])
            </div>

        </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script>
    var submit = function() {
        webApi("{{ route('medical.template.store',[$business]) }}", {
            csrf: '{{csrf_token()}}',
            post: {
                name: $('#name').val().replace(/\r\n/gi,' '),
                description: $('#description').val().replace(/\r\n/gi,' '),
                type: $('[name=template_type]').val(),
                id : '',
                businessId: '{{ $business->id }}',
                success: function(data) {
                    document.location.href='{{ route('medical.template.index',[$business]) }}';
                },
            }
        });
    }
</script>

<script>    
$(document).ready(function(){
    $('#name').val('{{$template->name}}');
    $('#description').val('{{str_replace(["\r","\n"]," ",$template->description)}}');
    $('[name=template_type]').val('{{$template->type}}');
});    
    
</script>
@endpush