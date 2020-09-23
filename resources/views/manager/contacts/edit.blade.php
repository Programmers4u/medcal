@extends('layouts.app')

@section('title', trans('manager.contacts.create.title'))

@section('content')
<div class="container-fluid">

        <div class="panel panel-default">

            <div class="panel-heading">
                {{ trans('manager.contacts.create.title') }}
            </div>

            <div class="panel-body">

                {!! Form::model($contact, ['method' => 'put', 'route' => ['manager.addressbook.update', $business, $contact], 'class' => 'form-horizontal']) !!}
                    @include('manager.contacts._form', ['submitLabel' => trans('manager.contacts.btn.update')])
                {!! Form::close() !!}
            </div>

        </div>

</div>
<!-- delete
<div class="container">
        <div class="panel panel-default">

            <div class="panel-heading">{!! Form::label( trans('medical.groups.title') ) !!}</div>
            <div class="panel-body">
            {!! Form::select('groups', $groupsList, null, ['multiple', 'id' => 'groups', 'class' => 'form-control select2']) !!}
            </div>
            <div class="panel-footer">
                <a title="wróć do karty pacjenta" class="btn btn-primary btn-info fa fa-arrow-circle-left" href="javascript:window.history.back();"></a>
            </div>
            
        </div>
</div>
-->
@endsection

@push('footer_scripts')
<script type="text/javascript">
$('#groups').on('select2:select', function (e) { 

    var data = e.params.data;
    console.log(data);
    
    var formData = {
        'group_id' : data.id,
        'contact_id' : '{{$contact->id}}',
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        type      : 'POST',
        url       : '{{ route("medical.group.add",[$business])}}',
        data      : formData,
        dataType  : 'json',
        encode    : true
        }).done(function(data) {
            console.log(JSON.stringify(data));
            console.log('updated OK'); 
        }).error(function(data) {
            console.log(JSON.stringify(data));
            console.log('could not be updated'); 
            alert('could not be updated');
        });
})
</script>
<script type="text/javascript">
$('#groups').on('select2:unselect', function (e) { 

    var data = e.params.data;
    console.log(data);
    
    var formData = {
        'group_id' : data.id,
        'contact_id' : '{{$contact->id}}',
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        type      : 'POST',
        url       : '{{ route("medical.group.del",[$business])}}',
        data      : formData,
        dataType  : 'json',
        encode    : true
        }).done(function(data) {
            console.log(JSON.stringify(data));
            console.log('updated OK'); 
        }).error(function(data) {
            console.log(JSON.stringify(data));
            console.log('could not be updated'); 
            alert('could not be updated');
        });
})
</script>
<script type="text/javascript">
$(document).ready(function(){
    
    $('#groups').select2({
        theme: "bootstrap"
    });
    @foreach($groups as $gr)
    @if(TRUE==in_array($contact->id,explode(',',$gr['contacts'])))
    {!! array_push($tab,$gr['id']) !!}
    @endif
    @endforeach
    var tab = [{{ implode(",",$tab) }}];
    $('#groups').val(tab); // Select the option with a value of '1'
    $('#groups').trigger('change'); // Notify any JS components that the value changed
    });
</script>
@endpush    