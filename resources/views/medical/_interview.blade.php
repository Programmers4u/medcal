
{!! Form::label( trans('medical.interview.index.sick') ) !!}<br>
{!! Form::select('sick', $interviewData['diseases_data'], null, ['multiple', 'style' =>'width:100%', 'id' => 'sick', 'class' => 'form-control select2']) !!}
<br>
{!! Form::label( trans('medical.interview.index.aid') ) !!}<br>
{!! Form::select('medicine', $interviewData['aid_data'], null, ['multiple', 'style' =>'width:100%', 'id' => 'medicine', 'class' => 'form-control select2']) !!}
<br>
{!! Form::label( trans('medical.interview.index.desc') ) !!}<br>
{!! Form::textarea('desc') !!}<br>

@push('footer_scripts')

<script type="text/javascript">
$('#sick').on('select2:select', function (e) { 

    var data = e.params.data;

    var formData = {
        'action' : 'sick',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : data.id,
            'value' : data.selected.toString(),
        },
        'csrf' : '{{csrf_token()}}',
        'type' : 'POST',
        'success' : function(data) {
            alert('zapisane');
        },
        'error' : function(data) {
            alert('could not be updated','error');
        },
    }
    webApi('{{ route("medical.interview.update",[$business])}}', formData);
})
</script>
<script type="text/javascript">
$('#sick').on('select2:unselect', function (e) { 

    var data = e.params.data;

    var formData = {
        'action' : 'sick',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : data.id,
            'value' : data.selected.toString(),
        },
        'csrf' : '{{csrf_token()}}',
        'type' : 'POST',
        'success' : function(data) {
            alert('zapisane');
        },
        'error' : function(data) {
            alert('could not be updated','error');
        },
    }
    webApi('{{ route("medical.interview.update",[$business])}}', formData);
});
</script>
<script type="text/javascript">
$('#medicine').on('select2:select', function (e) { 
    
    var data = e.params.data;

    var formData = {
        'action' : 'aid',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : data.id,
            'value' : data.selected.toString(),
        },
        'csrf' : '{{csrf_token()}}',
        'type' : 'POST',
        'success' : function(data) {
            alert('zapisane');
        },
        'error' : function(data) {
            alert('could not be updated','error');
        },
    }
    webApi('{{ route("medical.interview.update",[$business])}}', formData);
})
</script>
<script type="text/javascript">
$('#medicine').on('select2:unselect', function (e) { 

    var data = e.params.data;

    var formData = {
        'action' : 'aid',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : data.id,
            'value' : data.selected.toString(),
        },
        'csrf' : '{{csrf_token()}}',
        'type' : 'POST',
        'success' : function(data) {
            alert('zapisane');
        },
        'error' : function(data) {
            alert('could not be updated','error');
        },
    }
    webApi('{{ route("medical.interview.update",[$business])}}', formData);
})
</script>
<script type="text/javascript">
$('[name=desc]').on('change', function (e) { 
    
    var formData = {
        'action' : 'desc',
        'contact_id' : '{{$contacts->id}}',
        'pair' : {
            'id' : -1,
            'value' : $('[name=desc]').val().replace(/\r\n/g, ' ').toString(),
        },
        'csrf' : '{{csrf_token()}}',
        'type' : 'POST',
        'success' : function(data) {
            alert('zapisane');
        },
        'error' : function(data) {
            alert('could not be updated','error');
        },
    }
    webApi('{{ route("medical.interview.update",[$business])}}', formData);
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
    
    $('#sick').select2({
        theme: "bootstrap"
    });

    var tab = [];
    @foreach($interviewData['model']['diseases'] as $id)
        @if($id['value']=='true')
            tab.push({{$id['id']}});
        @endif
    @endforeach
    $('#sick').val(tab);
    $('#sick').trigger('change');

    tab = [];
    @foreach($interviewData['model']['aid'] as $id)
        @if($id['value']=='true')
            tab.push({{$id['id']}});
        @endif
    @endforeach
    
    $('#medicine').select2({
        theme: "bootstrap",
        ajax: {
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },                    
            url: '{{ route("medicines.list",[$business])}}',
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    medicine: params.term // search term
                };
            },
            processResults: function (response) {
                return {
                    results: response
                };
            },
            cache: true,
       },
    });

    $('#medicine').val(tab);
    $('#medicine').trigger('change');

    $('[name=desc]').val('{{str_replace(["\r","\n"]," ",$interviewData['model']['desc'])}}');
});
</script>
@endpush