@push('footer_scripts')
<script type="text/javascript">
var preventDoubleSave = false;
var saveContact = function () {
    if(preventDoubleSave) return -1;
    if($('#firstname').val().length < 2 || $('#lastname').val().length < 2){
        alert('{{trans('manager.contacts.validate.miniform.alert.name')}}', 'error');
        return -1;
    }
    if($('#birthdate').val().length < 2){
        alert('{{trans('manager.contacts.validate.miniform.alert.birthdate')}}', 'error');
        return -1;
    }
    if($('#mobile-input').val().length < 2){
        alert('{{trans('manager.contacts.validate.miniform.alert.mobile')}}', 'error');
        return -1;
    }
    preventDoubleSave = true;
    $('#ac_savebtn').attr('disabled',true);

    var data = new FormData();
    data.append('firstname',$('#firstname').val());
    data.append('lastname',$('#lastname').val());
    data.append('mobile',$('#mobile-input').val());
    data.append('birthdate',$('#birthdate').val());
    data.append('email',$('#email').val());
    data.append('gender',$('#gender').val());
    data.append('nin',$('#nin').val());
    data.append('businessId','{{ $business->id }}');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },                    
        url: '{{ route('manager.addressbook.ministore',[$business]) }}',
        type: 'POST',
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, 
        contentType: false, 
        success: function(data, textStatus, jqXHR) {
          preventDoubleSave = false;
            if(data.status === 'error') {
                alert(data.error, 'error');
                console.log('ERRORS: ' + data.error, 'error');
            } else {
                alert(data.info);
                contactId = data.data;
                $('#ac_savebtn').attr('disabled',false);
                $('#savebtn').attr('disabled',false);
                document.getElementById("searchfield").value = $('#firstname').val()+' '+$('#lastname').val()+', '+$('#mobile-input').val();
                $('#addContactModal .btn-secondary').click();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            preventDoubleSave = false;
            console.log('ERRORS: ' + textStatus, 'error');
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
        <h3 class="modal-title" id="addContactModalLabel">{{trans('manager.contacts.create.title')}}</h3>
      </div>
      <div class="modal-body" style="min-height: 23em;">
          @include('manager.contacts._miniform', [compact('contact')])            
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
<style>
</style>
@endsection