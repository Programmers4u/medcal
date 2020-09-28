@push('footer_scripts')
<script type="text/javascript">
$(document).ready(function(){
    // Add events
    $('input[type=file]').on('change', prepareUpload);
});

</script>
<script type="text/javascript">
var deleteFile = function (id) {
    confirm('Czy jesteś pewny że chcesz usunąć ten plik?', function(result) {
        if(!result) return false;

        // Create a formdata object and add the files
        var data = new FormData();
        data.append('contact_id','{{ $contacts->id }}');
        data.append('id',id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },                    
            url: "{{ route('medical.file.delete',[$business]) }}",
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR)
            {
                if(typeof data.error === 'undefined')
                {
                    document.location.reload();
                }
                else
                {
                    console.log('ERRORS: ' + data.error);
                    document.location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                console.log('ERRORS: ' + textStatus);
                document.location.reload();
            }
        });        
    });
}    
</script>

<script type="text/javascript">
// Variable to store your files
var files;
var filesName = [];
var type = 'P'; //P-Permission H-History file 
// Grab the files and set them to our variable
var prepareUpload = function(event) {
  files = event.target.files;
//  console.log(event.target.files);
//  console.log(event.target.files[0].name);
}        
// Catch the form submit and upload the files
var uploadFiles = function (){
    // Create a formdata object and add the files
    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
        filesName.push(value.name);
    });
    data.append('contact_id','{{ $contacts->id }}');
    data.append('description',$('#description').val());
    data.append('history_id',historyId);
    data.append('type',type);
    var url = "{{ route('medical.file.put',[$business]) }}";
    if(type=='{{$typePermissionTemplate}}') url = "{{ route('medical.file.permission.put',[$business]) }}";

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            $('#atach_file').html(filesName.join('<br>'));
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                //submitForm(event, data);
                $('.close').click();
                if(type=='{{$typePermissionTemplate}}')
                document.location.reload();
                alert('Załącznik został dołączony');
            }
            else
            {
                // Handle errors here
                //console.log('ERRORS: ' + data.error);
                if(type=='{{$typePermissionTemplate}}')
                document.location.reload();
                alert('Załącznik został dołączony');
                alert('Błąd: '+data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            //console.log('ERRORS: ' + textStatus);
            if(type=='{{$typePermissionTemplate}}')
            document.location.reload();
            alert('Błąd: '+textStatus);

        }
    });        
}
</script>
@endpush

<!-- Modal -->
<div class="modal" id="medicalFiles" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLabel">{{trans('medical.document.file.title')}}</h3>
      </div>
      <div class="modal-body">
                {{trans('medical.document.file.desc')}}<br>
                <textarea type="text" id="description" class="form-control md-textarea" rows="3"></textarea>
                <div class="file-loading"> 
                    <input id="input-f10" name="input-f10[]" type="file">
                </div>
                <br><br>
                <div class="container">
                <div class="row col-sm-8">
                
                @foreach($files as $indx=>$file)
                <div type='{{$file['type']}}' appo='{{$file['medical_history_id']}}'>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h5>{{ $file['description'] }}</h5><br>
                            <a href="{{$file['url']}}" target="_blank">
                            @if($file['type']==$typePermissionTemplate)
                            <span class='fa fa-file fa-2x'></span>
                            @else
                            <img src="{{$file['url']}}" title="file" width="25%"/>
                            @endif
                            </a>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-primary btn-sm tooltipstered btn-danger fa fa-remove" href="javascript:deleteFile({{$file['id']}})"></a>
                        </div>
                    </div>
                </div>
                </div>    
                @endforeach
            </div>
            </div>
                    
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('medical.btn.close') }}</button>
        <button type="button" class="btn btn-primary" id="savebtn" onclick="uploadFiles()">{{ trans('medical.btn.savefiles') }}</button>
      </div>
    </div>
  </div>
</div>
    
@section('css')
@parent
<style></style>
@endsection