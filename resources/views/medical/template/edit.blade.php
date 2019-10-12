@extends('layouts.app')

@section('title', trans('medical.template.edit.title'))
@section('subtitle', trans('medical.template.edit.subtitle'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('medical.template.create.title') }}</div>

            <div class="panel-body">
                    @include('medical.template._form', ['submitLabel' => trans('manager.humanresource.btn.update'),'template_type'=>$template_type, 'business' => $business])
            </div>

        </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script>    
$(document).ready(function(){
    $('#name').val('{{$template->name}}');
    $('#template').val('{{str_replace(["\r","\n"]," ",$template->desc)}}');
    $('[name=template_type]').val('{{$template->type}}');
});    
    
var submit = function(){
        
    var post = {
        name: $('#name').val().replace(/\r\n/gi,' '),
        template: $('#template').val().replace(/\r\n/gi,' '),
        type: $('[name=template_type]').val(),
        id : '{{$template->id}}',
    };
        
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },            
        url: "{{ route('medical.template.store',[$business]) }}",
        data: post,            
        dataType: "json",
        type: "POST",
        success: function (data) {
            alert(JSON.stringify(data));
            document.location.href='{{ route('medical.template.index',[$business]) }}';
        }
    });
}
</script>
@endpush