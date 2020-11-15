@push('footer_scripts')
<script type="text/javascript" src="/js/medical/doc.min.js"></script>

<script>
var app_meeting_Id = 0;

var deleteAppointment = function() {      
  confirm('{{trans('appointments.confirm.delete')}}', (result) => {
    if(false === result) return false;
      AppointmentDelete.post = {
      ...AppointmentDelete.post,
      business : '{{ $business->id }}',
      appointment: app_meeting_Id,
      csrf : csrf,
      'action' : 'cancel',
      'widget' : 'row',
      };
      AppointmentDelete.get(function (data) {
        $('#_modal_appocalendar [data-dismiss=modal]').click();
        document.location.reload();
      });
    return true;
  });
}
</script>

<script>
var urlNotePut = '{{ route('medical.note.put',[$business]) }}';
var urlNoteGet = '{{ route('medical.note.get',[$business]) }}';
var NoteCallBack = () => {
  return {
    appointmentId : appointment_id,
    note : $('#note')[0].value,
    businessId: '{{ $business->id }}',
    csrf : '{{csrf_token()}}',
    contactId: contactId,
    success : function (data) {
      getNote();
      $('#note')[0].value = '';
    },
    error: function(errors) {
      let result = flatten(errors);
      alert(result[0], 'error');
    }
  }
};

const flatten = function(object) {
    return Object.assign( {}, ...function _flatten( objectBit, path = '' ) {  //spread the result into our return object
      return [].concat(                                                       //concat everything into one level
        ...Object.keys( objectBit ).map(                                      //iterate over object
          key => typeof objectBit[ key ] === 'object' ?                       //check if there is a nested object
            _flatten( objectBit[ key ], `${ path }/${ key }` ) :              //call itself if there is
            ( { [ `${ key }` ]: objectBit[ key ] } )                //append object with it’s path as key
        )
      )
    }( object ) );
};

var getNote = () => {
  getAppointmentNote(urlNoteGet, {
    csrf: '{{csrf_token()}}',
    appointmentId: appointment_id,
    businessId: '{{ $business->id }}',
    contactId: contactId,
    success: function(data) { 
        if(data)
            $('#app-meeting-note')[0].innerText = data.medicalNote.note 
              ? data.medicalNote.note.join(', ') 
              : '';
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

      <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Twoja wizyta</h3>
            </div>

            <div class="panel-body">
                Data spotkania: <b><span id='app-meeting-date'></span></b><br>
                Pacjent: <b><span id='app-meeting-client'></span></b><br>
                Lekarz: <b><span id='app-meeting-staff'></span></b><br>
                Usługa: <b><span id='app-meeting-service'></span></b><br>
                {{trans('medical.appointments.label.note')}}: <b><span id='app-meeting-note'></span></b><br>
                <textarea id="note" class="form-control md-textarea"></textarea>
                <div style="padding-top:1em;" >
                  {!! 
                      Button::withIcon(Icon::save())
                          ->info('zapisz notatkę')
                          ->small()
                          ->asLinkTo("javascript:putAppointmentNote(urlNotePut, NoteCallBack())")
                    !!}     
                </div>
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