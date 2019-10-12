@section('css')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endsection

<ul class="list-group">
    @foreach($permission as $data)
    <li class="list-group-item text-bold">{{ $data['name'] }}
        <span class="pull-right"><input type="checkbox" onchange="updatePermission(this)" data-size="mini" id="permission_{{$data['id']}}" @if($data['value']=='true') checked @endif></span>
    </li>
    @endforeach
</ul>
<br>
<div class="panel panel-default">
  <div class="panel-body">

<b>Pliki wzorów:</b> 
<br><br>
<div class="container">
<div class="row">
@foreach($permission_template as $indx=>$file)
<div class="col-4 col-lg-2">
<div class="panel panel-default">
  <div class="panel-body">
    <b>{{ $file['description'] }}</b><br>
    <a title="{{ $file['description'] }}" class="fa fa-file fa-3x" href="{{$file['url']}}" target="_blank"></a><br>
  </div>
    <div class="panel-footer">
    <a class="btn btn-primary btn-sm tooltipstered btn-danger fa fa-remove" href="javascript:deleteFile({{$file['id']}})"></a>
    </div>
</div>
</div>    
@endforeach
</div>
</div>

</div>
<div class="panel-footer">
<a class="btn btn-primary btn-sm tooltipstered btn-success fa fa-plus fa-2x" title="dodaj wzór" href="javascript:historyId=-2;openFiles();"></a>
</div>

</div>



<div class="panel panel-default">
    <div class="panel-body">
<b>Załącz wypełnione pliki:</b><br>
<br>
        <div class="container">
            <div class="row">
            @foreach($files as $indx=>$file)
                @if($file['type']=='P')
                <div class="col-9 col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <h5>{{ $file['description'] }}</h5><br>
                        <a href="{{$file['url']}}" target="_blank" class="fa fa-file fa-2x"></a>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-primary btn-sm tooltipstered btn-danger" href="javascript:deleteFile({{$file['id']}})">usuń załącznik</a>
                        </div>
                    </div>
                </div>    
                @endif
            @endforeach
            </div>
        </div>

    </div>
    <div class="panel-footer">
    <a class="btn btn-primary btn-sm tooltipstered btn-success fa fa-file fa-2x" href="javascript:historyId=-1;openFiles();"></a>
    </div>
</div>

@push('footer_scripts')
<script src="{{ asset('js/forms.js') }}"></script>
<script type="text/javascript">
    
var updatePermission = function(objc){
    var formData = {
        'contact_id' : '{{$contacts->id}}',
        'business_id' : '{{$business->id}}',
        'pair' : {
            'id' : objc.id.replace('permission_',''),
            'value' : objc.checked,
        }
    };
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        type      : 'POST',
        url       : '{{ route("medical.permission.update",[$business])}}',
        data      : formData,
        dataType  : 'json',
        encode    : true
        }).done(function(data) {

            console.log(data);
            console.log('updated OK'); 

        }).error(function(data) {

            console.log('could not be updated'); 

        });
}    
$(document).ready(function(){
    var timer;
    $("[type='checkbox']").bootstrapSwitch().on('switchChange.bootstrapSwitch', function(event, state) {
        window.clearTimeout(timer);
        timer = window.setTimeout(function(){
            $('#save').submit();
        }, 3000);
    });
});
</script>
@endpush