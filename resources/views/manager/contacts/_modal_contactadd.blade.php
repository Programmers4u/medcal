@push('footer_scripts')
<script>
$(document).ready(function(){

});
</script>

<script>
var saveContact = function () {
    if($('#firstname').val().length<2 || $('#lastname').val().length<2){
        alert('Wpisz imię i nazwisko, minimum 2 znaki.');
        return;
    }
    var data = new FormData();
//    data.append('business_id','{{ $business->id }}');
    data.append('firstname',$('#firstname').val());
    data.append('lastname',$('#lastname').val());
    data.append('mobile',$('#mobile-input').val());
    data.append('email','');
    data.append('gender',$('#gender').val());

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        url: "{{ route('manager.addressbook.ministore',[$business]) }}",
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
        success: function(data, textStatus, jqXHR)
        {
            //if(typeof data === 'undefined')
            //{
                // Success so call function to process the form
                if(data.status=='error'){
                    alert(data.error);
                }else{
                    alert(data.status);
                    contactId = data.data;
                    $('#savebtn').attr('disabled',false);
                    document.getElementById("searchfield").value = $('#firstname').val()+' '+$('#lastname').val()+', '+$('#mobile-input').val();
                    $('#addContactModal button').click();
                }
            //}
            //else
            //{
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            //}
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });        
}
</script>
@endpush

<!-- Modal -->
<div class="modal" id="addContactModal" tabindex="-4" role="dialog" aria-labelledby="addContactModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLabel">{{trans('manager.contacts.create.title')}}</h3>
      </div>
      <div class="modal-body">
          @include('manager.contacts._miniform', [compact('$contact')])            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('manager.contacts.btn.close') }}</button>
        <button type="button" class="btn btn-primary" id="ac_savebtn" onclick="saveContact()">{{ trans('manager.contacts.btn.store') }}</button>
      </div>
    </div>
  </div>
</div>

@section('css')
@parent
<style></style>
@endsection