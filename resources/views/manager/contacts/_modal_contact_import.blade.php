@push('footer_scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('input[type=file]').on('change', prepareUpload);
});
</script>

<script type="text/javascript">
var files;
var filesName = [];

var prepareUpload = function(event) {
  files = event.target.files;
}        

var uploadFiles = function (){
    var data = new FormData();
    $.each(files, function(key, value)
    {
        data.append(key, value);
        filesName.push(value.name);
    });
    var url = "{{ route('contacts.import.file',[$business]) }}";

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}',
            // 'Content-type': 'text/csv',
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
            // $('#atach_file').html(filesName.join('<br>'));
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                //submitForm(event, data);
                $('.close').click();
                // document.location.reload();
                alert('Załącznik został dołączony');
            }
            else
            {
                // Handle errors here
                //console.log('ERRORS: ' + data.error);
                // document.location.reload();
                alert('Załącznik został dołączony');
                // alert('Błąd: '+data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            //console.log('ERRORS: ' + textStatus);
            // document.location.reload();
            // alert('Błąd: '+textStatus);

        }
    });        
}
</script>
@endpush

<!-- Modal -->
<div class="modal" id="importContactModal" tabindex="-5" role="dialog" aria-labelledby="importContactModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="exampleModalLabel">{{trans('medical.document.file.title')}}</h3>
            </div>
            <div class="modal-body">
                <div class="file-loading"> 
                    <input id="input-f10" name="input-f10[]" type="file">
                </div>
                <br><br>
                <div class="container">
                <div class="row col-sm-8">
                
                </div>
            </div>
        </div>
                    
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('medical.btn.close') }}</button>
            <button type="button" class="btn btn-primary" id="savebtn" onclick="uploadFiles()">{{ trans('medical.btn.savefiles') }}</button>
        </div>
    </div>
</div>
    
@section('css')
@parent
<style></style>
@endsection