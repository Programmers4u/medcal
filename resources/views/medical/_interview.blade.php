@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

{!! Form::label( trans('medical.interview.index.sick') ) !!}<br>
{!! Form::select('sick', $interviewData['diseases_data'], null, ['multiple', 'style' =>'width:100%', 'id' => 'sick', 'class' => 'form-control select2']) !!}
<br>
{!! Form::label( trans('medical.interview.index.aid') ) !!}<br>
{!! Form::select('aid', $interviewData['aid_data'], null, ['multiple', 'style' =>'width:100%', 'id' => 'aid', 'class' => 'form-control select2']) !!}
<br>
{!! Form::label( trans('medical.interview.index.desc') ) !!}<br>
{!! Form::textarea('desc') !!}<br>

@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>

<script type="text/javascript">
$('#sick').on('select2:select', function (e) { 

    var data = e.params.data;
    console.log(data);
    
    var formData = {
        'action' : 'sick',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : data.id,
            'value' : data.selected.toString(),
        }
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        type      : 'POST',
        url       : '{{ route("medical.interview.update",[$business])}}',
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
$('#sick').on('select2:unselect', function (e) { 

    var data = e.params.data;
    console.log(data);
    
    var formData = {
        'action' : 'sick',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : data.id,
            'value' : data.selected.toString(),
        }
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        type      : 'POST',
        url       : '{{ route("medical.interview.update",[$business])}}',
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
$('#aid').on('select2:select', function (e) { 

    var data = e.params.data;
    console.log(data);
    
    var formData = {
        'action' : 'aid',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : data.id,
            'value' : data.selected.toString(),
        }
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        type      : 'POST',
        url       : '{{ route("medical.interview.update",[$business])}}',
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
$('#aid').on('select2:unselect', function (e) { 

    var data = e.params.data;
    console.log(data);

    var formData = {
        'action' : 'aid',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : data.id,
            'value' : data.selected.toString(),
        }
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        type      : 'POST',
        url       : '{{ route("medical.interview.update",[$business])}}',
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
$('[name=desc]').on('change', function (e) { 
    
    console.log(e);
    
    var formData = {
        'action' : 'desc',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : -1,
            'value' : $('[name=desc]').val().replace(/\r\n/g, ' ').toString(),
        }
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        type      : 'POST',
        url       : '{{ route("medical.interview.update",[$business])}}',
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
    var timer;
    $("[type='checkbox']").bootstrapSwitch().on('switchChange.bootstrapSwitch', function(event, state) {
        window.clearTimeout(timer);
        timer = window.setTimeout(function(){
            $('#save').submit();
        }, 3000);
    });
    
    $('.select2').select2({
        theme: "bootstrap"
    });
    var tab = [];
    @foreach($interviewData['model']['diseases'] as $id)
    @if($id['value']=='true')
        tab.push({{$id['id']}});
    @endif
    @endforeach
    $('#sick').val(tab); // Select the option with a value of '1'
    $('#sick').trigger('change'); // Notify any JS components that the value changed

    tab = [];
    @foreach($interviewData['model']['aid'] as $id)
    @if($id['value']=='true')
        tab.push({{$id['id']}});
    @endif
    @endforeach
    
    $('#aid').val(tab); // Select the option with a value of '1'
    $('#aid').trigger('change'); // Notify any JS components that the value changed

    $('[name=desc]').val('{{str_replace(["\r","\n"]," ",$interviewData['model']['desc'])}}');
});
</script>
@endpush