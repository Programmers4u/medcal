@extends('layouts.app')

@section('title', trans('medical.groups.edit.title'))
@section('subtitle', trans('medical.groups.edit.subtitle'))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('medical.groups.create.title') }}</div>

            <div class="panel-body">
                    @include('medical.groups._form', ['submitLabel' => trans('manager.humanresource.btn.update')])
            </div>

        </div>
    </div>
</div>
@endsection
@push('footer_scripts')
<script>    
$(document).ready(function(){
    $('#name').val('{{$name[0]->name}}');
});    
    
var submit = function(){
        
    var post = {
        'name': $('#name').val(),
        'id': '{{$group_id}}',
    };
        
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },            
        url: "{{ route('medical.group.store',[$business]) }}",
        data: post,            
        dataType: "json",
        type: "POST",
        success: function (data) {
            alert(JSON.stringify(data));
            document.location.reload();
        }
    });
}
</script>
@endpush