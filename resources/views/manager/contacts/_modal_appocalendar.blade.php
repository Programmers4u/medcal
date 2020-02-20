@push('footer_scripts')
<script>
var app_meeting_Id = 0;
var deleteAppointment = function(){
    if(!confirm('Jesteś zdecydowany anulować spotkanie?')) return;
    var post = {
        'business' : bussinesId,
        'appointment' : app_meeting_Id,
        'action' : 'cancel',
        'widget' : 'row',
    }
    if(humanresources==0){
        var txt = 'Wybierz kalendarz pracownika';
        alert(txt,'error');
        return -1;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        },            
        url: "/booking",
        data: post,            
        dataType: "json",
        type: "POST",
        success: function (data) {
            getAppointment();
            $('#_modal_appocalendar [data-dismiss=modal]').click();
        },
    });
}
</script>

@endpush

<!-- Modal -->
<div class="modal" id="_modal_appocalendar" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLabel">{{trans('manager.calendar.modals.title2')}}</h3>
      </div>
      <div class="modal-body">

      <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Twoja wizyta</h3>
            </div>

            <div class="panel-body">
                Data spotkania: <b><span id='app-meeting-date'></span></b><br>
                Pacjent: <b><span id='app-meeting-client'></span></b><br>
                Lekarz: <b><span id='app-meeting-staff'></span></b><br>
                Usługa: <b><span id='app-meeting-service'></span></b><br>
                {{trans('medical.appointments.label.note')}}: <b><span id='app-meeting-note'></span></b><br>
            </div>    
        </div>

          
      <div class="modal-footer">
          <button type="button" onclick="clickLink($('#app-meeting-client'))" class="btn btn-secondary btn-success">Rozpocznij wizytę</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('manager.contacts.btn.close') }}</button>
        <button type="button" class="btn btn-secondary btn-danger" onclick="deleteAppointment()">{{ trans('manager.contacts.btn.delete_appo') }}</button>
      </div>
    </div>
  </div>
</div>
</div>

@section('css')
@parent
<style>
</style>
@endsection