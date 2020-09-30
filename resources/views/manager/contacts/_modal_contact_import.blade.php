@push('footer_scripts')
<script type="text/javascript">
var openImport = () => {
    $('#importContactModal').modal({
        keyboard: false,
        backdrop: false,
    }) 
} 
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

var uploadFiles = function () {
    var data = new FormData();
    $.each(files, function(key, value) {
        data.append(key, value);
        filesName.push(value.name);
    });
    var url = "{{ route('contacts.import.file',[$business]) }}";

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}',
        },                    
        url: url,
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR) {
            if(data.status === 'ok') {
                $('.close').click();
                alert(JSON.stringify(data.data));
                setTimeout(()=>{
                    document.location.reload();
                },5000);
            } else {
                console.log('ERRORS: ' + data.error);
                alert('Błąd: '+data.error, 'error');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log('ERRORS: ' + textStatus);
            alert('Błąd globalny komunikacji: '+textStatus, 'error');
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
                <h3 class="modal-title" id="importContactModal">{{trans('medical.document.file.title')}}</h3>
            </div>
            <div class="modal-body">
                <div class="file-loading"> 
                    <input id="input-f10" name="input-f10[]" type="file">
                </div>
                <br><br>
                <div class="container">
                <div class="row col-sm-8">
                Format pliku: <b>CSV</b><br>
                kolejność kolumn:<br>
                <b>
                unikalne id,<br>
                imię,<br>
                nazwisko,<br>
                pesel,<br>
                płeć,<br>
                data urodzenia,<br>
                numer komórkowy,<br>
                adres e-mail,<br>
                adres (ulica numer domu),<br>
                miasto,<br>
                <br>
                Ważne!<br>
                Kolumny muszą wystąpić dokładnie w takiej kolejności jak podano powyżej.<br>
                W pierwszym wierszu nie ma nazw kolumn. Od razu są dane.
                </b>
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