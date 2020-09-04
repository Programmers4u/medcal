@extends('layouts.app')

@section('css')
@parent
<link rel="stylesheet" href="{{ asset('css/datetime.css') }}">
@endsection

@section('title', 'Kalendarz' )
@section('subtitle', '')

@section('content')

<div>@include('manager.contacts._modalcalendar')</div>
<div>@include('manager.contacts._modal_appocalendar')</div>
<div>@include('manager.contacts._modal_contactadd')</div>
<div>
<div class="modal" id="alertModal" tabindex="-3" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title" id="exampleModalLabel">Alert</h3>
      </div>
      <div class="modal-body">
        <div style="display:none;" id="mc_info_success" class="alert alert-success"></div>
        <div style="display:none;" id="mc_info_error" class="alert alert-danger"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-lg-12" style="border-right:0px solid #afafaf;min-height:50px;position:relative;width:100%;">
        <div class="hr-box" style="display:block;">
            <a class="btn btn-default btn-block" style="display:inline-block;max-width:200px;" onclick="setCookie('');" href="javascript:document.location.reload();">Wszystkie kalendarze</a> 
            @foreach ($humanresources as $hr)
                <a class="btn btn-block" style="display:inline-block;max-width:200px; background-color:{{$hr->color}};color:#FFFFFF;" href="javascript:changeHr({{$hr->id}}, '{{$hr->name}}')">{{$hr->name}}</a>    
            @endforeach
        </div>
        <div id='mini_cal'></div>
    </div>
</div>

<div class="row fullcalendar">
    <div id="calendar" style="margin-left:3%;margin-right:3%;"></div>

    <div class="well" style="margin:1%;">{{ $icalURL }}</div>
</div>

@endsection

@push('footer_scripts')
<script type="text/javascript" src="/js/alert/alert.min.js"></script>
<script type="text/javascript" src="/js/calendar/calendar.min.js"></script>
<script type="text/javascript" src="/js/cookie/cookie.min.js"></script>
<script type="text/javascript" src="/js/appointment/appointment.min.js"></script>
<script type="text/javascript" src="/js/statistics/statistics.min.js"></script>

<script type="text/javascript">
var csrf = '{{csrf_token()}}';   
var businessId = '{{ $business->id }}';
var serviceId = '{{ $services[0]->id }}';

var Statistics = Object.create(Statistics);
Statistics.csrf = '{{csrf_token()}}';
Statistics.businessId = '{{ $business->id }}';
Statistics.endPoint = '/statistics';

var AppointmentSave = Object.create(Appointment);
AppointmentSave.csrf = '{{csrf_token()}}';
AppointmentSave.businessId = '{{ $business->id }}';
AppointmentSave.endPoint = '/book';

var AppointmentChange = Object.create(Appointment);
console.log(AppointmentChange);
AppointmentChange.csrf = '{{csrf_token()}}';
AppointmentChange.businessId = '{{ $business->id }}';

var AppointmentHr = Object.create(Appointment);
AppointmentHr.csrf = '{{csrf_token()}}';
AppointmentHr.businessId = '{{ $business->id }}';
AppointmentHr.endPoint = '{{ route('api.calendar.ajax') }}';

$(document).ready(function() {

    var cookie = getCookie().split(',');
    var whos = getAsystaCook();

    if(whos){
        whos = whos.split('^');
        for(var i=0;i<whos.length-1;i++){
            who = whos[i].split(',');
            asysta(who[0],who[1]);
            //console.log(who);
        };
    }

    calendar();

    if(cookie[0]!='')
        changeHr(cookie[0],cookie[1]);
});

var changeHr = function (id,name) {
    setCookie(id+','+name);
    humanresources = id;
    url = document.location.protocol+'\/\/'+document.location.host+document.location.pathname.substring(0,document.location.pathname.lastIndexOf('/'));
    is = url.lastIndexOf('calendar')
    url = (is === -1) ? url+'/calendar/'+humanresources : url+'/'+humanresources;
    $('h1').html('<b>Kalendarz dla: '+name+'</b>');

    AppointmentHr.post = {
        ...AppointmentHr.post,
        businessId : '{{ $business->id }}',
        hr : humanresources,
        start_at : start_at,
        csrf : csrf,
    }
    AppointmentHr.get(function(data) {
        timegrid.events = data;
        $("#calendar").fullCalendar('removeEvents');
        $("#calendar").fullCalendar('addEventSource',timegrid.events);
    })
}
</script>

<script type="text/javascript">
var clickLink = function(obj) {
  var link = "{{ route('medical.document.link',[$business,0]) }}";
  link = link.replace('0','');
  link+=app_meeting_Id;
  document.location = link;
  return false;
}
</script>

<script src="{{ asset('js/tour.min.js') }}"></script>
<script type="text/javascript">
// Instance the tour
var tour = new Tour({
  duration: 10000,
  delay: 100,
  template: "@include('tour._template')",
  onEnd: function(tourDashboard){

    $('#btnVacancies').tooltipster({
          animation: 'fade',
          delay: 200,
          theme: 'tooltipster-timegrid',
          touchDevices: true,
          content: $('<strong>{!! trans('manager.business.hint.set_services') !!}</strong>')
    }).tooltipster('show');

  },
  steps: [
  {
    element: "#activecal",
    title: "{{ trans('tour.dashboard.panel.title') }}",
    content: "{{ trans('tour.dashboard.panel.content') }}",
    duration: 18000,
    placement: "top",
  },
]});
$(document).ready(function(){

// Initialize the tour
tour.init();

// Start the tour
tour.start();

$('.fc-prev-button.fc-button.fc-state-default.fc-corner-left').click(function(){
    try{
        AppointmentHr.get(function(data) {
            timegrid.events = data;
            $("#calendar").fullCalendar('removeEvents');
            $("#calendar").fullCalendar('addEventSource',timegrid.events);
        });        
    }catch(e){
        alert(e);
    }
});

$('.fc-next-button.fc-button.fc-state-default.fc-corner-right').click(function(){
    try{
        AppointmentHr.get(function(data) {
            timegrid.events = data;
            $("#calendar").fullCalendar('removeEvents');
            $("#calendar").fullCalendar('addEventSource',timegrid.events);
        });        
    }catch(e){
        alert(e);
    };
});

$('.fc-today-button.fc-button.fc-state-default.fc-corner-left.fc-corner-right').click(function(){
    try{
        AppointmentHr.get(function(data) {
            timegrid.events = data;
            $("#calendar").fullCalendar('removeEvents');
            $("#calendar").fullCalendar('addEventSource',timegrid.events);
        });        
    }catch(e){
        alert(e);
    };
});
    
});
</script>

@endpush