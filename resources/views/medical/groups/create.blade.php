@extends('layouts.app')

@section('title', trans('medical.groups.create.title'))
@section('subtitle', trans('medical.groups.create.subtitle'))

@section('content')
<div class="container-fluid">
    {!! Alert::info(trans('medical.groups.create.instructions')) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            {{ trans('medical.groups.create.title') }}
        </div>

        <div class="panel-body">
                @include('medical.groups._form', ['submitLabel' => trans('manager.humanresource.btn.store'),'business' => $business])
        </div>
    </div>
</div>
@endsection

@push('footer_scripts')
<script>
var submit = function(){
        
    var post = {
        'name': $('#name').val(),
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
            document.location.href='{{ route('medical.group.index',[$business]) }}';
        }
    });
}
</script>
@endpush