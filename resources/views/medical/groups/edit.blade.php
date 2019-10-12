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
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Button::danger('Delete')
                                ->withIcon(Icon::trash())
                                ->withAttributes([
                                    'id' => 'delete-btn',
                                    'type' => 'button',
                                    'data-for' => 'delete',
                                    'data-toggle' => 'tooltip',
                                    'data-method' => 'DELETE',
                                    'data-original-title' => trans('manager.contacts.btn.delete'),
                                    'data-confirm'=> trans('manager.contacts.btn.confirm_delete')])                        
                                ->large()
                                ->block()
                                ->asLinkTo('javascript:destroy()')
                        !!}
                    </div>
                </div>
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
    
var destroy = function(){
    
    if(!confirm('Czy chcesz usunąć grupę?')) return;
    
    var post = {
        'id': '{{$group_id}}',
    };
        
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },            
        url: "{{ route('medical.group.delete',[$business,$group_id]) }}",
        data: post,            
        dataType: "json",
        type: "POST",
        success: function (data) {
            //alert(JSON.stringify(data));
            alert('ok');
            document.location.href = '{{ route('medical.group.index',[$business]) }}';
        }
    });
}

var submit = function(){
        
    var post = {
        'name': $('#name').val(),
        'id': '{{$group_id}}',
    };
        
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },            
        url: "{{ route('medical.group.store',[$business,$group_id]) }}",
        data: post,            
        dataType: "json",
        type: "POST",
        success: function (data) {
            //alert(JSON.stringify(data));
            alert('ok');            
            document.location.href = '{{ route('medical.group.index',[$business]) }}';
        }
    });
}
</script>
@endpush